<?php
return [
    'name' => '24expay STAGE',

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
            'dsn' => 'mysql:host=localhost;dbname=expay',
            'username' => 'expay',
            'password' => 'v3%g4~EIp0ps*YxafSiTmtWCE33#Y$UH',
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
