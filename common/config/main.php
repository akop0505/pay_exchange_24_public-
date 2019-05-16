<?php

use common\services\BlockchainInfoService;
use common\services\CoinbaseService;

return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [

        'coinbase' => [
            'class' => CoinbaseService::class,
        ],

        'blockchainInfo' => [
            'class' => BlockchainInfoService::class,
        ],

        'db' => [
            'class' => 'yii\db\Connection',
        ],

        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'useFileTransport' => true,
        ],

        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
    ],
];
