<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/admin.css',
        'css/skin-blue.css',
        'css/font-awesome/css/font-awesome.css',
        'css/jquery-confirm.min.css'
    ];
    public $js = [
        'js/admin-main.js',
        'js/jquery-confirm.min.js',
        'js/custom.js'
        //'js/bootstrap.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
