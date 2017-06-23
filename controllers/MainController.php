<?php

namespace app\controllers;

use yii\filters\AccessControl;
use yii\web\Controller;

class MainController extends Controller {

    public $defaultAction = 'congrats';
    public $layout = 'main';

    /** @inheritdoc */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ]
        ];
    }

    /** @inheritdoc */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays congratulation page
     * @return string
     */
    public function actionCongrats() {
        return $this->render('congrats');
    }
}
