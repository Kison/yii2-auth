<?php
namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Denis Kison
 */
class AuthAsset extends AssetBundle {

    public $js = [
        'js/scripts.js',
    ];

    public $depends = [
        AppAsset::class
    ];
}
