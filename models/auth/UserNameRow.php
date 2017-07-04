<?php

namespace app\models\auth;

/**
 * This is the model class for table "user_name".
 * @property integer $user_id
 * @property string $user_password_hash
 */
class UserNameRow extends BaseAuthRow {

    /** @inheritdoc */
    public static function tableName() {
        return 'user_name';
    }

    public static function primaryKey() {
        return ['user_id', 'provider'];
    }

}
