<?php

namespace app\models\auth;

/**
 * This is the model class for table "user_password".
 * @property integer $user_id
 * @property string $user_password_hash
 */
class UserPasswordRow extends BaseAuthRow {

    /** @inheritdoc */
    public static function tableName() {
        return 'user_password';
    }

}
