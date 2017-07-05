<?php
namespace app\components\firebase\phone;

use yii\base\Model;
use yii\base\UnknownPropertyException;
use yii\base\Widget;
use yii\web\View;
use yii\web\JqueryAsset;

/**
 * Helps with authentication via firebase
 * @date 02.07.2017
 */
class FirebasePhoneAuthWidget extends Widget {

    /** @var string - button selector */
    public $idPrefix = 'firebase-phone-auth-widget-';

    /** @var Model - form model */
    public $model = null;
    /** @var string */
    public $title = 'Authenticate with phone';
    /** @var string */
    public $buttonTitle = 'Authenticate';
    /** @var string - js code which runs on successful authentication */
    public $onSuccess = '';


    /** @var string - form identifier */
    protected $formId;
    /** @var string - button selector */
    protected $phoneButtonId;
    /** @var string - phone input id */
    protected $phoneInputId;
    /** @var string - apply code button id */
    protected $codeButtonId;
    /** @var string - code input id */
    protected $codeInputId;
    /** @var string - resend code button id */
    protected $resendCodeButtonId;
    /** @var string - error box id */
    protected $errorBoxId;
    /** @var string - change phone button id */
    protected $changePhoneButtonId;
    /** @var string - cancel phone auth button id */
    protected $cancelPhoneAuthButtonId;

    /** @var string - path alias to views */
    public $viewsPathAlias = "@app/components/firebase/phone/views/";
    /** @var string - path alias to assets */
    public $assetsPathAlias = "@app/components/firebase/phone/assets/";

    /** @inheritdoc */
    public function init() {
        parent::init();
        FirebasePhoneAuthWidgetAsset::register($this->getView());

        if (!$this->model) {
            throw new \RuntimeException("Need to set model");
        }

        $this->formId = "{$this->idPrefix}form";
        $this->phoneInputId = "{$this->idPrefix}phone-input";
        $this->phoneButtonId = "{$this->idPrefix}phone-apply";
        $this->codeInputId = "{$this->idPrefix}code-input";
        $this->codeButtonId = "{$this->idPrefix}code-apply";
        $this->resendCodeButtonId = "{$this->idPrefix}resend-code";
        $this->errorBoxId = "{$this->idPrefix}error-box";
        $this->changePhoneButtonId = "{$this->idPrefix}change-phone";
        $this->cancelPhoneAuthButtonId = "{$this->idPrefix}cancel-auth";


        $this->getView()->registerJs(<<<JS
            $(document).on("firebase:phoneVerified", function(event, user){
                {$this->onSuccess}
            });
JS
        );
    }

    /** @inheritdoc */
    public function run() {
        $content = $this->getView()->render($this->viewsPathAlias . 'form', [
            'widget'  => $this
        ]);
        return $content;
    }

    /** @return string */
    public function getFormId() {
        return $this->formId;
    }

    /** @return string */
    public function getPhoneInputId() {
        return $this->phoneInputId;
    }

    /** @return string */
    public function getPhoneButtonId() {
        return $this->phoneButtonId;
    }

    /** @return string */
    public function getCodeInputId() {
        return $this->codeInputId;
    }

    /** @return string */
    public function getCodeButtonId() {
        return $this->codeButtonId;
    }

    /** @return string */
    public function getResendCodeButtonId() {
        return $this->resendCodeButtonId;
    }

    /** @return string */
    public function getErrorBoxId() {
        return $this->errorBoxId;
    }

    /** @return string */
    public function getChangePhoneButtonId() {
        return $this->changePhoneButtonId;
    }
}
