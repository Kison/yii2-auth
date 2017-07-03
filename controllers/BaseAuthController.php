<?php

namespace app\controllers;

use yii;
use yii\web\Controller;

/**
 * Class BaseAuthController
 * @author Denis Kison
 * @date 04.07.2017
 */
class BaseAuthController extends Controller {

    /** @inheritdoc */
    public function beforeAction($action) {
        if (!Yii::$app->user->getIsGuest()) {
            return $this->redirect('congrats');
        }
        return parent::beforeAction($action);
    }

}
