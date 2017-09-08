<?php

// console入口文件

date_default_timezone_set('PRC');

define('MIX_DEBUG', true);
define('MIX_ENV', 'dev');
define('DS', DIRECTORY_SEPARATOR);

require __DIR__ . '/../../../vendor/autoload.php';
require __DIR__ . '/../../../mixphp/mix1/Mix.php';

$config = require __DIR__ . '/../config/main.php';

(new mix\console\Application($config))->run();