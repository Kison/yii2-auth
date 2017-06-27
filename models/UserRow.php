<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * Class UserRow, represents user
 * @author Denis Kison
 * @date 27.06.2017
 */
class UserRow extends ActiveRecord implements \yii\web\IdentityInterface {

    const AUTH_FACEBOOK = 'facebook';
    const AUTH_TWITTER = 'twitter';
    const AUTH_PHONE = 'phone';
    const AUTH_EMAIL = 'email';

    public $id;
    public $email;
    public $login_method;
    public $auth_key;
    public $access_token;
    public $time_created;

    /** @inheritdoc */
    public static function tableName() {
        return 'users';
    }

    /** @inheritdoc */
    public static function findIdentity($id) {
        return static::findOne($id);
    }

    /** @inheritdoc */
    public static function findIdentityByAccessToken($token, $type = null) {
        return static::findOne(['access_token' => $token]);
    }

    /** @inheritdoc */
    public function getId() {
        return $this->id;
    }

    /** @inheritdoc */
    public function getAuthKey() {
        return $this->auth_key;
    }

    /** @inheritdoc */
    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }

    /** @inheritdoc */
    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->auth_key = \Yii::$app->security->generateRandomString();
            }
            return true;
        }
        return false;
}

    /**
     * Validates password
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password) {
        /**TODO: Passwords in another table */
        return $this->password === $password;
    }
}
