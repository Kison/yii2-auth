<?php

namespace app\models\auth;

/**
 * This is the model class for table "firebase".
 * @property integer $user_id
 * @property string $firebase_user_id
 * @property string $firebase_access_token
 */
class FirebaseRow extends BaseAuthRow {

    /** @inheritdoc */
    public static function tableName() {
        return 'firebase';
    }

}
