<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\auth\{
    UserRow, UserEmailRow
};

/**
 * This is the model class for table "firebase_auth".
 * @property string $via
 * @property string $user_email
 * @property string $user_name
 * @property string $firebase_user_id
 * @property string $firebase_access_token
 */
class SocialForm extends Model {

    /** @inheritdoc */
    public function rules() {
        return [
            [['via', 'user_email', 'user_name', 'firebase_user_id', 'firebase_access_token'], 'required'],
            [['via'], 'in', 'range' => [UserRow::AUTH_FACEBOOK, UserRow::AUTH_TWITTER, UserRow::AUTH_PHONE]],
            [['user_email'], 'email'],
            [['user_email'], 'string', 'max' => 50],
            [['user_name', 'firebase_user_id', 'firebase_access_token'], 'string', 'max' => 255]
        ];
    }

    /**
     * Creates user in database
     * @return bool whether the user is sign up and sign in successfully
     */
    public function authenticate() {
        $transaction = Yii::$app->db->beginTransaction();

        $allowLogin = false;
        try {

            // Checks if user exists
            if ($email = UserEmailRow::find()->email($this->user_email)->one()) {
                /**@var UserEmailRow $email */

                // Change auth type in user table
                $user = $email->getUser();
                $user->setAttribute('login_method', $this->via);
                if ($user->save(false, ['login_method'])) {
                    // Change firebase related data

                    // TODO: Need to finish

                }


            } else {

                // Create user
                $user = new UserRow();
                $user->setAttribute('login_method', $this->via);

                if ($user->save()) {
                    // Create email auth row
                    $auth = new UserEmailRow();
                    $auth->setAttribute('user_id', $user->getPrimaryKey());
                    $auth->setAttribute('user_email', $this->email);
                    $auth->setAttribute('user_password_hash', Yii::$app->getSecurity()
                        ->generatePasswordHash($this->password));

                    if ($auth->save()) {
                        $allowLogin = true;
                    }
                }


            }



            $transaction->commit();
        } catch(\Exception $e) {
            $transaction->rollback();
        }

        if ($allowLogin) {
            // 100 years
            return Yii::$app->user->login($user, UserRow::LOGIN_LIVE);
        }

        return false;
    }

    /** @return \yii\db\ActiveQuery */
    public function getUser() {
        return $this->hasOne(UserRow::className(), ['id' => 'user_id']);
    }
}
