<?php

namespace app\models\auth\forms;

use Yii;
use yii\base\Model;
use app\models\auth\{
    FirebaseRow, UserNameRow, UserRow, UserEmailRow
};

/**
 * Firebase phone authentication form
 */
class PhoneForm extends Model {

    /** @var string */
    public $phone;
    public $code;

    /**
     * Creates user in database
     * @return bool whether the user is sign up and sign in successfully
     */
    public function authenticate() {
        return false;
    }
}
