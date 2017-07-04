<?php

namespace app\models\auth;

use app\models\auth\query\UserEmailQuery;

/**
 * This is the model class for table "user_email".
 * @property integer $user_id
 * @property string $user_email
 */
class UserEmailRow extends BaseAuthRow {

    /** @inheritdoc */
    public static function tableName() {
        return 'user_email';
    }

    public static function primaryKey() {
        return ['user_id'];
    }

    /** @return UserEmailQuery */
    public static function find() {
        return new UserEmailQuery(get_called_class());
    }
}
