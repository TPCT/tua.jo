<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'backend',
//    'homeUrl' => '/admin',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'language' => 'en',
    'modules' => [

        'countries' => [
            'class' => 'backend\modules\countries\CountryModule',
            'thumbnailSize' => 'original'
        ],
        'youtube' => [
            'class' => 'backend\modules\youtube\YoutubeModule',
            'thumbnailSize' => 'original'
        ],

        'media_gallery' => [
            'class' => 'backend\modules\media_gallery\MediaGalleryModule',
            'thumbnailSize' => 'original'
        ],
        'news' => [
            'class' => 'backend\modules\news\NewsModule',
            'thumbnailSize' => 'original'
        ],
        'transaction' => [
            'class' => 'backend\modules\transaction\TransactionModule',
            'thumbnailSize' => 'original'
        ],
        'recurring_items' => [
            'class' => 'backend\modules\recurring_items\RecurringItemsModule',
            'thumbnailSize' => 'original'
        ],
        
        'offered_tenders' => [
            'class' => 'backend\modules\offered_tenders\OfferedTendersModule',
            'thumbnailSize' => 'original'
        ],
        
        'beneficiaries_countries' => [
            'class' => 'backend\modules\beneficiaries_countries\BeneficiariesCountriesModule',
            'thumbnailSize' => 'original'
        ],
        'empowerment_products' => [
            'class' => 'backend\modules\empowerment_products\EmpowermentProductsModule',
            'thumbnailSize' => 'original'
        ],

        'currency_price' => [
            'class' => 'backend\modules\currency_price\CurrencyPriceModule',
            'thumbnailSize' => 'original'
        ],
      

        'currency' => [
            'class' => 'backend\modules\currency\CurrencyModule',
            'thumbnailSize' => 'original'
        ],
        'zakat_stories' => [
            'class' => 'backend\modules\zakat_stories\ZakatStoriesModule',
            'thumbnailSize' => 'original'
        ],
        'faq' => [
            'class' => 'backend\modules\faq\FaqModule',
            'thumbnailSize' => 'original'
        ],
        'e_card' => [
            'class' => 'backend\modules\e_card\ECardModule',
            'thumbnailSize' => 'original'
        ],
        'blogs' => [
            'class' => 'backend\modules\blogs\BlogModule',
            'thumbnailSize' => 'original'
        ],
        'donation_programs' => [
            'class' => 'backend\modules\donation_programs\DonationProgramsModule',
            'thumbnailSize' => 'original'
        ],
        'donation_types' => [
            'class' => 'backend\modules\donation_types\DonationTypesModule',
            'thumbnailSize' => 'original'
        ],
        'sponsorship_families' => [
            'class' => 'backend\modules\sponsorship_families\SponsorshipFamiliesModule',
            'thumbnailSize' => 'original'
        ],
        'campaigns' => [
            'class' => 'backend\modules\campaigns\CampaignsModule',
            'thumbnailSize' => 'original'
        ],
        'testimonials' => [
            'class' => 'backend\modules\testimonials\TestimonialsModule',
            'thumbnailSize' => 'original'
        ],
        'volunteers' => [
            'class' => 'backend\modules\volunteers\VolunteersModule',
            'thumbnailSize' => 'original'
        ],
        'annual_report' => [
            'class' => 'backend\modules\annual_report\AnnualReportModule',
            'thumbnailSize' => 'original'
        ],
        'promoted_campaign' => [
            'class' => 'backend\modules\promoted_campaign\PromoteCampaignModule',
            'thumbnailSize' => 'original'
        ],

        'redirect_url' => [
            'class' => 'backend\modules\redirect_url\RedirectUrlModule',
            'thumbnailSize' => 'original'
        ],
        'webforms' => [
            'class' => 'backend\modules\webforms\WebFormsModule',
        ],
        'dropdown_list' => [
            'class' => 'backend\modules\dropdown_list\DropdownListModule',
        ],
        'bms' => [
            'class' => 'backend\modules\bms\BmsModule',
            'thumbnailSize' => 'original'
        ],
        'subdistrict' => [
            'class' => 'backend\modules\subdistrict\SubdistrictModule',
        ],
        'district' => [
            'class' => 'backend\modules\district\DistrictModule',
        ],
        'city' => [
            'class' => 'backend\modules\city\CityModule',
        ],
        'gridview' => [
            'class' => '\kartik\grid\Module',
        ],

        'header_image' => [
            'class' => 'backend\modules\header_image\HeaderImageModule',
            'thumbnailSize' => 'original'
        ],
        'newsletter' => [
            'class' => 'backend\modules\newsletter\Newsletter',
        ],
        'settings' => [
            'class' => 'yeesoft\settings\SettingsModule',
        ],
        'menu' => [
            'class' => 'yeesoft\menu\MenuModule',
        ],
        'translation' => [
            'class' => 'yeesoft\translation\TranslationModule',
        ],
        'user' => [
            'class' => 'yeesoft\user\UserModule',
        ],
        'media' => [
            'class' => 'yeesoft\media\MediaModule',
            'rename' => 'true',
            'routes' => [
                'baseUrl' => '', // Base absolute path to web directory
                'basePath' => '@frontend/web', // Base web directory url
                'uploadPath' => 'uploads', // Path for uploaded files in web directory
            ],
            'allowedFileTypes' => [
                'image/png', 
                'image/jpg', 
                'image/jpeg', 
                'image/gif', 
                'image/svg+xml',
                'image/webp',
                'video/mp4',
                'audio/mpeg', 
                'application/pdf', 
                'application/xls', 
                'application/xlsx', 
                'application/doc', 
                'application/docx'
            ]
        ],
        'post' => [
            'class' => 'yeesoft\post\PostModule',
            'thumbnailSize' => 'original'
        ],
        'page' => [
            'class' => 'yeesoft\page\PageModule',
            'layout' => '@backend/views/layouts/admin/main',
            'thumbnailSize' => 'original'

        ],
        'seo' => [
            'class' => 'yeesoft\seo\SeoModule',
        ],
        'comment' => [
            'class' => 'yeesoft\comment\CommentModule',
        ],
        'auth' => [
            'class' => 'yeesoft\auth\AuthModule',
            'layout' => '@backend/views/layouts/auth',
        ],
        'audit' => [
            'class' => 'bedezign\yii2\audit\Audit',
            'userIdentifierCallback' => [\common\models\User::className(), 'userIdentifierCallback'],
            'accessRoles' => ['Administrator'],
            'accessUsers' => [1],
            'ignoreActions' => ['audit/*', 'debug/*'],

            'panels' => [
                'audit/request',
                'audit/db',
                'audit/log',
                //'audit/mail',
                'audit/profiling',
                'audit/trail',
                //'audit/javascript',
                'audit/asset',
                'audit/config',

                // These provide special functionality and get loaded to activate it
                'audit/error',      // Links the extra error reporting functions (`exception()` and `errorMessage()`)
                'audit/extra',      // Links the data functions (`data()`)
                'audit/curl',
            ],

        ],

    ],
    'components' => [
        'user' => [
            'class' => 'yeesoft\components\User',
            'on afterLogin' => function ($event) {
                \yeesoft\models\UserVisitLog::newVisitor($event->identity->id);
                // $event->identity->getProfile();
            }
        ],
        'yee' => [
            'class' => 'yeesoft\Yee',
            'emailConfirmationRequired' => false,
            'languages' => [
                'en' => 'English',
//                'ar' => 'عربي'
            ],
            'languageRedirects' => [
                'en' => 'en',
            ]
        ],
        'view' => [
//            'theme' => [
////                'pathMap' => [
//////                    '@backend/modules/yeesoft/yii2-yee-auth/views/default' => '@backend/views/yii2-yee-auth/default',
//////                    '@backend/modules/yeesoft/yii2-yee-auth/views/layouts' => '@backend/views/layouts'
////                ],
//            ],
        ],
        'formatter' => [
            'class' => 'yii\i18n\Formatter',
            'dateFormat' => 'php:M d, Y',
            'datetimeFormat' => 'php:M d, Y H:i',
            'timeFormat' => 'php:H:i',
            'defaultTimeZone' => 'Asia/Amman',
            'locale' => 'en',//force use english format
        ],
        'request' => [
            //'baseUrl' => '/admin',
        ],
        'assetManager' => [
            'bundles' => [
                // 'yii\bootstrap\BootstrapAsset' => [
                //     'sourcePath' => '@backend/modules/yeesoft/yii2-yee-core/assets/theme/bootswatch/custom',
                //     'css' => ['bootstrap.css']
                // ],
                'yii\bootstrap5\BootstrapAsset' => [
                    'sourcePath' => '@backend/web/css',
                    'css' => 
                    [
                        'bootswatch-bootstrap.css',
                        'custom.css'
                    ]
                ],
                'wbraganca\dynamicform\DynamicFormAsset' => [
                    'sourcePath' => null,
                    'basePath' => '@webroot',
                    'baseUrl' => '@web',
                    'js' => [
                        YII_ENV_DEV ? 'js/yii2-dynamic-form.js' : 'js/yii2-dynamic-form.min.js'
                    ]
                ],
                'yeesoft\media\assets\TinyMceAsset' => [
                    'sourcePath' => '@backend/web/js/tinymce',
//                    'basePath' => '@webroot',
//                    'baseUrl' => '@web',
                    'js' => [
                        'tinymce.js',
                        'jquery.tinymce.min.js',
                    ]
                ],
            ],
        ],
        'urlManager' => [
            'class' => 'yeesoft\web\MultilingualUrlManager',
            'showScriptName' => false,
            'enablePrettyUrl' => true,
            'multilingualRules' => false,
            'rules' => [
                //add here local frontend controllers
                '<module:auth>/<action:(logout|captcha|login)>' => '<module>/default/<action>',
                '<module:auth>/<action:(oauth)>/<authclient:\w+>' => '<module>/default/<action>',

                '<controller:(site)/import-donation-types' => '<controller>/import-donation-types',
                '<controller:(site)/import-sponsorship-families' => '<controller>/import-sponsorship-families',
                '<controller:(site)/import-campaigns' => '<controller>/import-campaigns',
                '<controller:(site)>/<action:\w+>' => '<controller>/<action>',
                //yee cms and other modules routes
                '<module:\w+>/' => '<module>/default/index',
                '<module:\w+>/<action:\w+>/<id:\d+>' => '<module>/default/<action>',
                '<module:\w+>/<action:(create)>' => '<module>/default/<action>',
                '<module:\w+>/<controller:\w+>' => '<module>/<controller>/index',
                '<module:\w+>/<controller:\w+>/<action:\w+>/<id:\d+>' => '<module>/<controller>/<action>',
                '<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/<controller>/<action>',
            ],
            'nonMultilingualUrls' => [
                'auth/default/oauth',
            ],
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    ],
    'params' => $params,
];
