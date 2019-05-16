<?php

$params = require(__DIR__ . '/../../common/config/params.php');

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'language' => 'ru-RU',
    'timeZone' => 'Europe/Moscow',
    'modules' => [
        'gridview' =>  [
            'class' => '\kartik\grid\Module'
        ],
        'bestchange' => [
            'class' => 'backend\modules\bestchange\Module',
            'selfExchangerId' => 0,
        ],
    ],
    'components' => [

        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'timeZone' => 'UTC',
            'nullDisplay' => '',
        ],

        'request' => [
            'csrfParam' => '_csrf-backend',
        ],

        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],

        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],

        'log' => [
            'traceLevel' => 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],

                [
                    'class' => 'yii\log\FileTarget',
                    'categories' => ['btc_send_log'],
                    'levels' => ['info'],
                    'logFile' => '@runtime/logs/btc_send.log',
                    'logVars' => [],
                ],
            ],
        ],

        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                'referral/monitor/<id:\d+>' => 'referral/monitor',
                'referral/monitor' => 'referral/index-monitor',
                'room/monitor/<id:\d+>' => 'room/monitor',
            ],
        ],

        'assetManager' => [
            'linkAssets' => true,
        ],


    ],
    'params' => $params,
];
