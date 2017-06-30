<?php

namespace app\models\forms;

use app\models\UserRow;
use Yii;
use yii\base\Model;
use app\components\validators\PasswordStrength;
use app\models\EmailAuthRow;
use yii\web\User;

/** RegisterForm is the model behind the sign up form. */
class RegisterForm extends Model {

    public $email;
    public $password;

    /** @return array the validation rules. */
    public function rules() {
        return [
            [['email', 'password'], 'required'],
            [['email'], 'email'],
            [['email'], 'unique', 'targetClass' => EmailAuthRow::className(), 'targetAttribute' => 'user_email'],
            ['password', 'string', 'min' => 8],
            ['password', PasswordStrength::className()],
        ];
    }

    /**
     * Creates user in database
     * @return bool whether the user is sign up and sign in successfully
     */
    public function register() {
        $transaction = Yii::$app->db->beginTransaction();

        $allowLogin = false;
        try {
            // Create user
            $user = new UserRow();
            $user->setAttribute('login_method', UserRow::AUTH_EMAIL);

            if ($user->save()) {
                // Create email auth row
                $auth = new EmailAuthRow();
                $auth->setAttribute('user_id', $user->getPrimaryKey());
                $auth->setAttribute('user_email', $this->email);
                $auth->setAttribute('user_password_hash', Yii::$app->getSecurity()
                    ->generatePasswordHash($this->password));

                if ($auth->save()) {
                    $allowLogin = true;
                }
            }

            $transaction->commit();
        } catch(\Exception $e) {
            $transaction->rollback();
        }

        if ($allowLogin) {
            // 100 years
            return Yii::$app->user->login($user, 60 * 60 * 24 * 365 * 100);
        }

        return false;
    }
}
