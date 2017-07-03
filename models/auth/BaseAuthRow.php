<?php

namespace app\models\auth;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "firebase".
 * @property integer $user_id
 * @property string $firebase_user_id
 * @property string $firebase_access_token
 */
class BaseAuthRow extends ActiveRecord {

    /** @return \yii\db\ActiveQuery|UserRow */
    public function getUser() {
        return $this->hasOne(UserRow::className(), ['id' => 'user_id']);
    }

}
