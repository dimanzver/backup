<?php
define('YII_START', microtime(true));
require(__DIR__ . '/../vendor/autoload.php');

setlocale(LC_ALL, 'ru_RU.utf8');
$dotenv = Dotenv\Dotenv::createUnsafeImmutable(dirname(__DIR__));
$dotenv->load();
require __DIR__ . '/../helpers/helpers.php';

defined('YII_DEBUG') or define('YII_DEBUG', env('YII_DEBUG'));
defined('YII_ENV') or define('YII_ENV', env('YII_ENV'));
define('ROOT_PATH', dirname(__DIR__));

require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

$config = require __DIR__ . '/../config/web.php';
(new yii\web\Application($config))->run();

//var_dump(microtime(true) - YII_START);