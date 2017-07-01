<?php

namespace app\controllers;


use yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\forms\{LoginForm, RegisterForm};

class AuthController extends Controller {

    public $defaultAction = 'login';
    public $layout = 'auth';

    /** @inheritdoc */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /** @inheritdoc */
    public function actions() {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Login action.
     * @return Response|string
     */
    public function actionLogin() {
        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect('main/congrats');;
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Register action.
     * @return Response|string
     */
    public function actionRegister() {
        $model = new RegisterForm();

        if ($model->load(Yii::$app->request->post()) &&
            $model->validate() &&
            $model->register()) {
            $this->redirect('main/congrats');
        }

        return $this->render('register', [
            'model' => $model
        ]);
    }

    /**
     * Logout action
     * @return Response
     */
    public function actionLogout() {
        Yii::$app->user->logout();
        return $this->goHome();
    }
}
