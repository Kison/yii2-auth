<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "firebase_auth".
 * @property integer $user_id
 * @property string $user_email
 * @property string $user_phone
 * @property string $user_name
 * @property string $firebase_user_id
 * @property string $firebase_access_token
 * @property UserRow $user
 */
class FirebaseAuthRow extends ActiveRecord {

    /** @inheritdoc */
    public static function tableName() {
        return 'firebase_auth';
    }

    /** @inheritdoc */
    public function rules() {
        return [
            [['user_id'], 'integer'],
            [['user_name', 'firebase_user_id', 'firebase_access_token'], 'required'],
            [['user_email', 'user_phone'], 'string', 'max' => 50],
            [['user_name', 'firebase_user_id', 'firebase_access_token'], 'string', 'max' => 255],
            [['user_id'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserRow::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /** @return \yii\db\ActiveQuery */
    public function getUser() {
        return $this->hasOne(UserRow::className(), ['id' => 'user_id']);
    }
}
