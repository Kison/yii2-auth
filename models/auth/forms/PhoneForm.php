<?php

namespace app\models\auth\forms;

use Yii;
use yii\base\Model;
use app\components\validators\FirebaseToken;
use app\helpers\AppHelper;
use Kreait\Firebase;
use Kreait\Firebase\ServiceAccount;
use app\models\auth\{
    FirebaseRow, UserNameRow, UserPhoneRow, UserRow, UserEmailRow
};

/**
 * Firebase phone authentication form
 */
class PhoneForm extends Model {

    /** @var string */
    public $phone;
    /** @var string */
    public $firebase_user_id;
    /** @var string */
    public $firebase_access_token;

    /** @inheritdoc */
    public function rules() {
        return [
            [['phone', 'firebase_user_id', 'firebase_access_token'], 'required'],
            [['firebase_user_id'], 'string', 'max' => 255],
            [['phone'], 'match', 'pattern' => '/\+[0-9\s\-\(\)]+/'],
            [['firebase_access_token'], FirebaseToken::className(),
                'pid'           => AppHelper::getFirebase()->projectId,
                'uid'           => Yii::$app->request->post('firebase_user_id')
            ]
        ];
    }

    /**
     * Authenticate user in via phone number
     * @return bool whether the user is sign up|sign in successfully
     */
    public function authenticate() {
        $transaction = Yii::$app->db->beginTransaction();

        $allowLogin = false;
        $user = null;
        try {
            // Checks whether user with such phone exists or not
            if ($phone = UserPhoneRow::findOne(['user_phone' => $this->phone])) {
                /**@var UserPhoneRow $phone*/

                $user = $phone->getUser();
                $user->setAttribute('login_method', UserRow::AUTH_PHONE);

                if ($user->save(false, ['login_method'])) {
                    if ($firebase = FirebaseRow::findOne(['user_id' => $user->getPrimaryKey()])) {
                        // Update firebase related columns
                        $firebase->setAttribute('firebase_user_id', $this->firebase_user_id);
                        $firebase->setAttribute('firebase_access_token', $this->firebase_access_token);
                        $firebase->save(false, ['firebase_user_id', 'firebase_access_token']);
                    } else {
                        // Create new record in table
                        $firebase = new FirebaseRow();
                        $firebase->setAttribute('user_id', $user->getPrimaryKey());
                        $firebase->setAttribute('firebase_user_id', $this->firebase_user_id);
                        $firebase->setAttribute('firebase_access_token', $this->firebase_access_token);
                        $firebase->save(false);
                    }
                }
            } else {
                // Create user
                $user = new UserRow();
                $user->setAttribute('login_method', UserRow::AUTH_PHONE);

                if ($user->save()) {
                    // Create new firebase record
                    $firebase = new FirebaseRow();
                    $firebase->setAttribute('user_id', $user->getPrimaryKey());
                    $firebase->setAttribute('firebase_user_id', $this->firebase_user_id);
                    $firebase->setAttribute('firebase_access_token', $this->firebase_access_token);
                    $firebase->save(false);
                }
            }

            $allowLogin = true;
            $transaction->commit();
        } catch(\Exception $e) {
            $transaction->rollback();
        }

        if ($allowLogin && ($user instanceof UserRow)) {
            // 100 years
            return Yii::$app->user->login($user, UserRow::LOGIN_LIVE);
        }

        return false;
    }
}
