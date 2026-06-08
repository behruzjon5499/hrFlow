<?php

use common\components\log\ErrorHandler;
require_once dirname(__DIR__).'/helpers/function.php';
$config = [
    'homeUrl' => Yii::getAlias('@apiUrl'),
    'controllerNamespace' => 'api\controllers',
    'defaultRoute' => 'site/index',
    'bootstrap' => ['maintenance'],
    'modules' => [
        'auth' => \api\modules\auth\Module::class,
        'backend' => \api\modules\backend\Module::class,
        'common' => \api\modules\common\Module::class,
        'admin' => \api\modules\admin\Module::class,
        'client' => \api\modules\client\Module::class,
        'control' => \api\modules\control\Module::class,
    ],
    'components' => [
        'errorHandler' => [
            'class' => ErrorHandler::class,
            'errorAction' => 'site/error'
        ],
        'maintenance' => [
            'class' => common\components\maintenance\Maintenance::class,
            'enabled' => function ($app) {
                if (env('APP_MAINTENANCE') === '1') {
                    return true;
                }
                return $app->keyStorage->get('frontend.maintenance') === 'enabled';
            }
        ],
        'request' => [
            'enableCookieValidation' => false,
            'parsers' => [
                'application/json' => 'yii\web\JsonParser'
            ],
            'secureProtocolHeaders' => ['X-Forwarded-Proto' => ['https']],
        ],
        'user' => [
            'class' => yii\web\User::class,
            'identityClass' => common\models\User::class,
            'loginUrl' => ['/user/sign-in/login'],
            'enableAutoLogin' => true,
            'as afterLogin' => common\behaviors\LoginTimestampBehavior::class
        ]
    ]
];

return $config;
