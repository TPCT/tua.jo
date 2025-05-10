<?php

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

Yii::setAlias('api', dirname(dirname(__DIR__)) . '/api'); // add api alias

return [
    'id' => 'AUTO-Studio-API',
    'name' => 'AUTO-Studio',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'api\controllers',
    'defaultRoute' => 'v1/default',
    'modules' => [
        'v1' => [
            'basePath' => '@api/modules/v1',
            'class' => \api\modules\v1\Module::className(),
        ],
//        'v2' => [
//            'basePath' => '@api/modules/v2',
//            'class' => \api\modules\v2\Module::className(),
//        ],
//
//        'v3' => [
//            'basePath' => '@api/modules/v3',
//            'class' => \api\modules\v3\Module::className(),
//        ]
    ],
    'bootstrap' => [
        'log',
        [
            'class' => \yii\filters\ContentNegotiator::className(),
            'formats' => [
                'application/json' => \yii\web\Response::FORMAT_JSON,
                'application/xml' => \yii\web\Response::FORMAT_XML,
            ],
        ],
    ],
    'components' => [
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'dateFormat' => 'php:M d, Y',
            'datetimeFormat' => 'php:M d, Y H:i',
            'timeFormat' => 'php:H:i',
            'defaultTimeZone' => 'Asia/Amman',
            'locale' => 'en-US',//force use english format
        ],
        'request' => [
            'class' => '\yii\web\Request',
            'enableCookieValidation' => false,
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'enableSession' => true,
            'loginUrl' => null,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
//            'hostInfo' => 'https://kinz.jo',
            'rules' => [
//                '<controller:\w+>/<id:[\d\-]+>' => 'v1/<controller>/view',
//                '<controller:\w+>/<action:\w+>/<id:[\d\-]+>' => 'v1/<controller>/<action>',
//                '<controller:\w+>/<action:\w+>' => 'v1/<controller>/<action>',
            ],
        ],
        'response' => [
            'class' => \yii\web\Response::className(),
            'on beforeSend' => function ($event) {
                $response = $event->sender;
//                $response->format = yii\web\Response::FORMAT_JSON;
                if (($exception = Yii::$app->getErrorHandler()->exception) !== null) {
//                    var_dump($exception->getMessage());die();
                    $response->format = yii\web\Response::FORMAT_JSON;
                    $response->statusCode = 400;
                    $response->data = [
                        'Status' => 'S400',
                        'Data' => [],
                        'Error' => [
                            $exception->getMessage()
                        ]

                    ];
                }
            },
        ],
    ],
    'params' => $params,
];
