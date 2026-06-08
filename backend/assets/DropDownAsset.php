<?php


namespace backend\assets;


use yii\web\AssetBundle;

class DropDownAsset extends AssetBundle
{
    /**
     * @var string
     */
    public $sourcePath = '@backend/assets/web';

    public $publishOptions = [
        'forceCopy' => true,
    ];
    public $css = [
        'css/style.css',
        'css/file.css',
    ];
    /**
     * @var array
     */
    public $js = [
        'js/main.js',
        'js/file.js',
    ];

    /**
     * @var array
     */
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}