<?php

namespace app\models\auth;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use app\models\auth\query\UserQuery;
use app\models\auth\extenders\UserIdentityExtender;

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

    /** @return UserQuery */
    public static function find() {
        return new UserQuery(get_called_class());
    }

    /** @return \yii\db\ActiveQuery|FirebaseRow */
    public function getFirebaseRow() {
        return $this->hasOne(FirebaseRow::className(), ['id' => 'user_id']);
    }

    /**
     * Validates password
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password) {
        /**@var $model UserPasswordRow */
        return (($model = UserPasswordRow::findOne(['user_id' => $this->getPrimaryKey()])) &&
            Yii::$app->getSecurity()->validatePassword($password, $model->getAttribute('user_password_hash')));
    }
}
