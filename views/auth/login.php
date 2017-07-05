<?php
    /**
     * @var $this yii\web\View
     * @var $form yii\bootstrap\ActiveForm
     * @var $model app\models\auth\forms\LoginForm
     */
    use app\components\firebase\FirebaseAuthWidget;
    use yii\helpers\Html;
    use yii\bootstrap\ActiveForm;
    use rmrevin\yii\fontawesome\FA;
    use app\components\firebase\providers\{FirebaseFacebookAuthProvider, FirebaseTwitterAuthProvider};

    $this->title = 'Sign in';

    $this->registerJsFile(Yii::getAlias('@web') . '/js/auth.js', ['depends' => [yii\web\JqueryAsset::className()]]);
?>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <?php $form = ActiveForm::begin([
            'id'    => 'authentication-form',
            'options' => [
                    'class' => 'well well-lg auth-border no-back'
            ]
        ]); ?>

        <h1 class="mt0px">Sign in</h1>
        <?= $form->field($model, 'email')->textInput(['class' => 'form-control input-lg auth-border', 'placeholder' => 'Email'])->label(false) ?>
        <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Password', 'class' => 'form-control input-lg auth-border'])->label(false) ?>

        <div class="row">
            <div class="col-md-12 mb-10px-width-less-then-1024px">
                <?= Html::submitButton('Sign in', ['class' => 'btn btn-lg btn-default btn-block auth-border', 'name' => 'sign-in-button']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>

        <div id="phone-widget-wrapper" class="hidden">
            <?= \app\components\firebase\phone\FirebasePhoneAuthWidget::widget([
                'title'                 => 'Sign in with phone',
                'buttonTitle'           => 'Sign in',
                'model'                 => new \app\models\auth\forms\PhoneForm(),
                'onSuccess'             => <<<JS
                    user.getIdToken().then(function (token) {
                        var params = {                    
                            'firebase_access_token'      : token,
                            'firebase_user_id'           : user.uid,
                            'phone'                      : user.phoneNumber                    
                        };
                                
                        $.post('firebase/phone', params, function(data) {
                            console.log(data);
                        });
                    });  
JS
            ]) ?>
        </div>
    </div>
</div>

<?php
    // Facebook auth
    FirebaseAuthWidget::widget([
        'provider'          => new FirebaseFacebookAuthProvider(),
        'buttonSelector'    => '[name=\"facebook-sign-in-button\"]',
        'action'            => FirebaseAuthWidget::ACTION_REGISTER
    ]);

    // Twitter auth
    FirebaseAuthWidget::widget([
        'provider'          => new FirebaseTwitterAuthProvider(),
        'buttonSelector'    => '[name=\"twitter-sign-in-button\"]',
        'action'            => FirebaseAuthWidget::ACTION_REGISTER
    ]);
?>

<!-- Social and Phone login -->
<div class="row">
    <div class="col-md-2 col-md-offset-3 mb-10px-width-less-then-1024px">
        <?= Html::button(FA::i('facebook'), [
            'class'             => 'btn btn-lg btn-default btn-block auth-border',
            'name'              => 'facebook-sign-in-button',
            'data-toggle'       => 'tooltip',
            'data-placement'    => 'top',
            'title'             => 'Sign in with Facebook'
        ]) ?>
    </div>

    <div class="col-md-2 mb-10px-width-less-then-1024px">
        <?= Html::button(FA::i('twitter'), [
            'class'             => 'btn btn-lg btn-default btn-block auth-border',
            'name'              => 'twitter-sign-in-button',
            'data-toggle'       => 'tooltip',
            'data-placement'    => 'top',
            'title'             => 'Sign in with Twitter'
        ]) ?>
    </div>

    <div class="col-md-2 phone-auth-button-wrapper">
        <?= Html::button(FA::i('phone'), [
            'class'             => 'btn btn-lg btn-default btn-block auth-border',
            'name'              => 'phone-auth-button',
            'data-toggle'       => 'tooltip',
            'data-placement'    => 'top',
            'title'             => 'Sign in with Phone'
        ]) ?>
    </div>

    <div class="col-md-2 email-auth-button-wrapper hidden">
        <?= Html::button(FA::i('envelope'), [
            'class'             => 'btn btn-lg btn-default btn-block auth-border',
            'name'              => 'email-auth-button',
            'data-toggle'       => 'tooltip',
            'data-placement'    => 'top',
            'title'             => 'Sign in with Email'
        ]) ?>
    </div>
</div>

<div class="row">
    <div class="col-md-6 col-md-offset-3 mt-10px">
        <p class="text-center"><?= Html::a("Don`t have an account?", ['auth/register'], ['class' => 'text-black']) ?></p>
    </div>
</div>
