<?php

namespace app\auth\controllers;

use app\models\SocialForm;
use yii;
use yii\web\Controller;
use yii\web\Response;
use app\models\auth\FirebaseRow;

class FirebaseController extends Controller {

    /**
     * Login|Register action.
     * @return Response|string
     */
    public function actionAuth() {
        $model = new SocialForm();

        if ($model->load(Yii::$app->request->post()) && $model->authenticate()) {
            return $this->redirect('main/congrats');
        }

        return $this->render('login', [
            'model' => $model
        ]);
    }

}
