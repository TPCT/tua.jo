<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'console',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'console\controllers',
    'controllerMap' => [
        'migrate' => [
            'class' => 'console\controllers\MigrateController'
        ],
//        'queue' => [
//            'class' => \yii\queue\cli\Command::class,
//            'queue' => 'queue', // Component ID of the queue
//        ],
    ],
    'aliases' => [
        '@webroot' => dirname(__DIR__) . '/web',
        '@web' => '/',
    ],
    'modules' => [
        'audit' => [
            'class' => 'bedezign\yii2\audit\Audit',
            'maxAge' => YII_ENV=="prod"? 30 : 5, // 30 days for production 5 for dev
            'userIdentifierCallback' => [\common\models\User::className(), 'userIdentifierCallback'],
            'accessRoles' => ['Administrator'],
            'accessUsers' => [1],
            'ignoreActions' => ['audit/*', 'debug/*'],

            'panels' => [
                    'audit/request' => [
                        'maxAge' => YII_ENV=="prod"? 30 : 5, // 30 days for production 5 for dev
                    ],
                    'audit/db' => [
                        'maxAge' => YII_ENV=="prod"? 30 : 5, // 30 days for production 5 for dev
                    ],
                    'audit/log' => [
                        'maxAge' => YII_ENV=="prod"? 30 : 5, // 30 days for production 5 for dev
                    ],
                    'audit/mail' => [
                        'maxAge' => YII_ENV=="prod"? 30 : 5, // 30 days for production 5 for dev
                    ],
                    'audit/profiling' => [
                        'maxAge' => YII_ENV=="prod"? 30 : 5, // 30 days for production 5 for dev
                    ],
                    'audit/trail' => [
                        'maxAge' => YII_ENV=="prod"? 30 : 5, // 30 days for production 5 for dev
                    ],
                    'audit/javascript' => [
                        'maxAge' => YII_ENV=="prod"? 30 : 5, // 30 days for production 5 for dev
                    ],
                    'audit/asset' => [
                        'maxAge' => YII_ENV=="prod"? 30 : 5, // 30 days for production 5 for dev
                    ],
                    'audit/config' => [
                        'maxAge' => YII_ENV=="prod"? 30 : 5, // 30 days for production 5 for dev
                    ],
                    

                    // These provide special functionality and get loaded to activate it
                    'audit/error' => [
                        'maxAge' => YII_ENV=="prod"? 30 : 5, // 30 days for production 5 for dev
                    ],      // Links the extra error reporting functions (`exception()` and `errorMessage()`)
                    'audit/extra' => [
                        'maxAge' => YII_ENV=="prod"? 30 : 5, // 30 days for production 5 for dev
                    ],      // Links the data functions (`data()`)
                    'audit/curl' => [
                        'maxAge' => YII_ENV=="prod"? 30 : 5, // 30 days for production 5 for dev
                    ],
                ],

        ],
    ],
    'components' => [
        'EmptyLogger' => [
            'class' => 'common\components\EmptyLogger\EmptyLogger'
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'urlManager' => [
            'class' => 'yeesoft\web\MultilingualUrlManager',
            'showScriptName' => false,
            'enablePrettyUrl' => true,
            'rules' => [
                'en/<action:[\w \-]+>' => 'site/<action>',
            ],
            'baseUrl' => 'http://yiicms.dev.dot.jo'
        ],

        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'dateFormat' => 'php:M d, Y',
            'datetimeFormat' => 'php:M d, Y H:i',
            'timeFormat' => 'php:H:i',
            'defaultTimeZone' => 'Asia/Amman',
            'locale' => 'en',
        ],
    ],
    'params' => $params,
];
