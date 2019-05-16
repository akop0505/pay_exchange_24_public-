<?php
return [
    'name' => '24ExPay',
    'params' => [
        'name' => '24ExPay',
        'domain' => '24expay.com',
        'domainPretty' => '24ExPay.com',
        'adminEmail' => '24expay@gmail.com',
        'supportEmail' => '24expay@gmail.com',
    ],
    'components' => [
        'coinbase' => [
            'class' => 'common\services\CoinbaseService',
            'apiKey' => '2Pcdh7gBoorDBM19',
            'apiSecret' => 'GXN3o2OzknmY6FKBoxtR8TjDG9N03CRf',
        ],
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=24expay_db',
            'username' => 'root',
            'password' => 'cSFBnCUudO',
            'charset' => 'utf8',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => '24expay@gmail.com',
                'password' => 'eYfeG5D40%hg0*M3A6',
                'port' => '465',
                'encryption' => 'ssl',
            ],
            'useFileTransport' => false,
        ],
    ],
];
