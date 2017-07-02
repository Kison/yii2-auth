<?php

namespace app\components\firebase\providers;

/**
 * Facebook auth provider
 * @author Denis Kison
 * @date 02.07.2017
 */
class FirebaseFacebookAuthProvider extends FirebaseAuthProvider {

    /**
     * Returns provider initialization code
     * @return string
     */
    public function getCode() {
        return <<<CODE
        var provider = new firebase.auth.FacebookAuthProvider();  
        provider.setCustomParameters({
            'display' : 'popup'
        });
CODE;
    }
}