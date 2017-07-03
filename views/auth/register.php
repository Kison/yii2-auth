<?php
    use app\components\firebase\FirebaseAuthWidget;
    use yii\helpers\Html;
    use yii\bootstrap\ActiveForm;
    use rmrevin\yii\fontawesome\FA;
    use app\components\firebase\providers\{FirebaseFacebookAuthProvider, FirebaseTwitterAuthProvider};
    use app\components\firebase\FirebaseWidget;

    /**
     * @var $this yii\web\View
     * @var $form yii\bootstrap\ActiveForm
     * @var $model app\models\auth\forms\RegisterForm
     */

    $this->title = 'Sign up'
?>

<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <?php $form = ActiveForm::begin([
            'id'    => 'authentication-form',
            'options' => [
                'class' => 'well well-lg auth-border no-back'
            ]
        ]); ?>

        <h1 class="mt0px">Sign up</h1>
        <?= $form->field($model, 'email')->textInput(['autofocus' => true, 'class' => 'form-control input-lg auth-border', 'placeholder' => 'Email'])->label(false) ?>
        <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Password', 'class' => 'form-control input-lg auth-border'])->label(false) ?>

        <div class="row">
            <div class="col-md-12 mb-10px-width-less-then-1024px">
                <?= Html::submitButton('Sign up', ['class' => 'btn btn-lg btn-default btn-block auth-border', 'name' => 'sign-up-button']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>


<?php
    // Initialize firebase
    FirebaseWidget::widget();

    // Facebook auth
    FirebaseAuthWidget::widget([
        'provider'          => new FirebaseFacebookAuthProvider(),
        'buttonSelector'    => '[name=\"facebook-sign-up-button\"]',
        'action'            => FirebaseAuthWidget::ACTION_REGISTER
    ]);

    // Twitter auth
    FirebaseAuthWidget::widget([
        'provider'          => new FirebaseTwitterAuthProvider(),
        'buttonSelector'    => '[name=\"twitter-sign-up-button\"]',
        'action'            => FirebaseAuthWidget::ACTION_REGISTER
    ]);
?>


<div class="row">
    <div class="col-md-2 col-md-offset-3 mb-10px-width-less-then-1024px">
        <?= Html::button(FA::i('facebook'), [
            'class'             => 'btn btn-lg btn-default btn-block auth-border',
            'name'              => 'facebook-sign-up-button',
            'data-toggle'       => 'tooltip',
            'data-placement'    => 'top',
            'title'             => 'Sign up with Facebook'
        ]) ?>
    </div>

    <div class="col-md-2 mb-10px-width-less-then-1024px">
        <?= Html::button(FA::i('twitter'), [
            'class'             => 'btn btn-lg btn-default btn-block auth-border',
            'name'              => 'twitter-sign-up-button',
            'data-toggle'       => 'tooltip',
            'data-placement'    => 'top',
            'title'             => 'Sign up with Twitter'
        ]) ?>
    </div>

    <div class="col-md-2">
        <?= Html::button(FA::i('phone'), [
            'class'             => 'btn btn-lg btn-default btn-block auth-border',
            'name'              => 'phone-sign-up-button',
            'data-toggle'       => 'tooltip',
            'data-placement'    => 'top',
            'title'             => 'Sign up with Phone'
        ]) ?>
    </div>
</div>

<div class="row">
    <div class="col-md-6 col-md-offset-3 mt-10px">
        <p class="text-center"><?= Html::a("Already have an account?", ['auth/login'], ['class' => 'text-black']) ?></p>
    </div>
</div>