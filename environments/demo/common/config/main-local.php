<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=JPA01JO2019',
            'username' => 'drupal',
            'password' => '123',
            'charset' => 'utf8',
            'enableSchemaCache' => true,
            'schemaCacheDuration' => 3600,
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'transport' => [

                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp1.dot.jo',  // e.g. smtp.mandrillapp.com or smtp.gmail.com
                'username' => 'web@web.dot.jo',
                'password' => 'N4VPPRcMB2efJxnfmHdf',
                'port' => '587', // Port 25 is a very common port too
                'encryption' => 'tls', // It is often used, check your provider or mail server specs
            ],
            'viewPath' => '@common/mail',
            'htmlLayout' => '@common/mail/layouts/html',
            'textLayout' => '@common/mail/layouts/text',
        ],
    ],
];
