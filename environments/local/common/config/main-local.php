<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=JPA01JO2019',
            'username' => 'local',
            'password' => 'local',
            'charset' => 'utf8',
            'enableSchemaCache' => true,
            'schemaCacheDuration' => 3600,
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'transport' => [

                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.office365.com',  // e.g. smtp.mandrillapp.com or smtp.gmail.com
                'username' => 'info@kinz.jo',
                'password' => 'Boga71621',
                'port' => '587', // Port 25 is a very common port too
                'encryption' => 'tls', // It is often used, check your provider or mail server specs
            ],
            'viewPath' => '@common/mail',
            'htmlLayout' => '@common/mail/layouts/html',
            'textLayout' => '@common/mail/layouts/text',
        ],
    ],
];
