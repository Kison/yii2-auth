<?php
    /* @var $this yii\web\View */
    $this->title = 'Congratulations';

    $animation = <<<JS
        $(function () {
            $('.congrats-image, .congrats-text').animate({'opacity' : 1}, 2000);
        });
JS;

    $this->registerJs($animation, \yii\web\View::POS_END);
?>

<h1 class="congrats-text text-center">Congratulation, you logged in!</h1>
<img src="/images/congrats.jpg" class="congrats-image"/>


