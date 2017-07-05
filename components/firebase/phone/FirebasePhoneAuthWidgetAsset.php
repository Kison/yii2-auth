<?php
namespace app\components\firebase\phone;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

/**
 * Asset for the FirebasePhoneAuthWidget
 * @date 05.07.2017
 */
class FirebasePhoneAuthWidgetAsset extends AssetBundle {

    public $sourcePath = "@app/components/firebase/phone/assets";

    public $depends = [
        JqueryAsset::class
    ];

    public $js = [
        'scripts/scripts.js',
    ];
}