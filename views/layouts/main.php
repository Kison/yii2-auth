<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\components\firebase\FirebaseWidget;

AppAsset::register($this);
// Initialize firebase
FirebaseWidget::widget();
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<?= $this->render('parts/head')?>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?= $this->render('parts/navigation')?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<?= $this->render('parts/footer')?>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
