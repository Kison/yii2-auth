<?php
namespace app\components\validators;

use Yii;
use yii\validators\Validator;
use Kreait\Firebase;
use Kreait\Firebase\ServiceAccount;

/**
 * Validates firebase access token
 * @author Denis Kison
 * @date 05.07.2017
 */
class FirebaseToken extends Validator {

    /** @var string - user id from client side */
    public $uid;
    /** @var string - projectId from firebase config */
    public $pid;

    public function validateAttribute($model, $attribute) {
        $credentials = Yii::getAlias('@app') . '/config/firebase/google.service.account.json';
        $serviceAccount = ServiceAccount::fromJsonFile($credentials);

        $firebase = (new Firebase\Factory())
            ->withServiceAccount($serviceAccount)
            ->create();
        $tokenHandler = $firebase->getTokenHandler();
        $token = $tokenHandler->verifyIdToken($model->$attribute);

        // Get the projectId
        $pid = $token->getClaim('aud');
        // Get the token id
        $uid = $token->getClaim('sub');

        if ($this->uid != $uid || $this->pid != $pid) {
            $this->addError($model, $attribute, 'Invalid access token');
        }
    }
    
}