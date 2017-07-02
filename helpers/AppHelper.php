<?php

namespace app\helpers;

use Yii;
use app\components\firebase\FirebaseConfigComponent;

class AppHelper {

    /**
     * Checks whether passed action is current action
     * @param string $controllerName
     * @param string $actionName
     * @param string $moduleName
     * @return boolean
     */
    public static function isCurrent($controllerName, $actionName, $moduleName = '*') {
        $controller = Yii::$app->controller;
        $action = $controller->action;
        $module = ($controller->module) ?
            $controller->module->id : "";

        return (
            $controller->id == $controllerName &&
            $action->id == $actionName &&
            ($moduleName == $module || $moduleName == '*')
        );
    }

    /** @return FirebaseConfigComponent */
    public static function getFirebase() {
        return Yii::$app->firebase;
    }

}