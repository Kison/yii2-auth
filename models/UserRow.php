<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use app\models\query\UserQuery;
use app\models\extenders\UserIdentityExtender;

/**
 * Class UserRow, represents user
 *
 * @property string $login_method
 * @property string $auth_key
 * @property string $access_token
 * @property int $time_created
 *
 * @author Denis Kison
 * @date 27.06.2017
 */
class UserRow extends ActiveRecord implements IdentityInterface {

    use UserIdentityExtender;

    const LOGIN_LIVE = 3153600000;
    const AUTH_FACEBOOK = 'facebook';
    const AUTH_TWITTER = 'twitter';
    const AUTH_PHONE = 'phone';
    const AUTH_EMAIL = 'email';

    public $id;
    public $login_method;
    public $auth_key;
    public $access_token;
    public $time_created;

    /** @inheritdoc */
    public static function tableName() {
        return 'users';
    }

    /** @inheritdoc */
    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $key = \Yii::$app->security->generateRandomString();
                $this->setAttribute('auth_key', $key);
                $this->setAttribute('access_token', $key);
            }
            return true;
        }
        return false;
    }

    /** @return \yii\db\ActiveQuery */
    public function getAuth() {
        if ($this->login_method == self::AUTH_EMAIL) {
            return $this->hasOne(EmailAuthRow::className(), ['user_id' => 'id']);
        }
        return $this->hasOne(FirebaseAuthRow::className(), ['user_id' => 'id']);
    }

    /** @return UserQuery */
    public static function find() {
        return new UserQuery(get_called_class());
    }

    /**
     * Validates password
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password) {
        /**@var $auth EmailAuthRow */
        return (($auth = EmailAuthRow::findOne(['user_id' => $this->getPrimaryKey()])) &&
            Yii::$app->getSecurity()->validatePassword($password, $auth->getAttribute('user_password_hash')));
    }
}
