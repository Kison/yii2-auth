<?php

namespace app\components\firebase\providers;

/**
 * Twitter auth provider
 * @author Denis Kison
 * @date 02.07.2017
 */
class FirebaseTwitterAuthProvider extends FirebaseAuthProvider  {

    /**
     * Returns provider initialization code
     * @return string
     */
    public function getCode() {
        return <<<CODE
        var provider = new firebase.auth.TwitterAuthProvider(),
            providerName = "{$this->getName()}";
CODE;
    }

    /**
     * Returns provider name
     * @return string
     */
    public function getName() {
        return 'twitter';
    }
}