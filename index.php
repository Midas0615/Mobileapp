<?php
error_reporting(0);
ini_set('error_reporting',0);
define('DS', DIRECTORY_SEPARATOR);
define('DEVELOPMENT', file_exists(dirname(__FILE__) . DS . "development") ? true : true);

ini_set('set_time_zone', 'Asia/Kalkata');
// change the following paths if necessary
$yii = dirname(__FILE__) . '/../yii/framework/yii.php';
$config = dirname(__FILE__) . '/protected/config/main.php';


// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG', DEVELOPMENT);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);
require_once($yii);
Yii::createWebApplication($config)->run();
