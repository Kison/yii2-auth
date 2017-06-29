<?php
namespace app\components\validators;

use yii\validators\Validator;

/**
 * Validates password strength
 * @author Denis Kison
 * @date 28.06.2017
 */
class PasswordStrength extends Validator {

    public function validateAttribute($model, $attribute) {
        // Uppercase letters
        if (!preg_match('/[A-Z]/', $model->$attribute)) {
            $this->addError($model, $attribute, 'Password requires at least one uppercase letter');
        }

        // Lowercase letters
        if (!preg_match('/[a-z]/', $model->$attribute)) {
            $this->addError($model, $attribute, 'Password requires at least one lowercase letter');
        }

        // Numeric symbols
        if (!preg_match('/\d/', $model->$attribute)) {
            $this->addError($model, $attribute, 'Password requires at least one numeric symbol');
        }
    }
    
}