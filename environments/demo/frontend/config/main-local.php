<?php

$config = [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'UC-_XoILDmgw-6Lgkt1qoLgGIWVSjJpI',
        ],
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            // !!! update this fileds in the following (if it is empty) - this is required for correct oauth work
            'clients' => [
                'facebook' => [
                    'class' => 'yii\authclient\clients\Facebook',
                    'clientId' => '',
                    'clientSecret' => '',
                    'attributeNames' => [
                        'id',
                        'name',
                        'first_name',
                        'last_name',
                        'age_range',
                        'link',
                        'gender',
                        'locale',
                        'picture',
                        'timezone',
                        'updated_time',
                        'verified',
                        'email'
                    ]
                ],
                'google' => [
                    'class' => 'yii\authclient\clients\Google',
                    'clientId' => '',
                    'clientSecret' => '',
                ],
//                'twitter' => [
//                    'class' => 'yii\authclient\clients\Twitter',
//                    'attributeParams' => [
//                        'include_email' => 'true'
//                    ],
//                    'consumerKey' => 'GkosGWUP8WAgFMlPfahjUDdg3',
//                    'consumerSecret' => '5VxtgcP6LPDe9TVwFrtHTcnx2RzOxOdZVArbnmMzLc90yRqfMt',
//                ],
            ],
        ],
    ],
];

if (!YII_ENV_PROD) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'generators' => [
            'yee-crud' => [
                'class' => 'yeesoft\generator\crud\Generator',
                'templates' => [
                    'default' => '@backend/modules/yeesoft/yii2-yee-generator/crud/yee-admin',
                ]
            ],
        ],
    ];
}

return $config;
