<?php

require(__DIR__ . '/di.php');

$params = require(__DIR__ . '/../../common/config/params.php');

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'ru-RU',
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'timeZone' => 'Europe/Moscow',
            'nullDisplay' => '',
        ],
        'view' => [
            'class' => 'frontend\components\View'
        ],
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'categories' => ['coinbase_create_wallet'],
                    'levels' => ['info'],
                    'logFile' => '@runtime/logs/coinbase_create_wallet.log',
                    'logVars' => ['_GET', '_POST'],
                ],
                [
                    'class' => 'yii\log\FileTarget',
                    'categories' => ['coinbase_global'],
                    'levels' => ['info'],
                    'logFile' => '@runtime/logs/coinbase_global.log',
                    'logVars' => ['_GET', '_POST'],
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

                'create' => 'form/create',
                'detail/<hash:\w+>' => 'form/detail',
                'confirm/<hash:\w+>' => 'form/confirm',
                'paid/<hash:\w+>' => 'form/paid',
                'cancel/<hash:\w+>' => 'form/cancel',
                'cancel-message/<id:\d+>' => 'form/cancel-message',

                'works' => 'tech/works',

                'pay.xml' => 'site/monitor-xml',
                'json.json' => 'site/monitor-json',

                '<action:(faq|contacts|rules|get-data|coinbase|coinbase-eth|coinbase-bch|currencies|reserve)>' => 'site/<action>',
                '<action:(settings|scroll)>' => 'cabinet/<action>',
                '' => 'site/index',
            ],
        ],
    ],
    'params' => $params,
];
