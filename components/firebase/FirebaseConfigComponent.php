<?php
namespace app\components\firebase;

use yii\base\Component;

/**
 * Helps with firebase integration
 * Features:
 * - Config generating
 *
 * @date 02.07.2017
 */
class FirebaseConfigComponent extends Component {

    public $apiKey;
    public $authDomain;
    public $databaseURL;
    public $projectId;
    public $storageBucket;
    public $messagingSenderId;

    /**
     * Generates firebase config
     * @return array
     */
    public function getConfig() {
        return [
            'apiKey'            => $this->apiKey,
            'authDomain'        => $this->authDomain,
            'databaseURL'       => $this->databaseURL,
            'projectId'         => $this->projectId,
            'storageBucket'     => $this->storageBucket,
            'messagingSenderId' => $this->messagingSenderId
        ];
    }
}
