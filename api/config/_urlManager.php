<?php
return [
    'class' => 'yii\web\UrlManager',
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
        'control/<controller>/<action>/<id:\d+>' => 'control/<controller>/<action>',
    ]
];
