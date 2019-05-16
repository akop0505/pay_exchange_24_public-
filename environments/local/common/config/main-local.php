<?php
return [
    'params' => [
        'name' => 'name',
        'domain' => 'name.ru',
        'domainPretty' => 'name.ru',

        'adminEmail' => 'name@example.com',
        'supportEmail' => 'name@example.com',
    ],

    'components' => [
        'coinbase' => [
            'class' => 'common\services\CoinbaseService',
            'apiKey' => 'your key',
            'apiSecret' => 'your secret',
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=expay24',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'useFileTransport' => true,
            'fileTransportPath' => '@common/mailbox',
        ],
    ],
];
