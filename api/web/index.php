<?php
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV') or define('YII_ENV', 'dev');

// Composer
require(__DIR__ . '/../../vendor/autoload.php');

// Environment
require(__DIR__ . '/../../common/env.php');

// Yii
require(__DIR__ . '/../../vendor/yiisoft/yii2/Yii.php');

// Bootstrap application
require(__DIR__ . '/../../common/config/bootstrap.php');
require(__DIR__ . '/../config/bootstrap.php');

$config = \yii\helpers\ArrayHelper::merge(
  require(__DIR__ . '/../../common/config/base.php'),
  require(__DIR__ . '/../../common/config/web.php'),
  require(__DIR__ . '/../config/base.php'),
  require(__DIR__ . '/../config/web.php')
);

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Credentials: true");
header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token, Access-Control-Allow-Headers, Authorization, X-Requested-With');
//header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token , Authorization, Accept, Referer, User-Agent');

//
//$allowedOrigins = ['http://ebirja.uz', 'http://localhost:3000'];
//$origin = $_SERVER['HTTP_ORIGIN'];
//
//if (in_array($origin, $allowedOrigins)) {
//  header('Access-Control-Allow-Origin: ' . $origin);
//  header('Access-Control-Allow-Credentials: true');
//  header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
//  header('Access-Control-Max-Age: 1000');
//  header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token, Authorization');
//}

(new yii\web\Application($config))->run();
