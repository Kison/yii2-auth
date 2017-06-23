<?php
namespace app\assets;

use yii\web\AssetBundle;
use rmrevin\yii\fontawesome\AssetBundle as FontAwesomeAssetBundle;
use yii\bootstrap\BootstrapPluginAsset;
use yii\web\YiiAsset;

/**
 * @author Denis Kison
 */
class AppAsset extends AssetBundle {

    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'css/site.css',
    ];

    public $js = [
        'js/scripts.js',
    ];

    public $depends = [
        YiiAsset::class,
        FontAwesomeAssetBundle::class,
        BootstrapPluginAsset::class
    ];
}
