<?php
require_once dirname(__DIR__).'/../api/helpers/function.php';
$config = [
//    'homeUrl' => Yii::$app->homeUrl,
    'controllerNamespace' => 'backend\controllers',
    'defaultRoute' => 'site/index',
//    'on beforeRequest' => function ($event) {
//        if(!Yii::$app->request->isSecureConnection){
//            $url = Yii::$app->request->getAbsoluteUrl();
//            $url = str_replace('http:', 'https:', $url);
//            Yii::$app->getResponse()->redirect($url);
//            Yii::$app->end();
//        }
//    },
    'components' => [
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'request' => [
            'cookieValidationKey' => env('BACKEND_COOKIE_VALIDATION_KEY'),
            'baseUrl' => env('BACKEND_BASE_URL'),
            'enableCsrfValidation' => false,
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@app/views' => '@app/views/lte'
                ],
            ],
        ],
        'user' => [
            'class' => yii\web\User::class,
            'identityClass' => common\models\User::class,
            'loginUrl' => ['sign-in/login'],
            'enableAutoLogin' => true,
            'as afterLogin' => common\behaviors\LoginTimestampBehavior::class,
        ],
    ],
    'modules' => [
        'file' => [
            'class' => backend\modules\file\Module::class,
        ],
        'system' => [
            'class' => backend\modules\system\Module::class,
        ],
        'translation' => [
            'class' => backend\modules\translation\Module::class,
        ],
        'rbac' => [
            'class' => backend\modules\rbac\Module::class,
            'defaultRoute' => 'rbac-auth-item/index',
        ],
        'admin' => [
            'class' => 'mdm\admin\Module',
            //'layout' => 'top-menu',
            'mainLayout' => '@app/views/layouts/in.php',
            'menus' => [
                /*'assignment' => [
                    'label' => 'Grant Access' // change label
                ],*/
                'user' => null, // disable menu
                'rule' => null, // disable menu
            ],
            'controllerMap' => [
                'assignment' => [
                    'class' => 'mdm\admin\controllers\AssignmentController',
                    'idField' => 'id',
                    'usernameField' => 'username',
                    'extraColumns' => [
                        [
                            'attribute' => 'role_name',
                            'label' => 'Role',
                            'value' => function (
                                $model,
                                $key,
                                $index,
                                $column
                            ) {
                                return $model->username;
                            },
                        ],
                    ],

                ],
            ],
        ],
    ],
    'as globalAccess' => [
        'class' => common\behaviors\GlobalAccessBehavior::class,
        'rules' => [
            [
                'controllers' => ['sign-in'],
                'allow' => true,
                'roles' => ['?'],
                'actions' => ['login'],
            ],
            [
                'controllers' => ['sign-in'],
                'allow' => true,
                'roles' => ['?'],
                'actions' => ['google'],
            ],
            [
                'controllers' => ['sign-in'],
                'allow' => true,
                'roles' => ['?'],
                'actions' => ['callback-google'],
            ],
            [
                'controllers' => ['sign-in'],
                'allow' => true,
                'roles' => ['@'],
                'actions' => ['logout'],
            ],
            [
                'controllers' => ['site'],
                'allow' => true,
                'roles' => ['?', '@'],
                'actions' => ['error'],
            ],
            [
                'controllers' => ['record'],
                'allow' => true,
                'roles' => ['?', '@'],
                'actions' => ['records'],
            ],
//            [
//                'controllers' => ['debug/default'],
//                'allow' => true,
//                'roles' => ['?'],
//            ],
//            [
//                'controllers' => ['user'],
//                'allow' => true,
//                'roles' => ['administrator'],
//            ],
//            [
//                'controllers' => ['user'],
//                'allow' => false,
//            ],
            [
                'allow' => true,
                'roles' => ['@'],
            ],
        ],
    ],
];

if (YII_ENV_DEV) {
    $config['modules']['gii'] = [
        'class' => yii\gii\Module::class,
        'generators' => [
            'crud' => [
                'class' => yii\gii\generators\crud\Generator::class,
                'templates' => [
                    'yii2-starter-kit' => Yii::getAlias('@backend/views/_gii/templates'),
                ],
                'template' => 'yii2-starter-kit',
                'messageCategory' => 'backend',
            ],
        ],
    ];
}

return $config;
