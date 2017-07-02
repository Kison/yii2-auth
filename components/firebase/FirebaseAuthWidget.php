<?php
namespace app\components\firebase;

use app\helpers\AppHelper;
use app\components\firebase\providers\FirebaseAuthProvider;
use yii\base\Widget;
use yii\web\View;

/**
 * Helps with authentication via firebase
 * @date 02.07.2017
 */
class FirebaseAuthWidget extends Widget {

    const ACTION_LOGIN = 'login';
    const ACTION_REGISTER = 'register';

    /** @var FirebaseAuthProvider; */
    public $provider = null;
    /** @var string - button selector */
    public $buttonSelector = null;
    /** @var string */
    public $action = null;

    /** @inheritdoc */
    public function init() {
        if (!$this->provider) {
            throw new \RuntimeException("Need to set auth provider");
        }

        if (!$this->buttonSelector) {
            throw new \RuntimeException("Need to set button id");
        }

        if (!$this->action) {
            throw new \RuntimeException("Need to set action");
        }

        $scripts = <<<FIREBASE
            $('{$this->buttonSelector}').on('click', function() {
                {$this->provider->getCode()}
                firebaseAuthentication(provider);
            });                        
FIREBASE;

        $this->getView()->registerJs($scripts, View::POS_END);
        parent::init();
    }

    /** @inheritdoc */
    public function run() {
        return "";
    }
}
