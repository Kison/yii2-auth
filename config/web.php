<?php
use app\components\firebase\FirebaseConfigComponent;
use app\models\UserRow;

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');
$routes = require(__DIR__ . './routes.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'defaultRoute' => 'main/congrats',
    'components' => [
        'request' => [
            'cookieValidationKey' => 'gwKn_CjPz-hwqLZd1paiRbzsGBsSnS6R',
        ],
        'firebase' => [
            'class'             => FirebaseConfigComponent::class,
            'apiKey'            => "AIzaSyAexcG2bWWH1p0Szmu0OSWn50iZ1aHfrgY",
            'authDomain'        => "yii2-auth-3705f.firebaseapp.com",
            'databaseURL'       => "https://yii2-auth-3705f.firebaseio.com",
            'projectId'         => "yii2-auth-3705f",
            'storageBucket'     => "yii2-auth-3705f.appspot.com",
            'messagingSenderId' => "989380390592"
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass'     => UserRow::class,
            'enableAutoLogin'   => true,
            'loginUrl'          => ['auth/login'],
        ],
        'errorHandler' => [
            'errorAction' => 'main/error',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db'            => $db,
        'urlManager'    => [
            'enablePrettyUrl'   => true,
            'showScriptName'    => false,
            'rules'             => $routes,
        ]
    ],
    'params' => $params,
];

if (false) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
