<?php
defined('YII_DEBUG') or define('YII_DEBUG', false);
defined('YII_ENV') or define('YII_ENV', 'prod');

require(dirname(__DIR__) . '/src/vendor/autoload.php');
require(dirname(__DIR__) . '/src/vendor/yiisoft/yii2/Yii.php');
require(dirname(__DIR__) . '/src/common/config/bootstrap.php');
require(dirname(__DIR__) . '/src/frontend/config/bootstrap.php');

$config = yii\helpers\ArrayHelper::merge(
    require(dirname(__DIR__) . '/src/common/config/main.php'),
    require(dirname(__DIR__) . '/src/common/config/main-local.php'),
    require(dirname(__DIR__) . '/src/frontend/config/main.php'),
    require(dirname(__DIR__) . '/src/frontend/config/main-local.php')
);

$application = new yii\web\Application($config);
$application->run();
