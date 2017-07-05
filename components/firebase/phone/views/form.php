<?php
    /**
     * @var \app\components\firebase\phone\FirebasePhoneAuthWidget $widget
     */
    use yii\helpers\Html;
    use yii\bootstrap\ActiveForm;
?>

<?php $form = ActiveForm::begin([
    'id'        => $widget->getFormId(),
    'action'    => '#',
    'options'   => [
        'class' => 'well well-lg auth-border no-back'
    ]
]); ?>

    <div id="<?= $widget->getErrorBoxId() ?>" class="alert alert-danger fade in alert-dismissable hidden">
        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
        <p class="message"></p>
    </div>

    <h1 class="mt0px"><?= $widget->title?></h1>

    <?= $form->field($widget->model, 'phone', ['options' => ['class' => 'form-group phone-first-step']])->textInput([
        'class'         => 'form-control input-lg auth-border',
        'autocomplete'  => "off",
        'placeholder'   => 'Enter your phone number...',
        'id'            => $widget->getPhoneInputId()
    ])->label(false) ?>

    <div class="row phone-first-step">
        <div class="col-md-12 mb-10px-width-less-then-1024px">
            <?= Html::button($widget->buttonTitle, [
                'class'     => 'btn btn-lg btn-default btn-block auth-border',
                'id'        => $widget->getPhoneButtonId(),
                'disabled'  => 'disabled'
            ]) ?>
        </div>
    </div>

    <div class="form-group phone-third-step hidden">
        <input type="text" id="<?= $widget->getCodeInputId() ?>" class="form-control input-lg auth-border" placeholder="Enter the verification code you received by SMS">
        <p class="help-block help-block-error"></p>
    </div>

    <div class="row phone-third-step hidden">
        <div class="col-md-12 mb-10px-width-less-then-1024px">
            <?= Html::button($widget->buttonTitle, [
                'class'     => 'btn btn-lg btn-default btn-block auth-border',
                'id'        => $widget->getCodeButtonId(),
                'disabled'  => 'disabled'
            ]) ?>
        </div>
    </div>

    <div class="row phone-third-step hidden">
        <div class="col-md-12 mb-10px-width-less-then-1024px mt-10px">
            <a href="#" id="<?= $widget->getChangePhoneButtonId()?>" class="text-black">Change the phone</a> |
            <a href="#" id="<?= $widget->getResendCodeButtonId()?>" class="text-black">Resend the code</a>
        </div>
    </div>

    <div id="firebase-phone-auth-widget-recaptcha-container" class="recaptcha phone-second-step"></div>
<?php ActiveForm::end(); ?>

