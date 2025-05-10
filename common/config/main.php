<?php
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'bootstrap' => ['comments', 'yee','masterBackendQueue', 'masterCacheQueue', 'slaveCacheQueue'],
    'language' => 'en',
    'sourceLanguage' => 'en',
        'aliases' => [ //for new composer json with php 7
        '@bower' => '@vendor/bower-asset',
    ],
    'components' => [
        'masterBackendQueue' => [
            'class' => \yii\queue\db\Queue::class,
            'db' => 'db', // DB connection component or its config
            'tableName' => '{{%queue}}', // Table name
            'channel' => 'backend', // Queue channel key
            'mutex' => '\yii\mutex\MysqlMutex', // Mutex used to sync queries
            'as log' => \yii\queue\LogBehavior::class,
            // 'strictJobType' => false,
            // 'serializer' => \yii\queue\serializers\JsonSerializer::class,
        ],
        'masterCacheQueue' => [
            'class' => \yii\queue\db\Queue::class,
            'db' => 'db', // DB connection component or its config
            'tableName' => '{{%queue}}', // Table name
            'channel' => 'master', // Queue channel key
            'mutex' => '\yii\mutex\MysqlMutex', // Mutex used to sync queries
            'as log' => \yii\queue\LogBehavior::class,
            // 'strictJobType' => false,
            // 'serializer' => \yii\queue\serializers\JsonSerializer::class,
        ],
        'slaveCacheQueue' => [
            'class' => \yii\queue\db\Queue::class,
            'db' => 'db', // DB connection component or its config
            'tableName' => '{{%queue}}', // Table name
            'channel' => 'slave', // Queue channel key
            'mutex' => '\yii\mutex\MysqlMutex', // Mutex used to sync queries
            'as log' => \yii\queue\LogBehavior::class,
            // 'strictJobType' => false,
            // 'serializer' => \yii\queue\serializers\JsonSerializer::class,
        ],
        'cookieConsentHelper' => [
            'class' => common\components\CookieConsentHelper::class
        ],
        'yee' => [
            'class' => 'yeesoft\Yee',
            'emailConfirmationRequired' => false,
            'confirmationTokenExpire' => 120,
//            'defaultRoles' => [''],
            'languages' => [
                'en' => 'English',
                'ar' => 'العربية',
            ],
            'languageRedirects' => [
                'en' => 'en',
            ]
        ],
        'geoip' => [
            'class' => 'perfectpanel\GeoIP\GeoIP'
        ],
        'formatter' => [
            'locale' => 'en',//force use english format
        ],
        'solr' => [
            'class' => \common\components\SolrSearch::className(),
            'options' => [
                'endpoint' => [
                    'solr1' => [
                        'host' => '195.154.80.174',
                        'port' => '8983',
                        'path' => '/solr/AUTOSTUDIO'
                    ]
                ]
            ]
        ],
        'reCaptcha' => [
            'name' => 'reCaptcha',
            'class' => 'himiklab\yii2\recaptcha\ReCaptcha',
            'siteKey' => '6LeMKycrAAAAAMpt5AqZC8WTgEYBs_TXbzI195GP',
            'secret' => '6LeMKycrAAAAADMvQJ4E34wUUgoLF91ATTStlppa',
        ],
        'assetManager' => [
            'appendTimestamp' => true,
            'bundles' => [
                'dosamigos\google\maps\MapAsset' => [
                    'options' => [
                        'key' => @Yii::$app->params['googleMapsApiKey'],
                        'language' => 'en',
                        'version' => '3.1.18'
                    ]
                ]
            ]
        ],
        'settings' => [
            'class' => 'yeesoft\components\Settings'
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
            'cachePath' => Yii::getAlias('@frontend') . '/runtime/cache'

        ],

        'i18n' => [
            'translations' => [
                'app' => [
                    'class' => 'yeesoft\db\DbMessageSource',
                    'sourceLanguage' => 'en',
                    'forceTranslation' => true,
                ],
                'kvpwdstrength' => [
                    'class' => 'yeesoft\db\DbMessageSource',
                    'sourceLanguage' => 'en',
                    'forceTranslation' => true,
                ],
                'yii' => [
                    'class' => 'yeesoft\db\DbMessageSource',
                    'sourceLanguage' => 'en',
                    'forceTranslation' => true,
                ],
                'vote' => [
                    'class' => 'yeesoft\db\DbMessageSource',
                    'sourceLanguage' => 'en',
                    'forceTranslation' => true,
                ],
                '*' => [
                    'class' => 'yeesoft\db\DbMessageSource',
                    'sourceLanguage' => 'en',
                    'forceTranslation' => true,
                ],
            ]
        ],
    ],
    'modules' => [
        'dynagrid' => [
            'class' => '\kartik\dynagrid\Module',
            'minPageSize' => 1,
            'dynaGridOptions' => [
            ]
        ],
        'gridview' => [
            'class' => '\kartik\grid\Module'
        ],
        // 'audit' => [
        //     'class' => 'bedezign\yii2\audit\Audit',
        //     'userIdentifierCallback' => [\common\models\User::className(), 'userIdentifierCallback'],
        //     'accessRoles' => ['Administrator'],
        //     'accessUsers' => [1],
        //     'ignoreActions' => ['audit/*', 'debug/*'],

        //     'panels' => [
        //         //'audit/request',
        //         //'audit/error',
        //         'audit/trail',
        //         //'app/views' => [
        //         //'class' => 'app\panels\ViewsPanel',
        //         // ...
        //         //],
        //     ],

        // ],
        'comments' => [
            'class' => 'yeesoft\comments\Comments',
            'onlyRegistered' => false,
            'userModel' => \common\models\User::className(),
            'userAvatar' => function ($user_id) {
                $user = yeesoft\models\User::findIdentity((int)$user_id);
                if ($user instanceof yeesoft\models\User) {
                    return $user->getAvatar();
                }
                return false;
            }
        ],
    ],
];
