<?php

namespace app\models\auth\extenders;

use yii\web\IdentityInterface;

/**
 * Class IdentityExtender
 * @mixin IdentityInterface
 */
trait UserIdentityExtender {

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
        return $this->getPrimaryKey();
    }

    /** @inheritdoc */
    public function getAuthKey() {
        return $this->auth_key;
    }

    /** @inheritdoc */
    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }
}