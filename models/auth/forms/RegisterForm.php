<?php

namespace app\models\auth\forms;

use Yii;
use yii\base\Model;
use app\components\validators\PasswordStrength;
use app\models\auth\{
    UserEmailRow, UserPasswordRow, UserRow
};


/** RegisterForm is the model behind the sign up form. */
class RegisterForm extends Model {

    public $email;
    public $password;

    /** @return array the validation rules. */
    public function rules() {
        return [
            [['email', 'password'], 'required'],
            [['email'], 'email'],
            [['email'], 'emailUnique'],
            ['password', 'string', 'min' => 8],
            ['password', PasswordStrength::className()],
        ];
    }

    /**
     * Validates the email.
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function emailUnique($attribute, $params) {
        if (!$this->hasErrors()) {
            if ($email = UserEmailRow::findOne(['user_email' => $this->email])) {
                if (UserPasswordRow::find()->where(['user_id' => $email->getAttribute('user_id')])->exists()) {
                    $this->addError($attribute, 'The email has already been taken');
                }
            }
        }
    }

    /**
     * Creates user in database
     * @return bool whether the user is sign up and sign in successfully
     */
    public function register() {
        $transaction = Yii::$app->db->beginTransaction();

        $allowLogin = false;
        $user = null;
        try {

            if ($email = UserEmailRow::findOne(['user_email' => $this->email])) {
                $user = $email->getUser()->one();
                $user->setAttribute('login_method', UserRow::AUTH_EMAIL);

                // Create password
                $password = new UserPasswordRow();
                $password->setAttribute('user_id', $user->getPrimaryKey());
                $password->setAttribute('user_password_hash', Yii::$app->getSecurity()
                    ->generatePasswordHash($this->password));

                if ($user->save() && $password->save()) {
                    $allowLogin = true;
                }
            } else {
                // Create user
                $user = new UserRow();
                $user->setAttribute('login_method', UserRow::AUTH_EMAIL);

                if ($user->save()) {
                    // Create email
                    $email = new UserEmailRow();
                    $email->setAttribute('user_id', $user->getPrimaryKey());
                    $email->setAttribute('user_email', $this->email);
                    $email->save();

                    // Create password
                    $password = new UserPasswordRow();
                    $password->setAttribute('user_id', $user->getPrimaryKey());
                    $password->setAttribute('user_password_hash', Yii::$app->getSecurity()
                        ->generatePasswordHash($this->password));
                    $password->save();

                    if ($email->save() && $password->save()) {
                        $allowLogin = true;
                    }
                }
            }
            $transaction->commit();
        } catch(\Exception $e) {
            $transaction->rollback();
        }

        if ($allowLogin && $user) {
            // 100 years
            return Yii::$app->user->login($user, UserRow::LOGIN_LIVE);
        }

        return false;
    }
}
