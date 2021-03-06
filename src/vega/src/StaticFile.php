<?php

namespace Mix\Vega;

use Mix\Vega\Exception\NotFoundException;

/**
 * Trait StaticFile
 * @package Mix\Vega
 */
trait StaticFile
{

    /**
     * @param string $path
     * @param string $root
     */
    public function static(string $path, string $root)
    {
        if (substr($path, -1, 1) == '/') {
            $path = substr($path, 0, -1);
        }
        $pattern = $path . '/{any:.+}';
        $this->handleFunc($pattern, function (Context $ctx) use ($root, $path) {
            $uriPath = $ctx->uri()->getPath();
            $file = sprintf('%s%s', $root, substr($uriPath, strlen($path)));
            if (!file_exists($file)) {
                throw new NotFoundException('404 Not Found', 404);
            }

            // 防止相对路径攻击
            // 如：/static/../../foo.php
            $realpath = (string)realpath($file);
            if ($root !== substr($realpath, 0, strlen($root))) {
                throw new NotFoundException('404 Not Found', 404);
            }

            $ctx->response->sendfile($realpath);
        })->methods('GET');
    }

    /**
     * @param string $path
     * @param string $file
     */
    public function staticFile(string $path, string $file)
    {
        $this->handleFunc($path, function (Context $ctx) use ($file) {
            $ctx->response->sendFile($file);
        })->methods('GET');
    }

}
