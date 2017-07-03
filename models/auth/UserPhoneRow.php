<?php

namespace app\models\auth;

use app\models\query\UserEmailQuery;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "user_phone".
 * @property integer $user_id
 * @property string $user_phone
 */
class UserPhoneRow extends BaseAuthRow {

    /** @inheritdoc */
    public static function tableName() {
        return 'user_phone';
    }
}
