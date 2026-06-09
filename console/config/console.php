<?php
require_once dirname(__DIR__).'../../api/helpers/function.php';

return [
    'id' => 'console',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'console\controllers',
    'params' => require __DIR__ . '/../../common/config/params.php',
    'language' => 'uz',
    'sourceLanguage' => 'uz',
    'controllerMap' => [
        'command-bus' => [
            'class' => trntv\bus\console\BackgroundBusController::class,
        ],
        'migrate' => [
            'class' => yii\console\controllers\MigrateController::class,
            'migrationPath' => '@common/migrations/db',
            'migrationTable' => '{{%system_db_migration}}'
        ],
        'rbac-migrate' => [
            'class' => console\controllers\RbacMigrateController::class,
            'migrationPath' => '@common/migrations/rbac/',
            'migrationTable' => '{{%system_rbac_migration}}',
            'templateFile' => '@common/rbac/views/migration.php'
        ],
    ],
];
