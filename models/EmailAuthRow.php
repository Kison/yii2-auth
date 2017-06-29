<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "email_auth".
 * @property integer $user_id
 * @property string $user_email
 * @property string $user_password_hash
 * @property UserRow $user
 */
class EmailAuthRow extends ActiveRecord {

    /** @inheritdoc */
    public static function tableName() {
        return 'email_auth';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['user_id'], 'integer'],
            [['user_email', 'user_password_hash'], 'string', 'max' => 255],
            [['user_id'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => UserRow::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /** @return \yii\db\ActiveQuery */
    public function getUser() {
        return $this->hasOne(UserRow::className(), ['id' => 'user_id']);
    }
}
