<?php
return [
    'class' => 'codemix\localeurls\UrlManager',
    'languages' => ['uz', 'ru', 'en','cr'],
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'enableStrictParsing' => false,
    'rules' => [
        '' => 'site/index',  // this line should be chenged to ''=>''.
        '<controller:\w+>/<action:\w+>/' => '<controller>/<action>',
    ],
];
