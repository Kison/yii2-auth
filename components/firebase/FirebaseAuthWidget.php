<?php
namespace app\components\firebase;

use app\helpers\AppHelper;
use yii\base\Widget;
use yii\web\View;

/**
 * Helps with authentication via firebase
 * @date 02.07.2017
 */
class FirebaseAuthWidget extends Widget {

    /** @inheritdoc */
    public function init() {
        FirebaseAsset::register($this->getView());
        $firebase = AppHelper::getFirebase();
        $config = $firebase->getConfig();
        $config = json_encode($config);

        $scripts = <<<FIREBASE
            // Initialize Firebase            
            firebase.initializeApp({$config});
FIREBASE;

        $this->getView()->registerJs($scripts, View::POS_END);
        parent::init();
    }

    /** @inheritdoc */
    public function run() {
        return "";
    }
}
