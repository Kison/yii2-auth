<?php

namespace app\components\firebase\providers;

/**
 * Basic firebase auth provider class
 * @author Denis Kison
 * @date 02.07.2017
 */
abstract class FirebaseAuthProvider {

    /**
     * Returns provider initialization code
     * @return string
     */
    abstract public function getCode();

    /**
     * Returns provider name
     * @return string
     */
    abstract public function getName();
}