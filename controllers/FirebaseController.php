<?php

namespace app\controllers;

use app\models\auth\forms\PhoneForm;
use yii;
use app\models\auth\forms\SocialForm;
use yii\web\{Controller, Response};

/**
 * Class FirebaseController
 * @author Denis Kison
 * @date 03.07.2018
 */
class FirebaseController extends BaseAuthController {

    /**
     * Authenticate with social account
     * @return array|Response
     */
    public function actionSocial() {
        $model = new SocialForm();
        $request = Yii::$app->request;

        $model->setAttributes([
            'via'                           => $request->post('via'),
            'firebase_access_token'         => $request->post('firebase_access_token'),
            'firebase_user_id'              => $request->post('firebase_user_id'),
            'user_email'                    => $request->post('user_email'),
            'user_name'                     => $request->post('user_name')
        ]);

        if ($model->validate() && $model->authenticate()) {
            return $this->redirect('congrats');
        }

        Yii::$app->response->format = yii\web\Response::FORMAT_JSON;
        return [
            'code'      => 200
        ];
    }

    /**
     * Authenticate with phone.
     * @return Response|array
     */
    public function actionPhone() {
        $model = new PhoneForm();

        if ($model->validate() && $model->authenticate()) {
            return $this->redirect('congrats');
        }

        Yii::$app->response->format = yii\web\Response::FORMAT_JSON;
        return [
            'code'      => 200
        ];
    }

}
