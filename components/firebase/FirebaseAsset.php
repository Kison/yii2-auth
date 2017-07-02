<?php
namespace app\components\firebase;

use yii\web\AssetBundle;

/**
 * Firebase asset bundle
 * @author Denis Kison
 * @date 02.07.2017
 */
class FirebaseAsset extends AssetBundle {

    public $jsOptions = [
        'position' => \yii\web\View::POS_END
    ];

    public $js = [
        '//www.gstatic.com/firebasejs/4.1.3/firebase.js',
    ];
}
