<?php
namespace app\components\firebase\phone;

use yii\base\Model;
use yii\base\Widget;
use yii\web\View;

/**
 * Helps with authentication via firebase
 * @date 02.07.2017
 */
class FirebasePhoneAuthWidget extends Widget {

    /** @var string - button selector */
    public $buttonId = null;
    /** @var string - form identifier */
    public $formId = null;
    /** @var string - phone input id */
    public $phoneInputId = null;
    /** @var Model - form model */
    public $model = null;
    /** @var string */
    public $title = 'Authenticate with phone';
    /** @var string */
    public $buttonTitle = 'authenticate';
    /** @var string - js code which runs on successful authentication */
    public $onSuccess = '';


    /** @var string - path alias to views */
    public $viewsPathAlias = "@app/components/firebase/phone/views/";

    /** @inheritdoc */
    public function init() {
        if (!$this->buttonId) {
            throw new \RuntimeException("Need to set button id");
        }

        if (!$this->model) {
            throw new \RuntimeException("Need to set model");
        }

        if (!$this->formId) {
            throw new \RuntimeException("Need to set form id");
        }

        if (!$this->phoneInputId) {
            throw new \RuntimeException("Need to set phone input id");
        }

        $scripts = <<<FIREBASE
            $(document).on("global:load", function(){                
                window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('{$this->formId}-recaptcha-container');
            });
                
            (function(){                                
                $('#{$this->phoneInputId}').on('change keyup', updateSignInButtonUI);                
                $('#{$this->formId}-code-input').on('change keyup', updateCodeButtonUI);                
                    
                $('#{$this->buttonId}').on('click', function(){                    
                    if (isPhoneNumberValid()) {
                        window.signingIn = true;
                        updateSignInButtonUI();
                        var phoneNumber = getPhoneNumberFromUserInput();
                        var appVerifier = window.recaptchaVerifier;
                                 
                        $('.phone-first-step').addClass('hidden');
                                                                                                                        
                        firebase.auth().signInWithPhoneNumber(phoneNumber, appVerifier)
                            .then(function(confirmationResult) {
                                window.signingIn = false;
                                updateSignInButtonUI();
                                resetRecaptcha();
                                
                                $('.phone-second-step').addClass('hidden');
                                $('.phone-third-step').removeClass('hidden');
                                                                                                                                                                
                                // SMS sent. Prompt user to type the code from the message, then sign the
                                // user in with confirmationResult.confirm(code).
                                                                
                                $('#{$this->formId}-code-button').on('click', function() {                                        
                                    confirmationResult.confirm(getCodeFromUserInput()).then(function(result) {
                                        $('#{$this->formId}-code-button').off('click');                                                                                                                       
                                        var credential = firebase.auth.PhoneAuthProvider.credential(
                                            confirmationResult.verificationId, 
                                            getCodeFromUserInput()
                                        );                                                                                                                   
                                        {$this->onSuccess}
                                        
                                    }).catch(function (error) {
                                        console.error('Error while checking the verification code', error);
                                        window.alert('Error while checking the verification code:'+ error.code + error.message);
                                    });                                        
                                })                                                                                              
                        }).catch(function(error) {
                            // Error; SMS not sent
                            window.signingIn = false;
                            console.error('Error during signInWithPhoneNumber', error);
                            window.alert('Error during signInWithPhoneNumber:' + error.code + error.message);
                            updateSignInButtonUI();
                            resetRecaptcha();
                        });
                    }            
                });    
                                                         
                function getPhoneNumberFromUserInput() {
                    return $('#{$this->phoneInputId}').val();
                }
                                 
                function getCodeFromUserInput() {
                    return $('#{$this->formId}-code-input').val();
                }
                                
                function isCodeValid() {
                    var pattern = /^[0-9]+$/,
                        code = getCodeFromUserInput();                                                   
                    return phoneNumber.search(pattern) !== -1;
                }
                                
                function isPhoneNumberValid() {
                    var pattern = /^\+[0-9\s\-\(\)]+$/,
                        phoneNumber = getPhoneNumberFromUserInput();                                                   
                    return phoneNumber.search(pattern) !== -1;
                }
                                
                function resetRecaptcha() {
                    return window.recaptchaVerifier.render().then(function(widgetId) {
                        grecaptcha.reset(widgetId);
                    });
                }
                                
                function updateSignInButtonUI() {                    
                    $('#{$this->buttonId}').prop('disabled', (!isPhoneNumberValid() || !!window.signingIn));                                                                                                      
                }
                    
                function updateCodeButtonUI() {                    
                    $('#{$this->formId}-code-button').prop('disabled', (!isPhoneNumberValid() || !!window.signingIn));                                                                                                      
                }
            })();                                                                                                                                                                          
FIREBASE;

        $this->getView()->registerJs($scripts, View::POS_END);
        parent::init();
    }

    /** @inheritdoc */
    public function run() {
        $content = $this->getView()->render($this->viewsPathAlias . 'form', [
            'widget'  => $this
        ]);
        return $content;
    }
}
