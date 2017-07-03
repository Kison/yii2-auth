<?php

namespace app\models\auth\forms;

use Yii;
use yii\base\Model;
use app\models\auth\{
    FirebaseRow, UserNameRow, UserRow, UserEmailRow
};

/**
 * Firebase social authentication form
 */
class SocialForm extends Model {

    /** @var string */
    public $via;
    /** @var string */
    public $user_email;
    /** @var string */
    public $user_name;
    /** @var string */
    public $firebase_user_id;
    /** @var string */
    public $firebase_access_token;

    /** @inheritdoc */
    public function rules() {
        return [
            [['via', 'user_name', 'firebase_user_id', 'firebase_access_token'], 'required'],
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

        $user = null;
        try {

            // Checks whether user with such email exists or not
            if (($this->user_email && ($email = UserEmailRow::find()->email($this->user_email)->one())) ||
                ($name = UserNameRow::findOne(['user_name' => $this->user_name, 'provider' => $this->via]))) {
                /**@var UserEmailRow $email */

                // Change auth type in user table
                $user = $email->getUser();
                $user->setAttribute('login_method', $this->via);
                if ($user->save(false, ['login_method'])) {

                    // Check whether firebase data exists
                    if ($firebase = $user->getFirebaseRow()) {
                        // Update firebase related columns
                        $firebase->setAttribute('firebase_user_id', $this->firebase_user_id);
                        $firebase->setAttribute('firebase_access_token', $this->firebase_access_token);
                        $firebase->save(false, ['firebase_user_id', 'firebase_access_token']);
                    } else {
                        // Create new record in table
                        $firebase = new FirebaseRow();
                        $firebase->setAttribute('user_id', $user->getPrimaryKey());
                        $firebase->setAttribute('firebase_user_id', $this->firebase_user_id);
                        $firebase->setAttribute('firebase_access_token', $this->firebase_access_token);
                        $firebase->save(false);
                    }

                }
            } else {

                // Create user
                $user = new UserRow();
                $user->setAttribute('login_method', $this->via);

                if ($user->save()) {
                    if ($this->user_email) {
                        // Create email auth row
                        $email = new UserEmailRow();
                        $email->setAttribute('user_id', $user->getPrimaryKey());
                        $email->setAttribute('user_email', $this->user_email);
                        $email->save(false);
                    }

                    // Create email auth row
                    $name = new UserNameRow();
                    $name->setAttribute('user_id', $user->getPrimaryKey());
                    $name->setAttribute('user_name', $this->user_name);
                    $name->setAttribute('provider', $this->via);
                    $name->save(false);

                    // Create new firebase record
                    $firebase = new FirebaseRow();
                    $firebase->setAttribute('user_id', $user->getPrimaryKey());
                    $firebase->setAttribute('firebase_user_id', $this->firebase_user_id);
                    $firebase->setAttribute('firebase_access_token', $this->firebase_access_token);
                    $firebase->save(false);
                }
            }

            $transaction->commit();
        } catch(\Exception $e) {
            $transaction->rollback();
        }

        if ($user instanceof UserRow) {
            // 100 years
            return Yii::$app->user->login($user, UserRow::LOGIN_LIVE);
        }

        return false;
    }
}
