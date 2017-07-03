<?php

namespace app\models\auth\forms;

use Yii;
use yii\base\Model;
use app\models\auth\{UserEmailRow, UserRow};

/**
 * LoginForm is the model behind the login form.
 * @property UserRow|null $user This property is read-only.
 */
class LoginForm extends Model {

    public $email;
    public $password;
    private $_user = false;

    /**
     * @return array the validation rules.
     */
    public function rules() {
        return [
            [['email', 'password'], 'required'],
            [['email'], 'email'],
            [['email'], 'exist', 'targetClass' => UserEmailRow::className(), 'targetAttribute' => 'user_email', 'message' => 'Incorrect username or password.'],
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params) {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login() {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), UserRow::LOGIN_LIVE);
        }
        return false;
    }

    /**
     * Finds user by [[username]]
     * @return UserRow|null
     */
    public function getUser() {
        if ($this->_user === false) {
            $this->_user = UserEmailRow::find()
                ->email($this->email)
                ->one()
                ->getUser()
                ->one();
        }
        return $this->_user;
    }
}
