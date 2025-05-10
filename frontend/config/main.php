<?php

use backend\modules\media_gallery\models\MediaGallery;
use backend\modules\news\models\News;
use backend\modules\blogs\models\Blogs;
use backend\modules\zakat_stories\models\ZakatStories;
use backend\modules\empowerment_products\models\EmpowermentProducts;
use backend\modules\donation_programs\models\DonationProgram;
use backend\modules\volunteers\models\Volunteers;
use backend\modules\offered_tenders\models\OfferedTenders;
use backend\modules\testimonials\models\Testimonials;
use backend\modules\annual_report\models\AnnualReport;
use backend\modules\faq\models\Faq;



use backend\modules\youtube\models\YoutubeLinks;
use yeesoft\media\models\Album;
use yeesoft\page\models\Page;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'), require(__DIR__ . '/../../common/config/params-local.php'), require(__DIR__ . '/params.php'), require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'frontend',
    'name' => Yii::t('site', 'TUA01JO2025'),
    'homeUrl' => '/',
    'defaultRoute' => 'site/homepage',
    'basePath' => dirname(__DIR__),
    'bootstrap' => [
//        'log',
//        'headers',
    ],
    'controllerNamespace' => 'frontend\controllers',
    'modules' => [
        'account' => [
            'class' => 'frontend\modules\account\Module',
        ],
        'schema' => [
            'class' => 'simialbi\yii2\schemaorg\Module',
        ]
    ],

    'components' => [
        'user' => [
            'identityClass' => \frontend\modules\account\models\client\Client::className(),
            'enableAutoLogin' => true,
            'enableSession' => true,
        ],
//        'headers' => [
//            'class' => \hyperia\security\Headers::className(),
//            'upgradeInsecureRequests' => YII_ENV_PROD? true : false,
//            'blockAllMixedContent' => YII_ENV_PROD? true : false,
//            'requireSriForScript' => false,
//            'requireSriForStyle' => false,
//            'xssProtection' => true,
//            'contentTypeOptions' => true,
//            'xFrameOptions' => 'SAMEORIGIN',
////            'referrerPolicy' => 'no-referrer',
//            'strictTransportSecurity' => [
//                'max-age' => 31536000,
//                'includeSubDomains' => true,
//                'preload' => false
//            ],
//
//           'cspDirectives' => [
//               'default-src'     => "'self' data: blob:  https://eu-prod.oppwa.com https://eu-test.oppwa.com *.oppwa.com",
//               'script-src'      => "'unsafe-inline' 'self' data: blob:  https://eu-prod.oppwa.com https://eu-test.oppwa.com *.oppwa.com *.googletagmanager.com *.google-analytics.com *.googleapis.com *.google.com *.gstatic.com *.googlesyndication.com https://platform.twitter.com https://publish.twitter.com https://tankie.tube",
//               'style-src'       => "'unsafe-inline' 'self' data: blob:  https://eu-prod.oppwa.com https://eu-test.oppwa.com *.googleapis.com *.googlesyndication.com https://tankie.tube",
//               'img-src'         => "'self' data: blob:  https://eu-prod.oppwa.com https://eu-test.oppwa.com *.google-analytics.com *.gstatic.com *.google.com *.googleapis.com *.google.jo *.googlesyndication.com https://img.youtube.com",
//               'connect-src'     => "'self' data: blob:  https://eu-prod.oppwa.com https://eu-test.oppwa.com *.facebook.com *.google-analytics.com stats.g.doubleclick.net *.googleapis.com *.googlesyndication.com",
//               'font-src'        => "'self' data: blob:  https://eu-prod.oppwa.com https://eu-test.oppwa.com *.gstatic.com https://pro.fontawesome.com",
//               'object-src'      => "'self' data: blob:  https://eu-prod.oppwa.com https://eu-test.oppwa.com",
//               'media-src'       => "'self' data: blob:  https://eu-prod.oppwa.com https://eu-test.oppwa.com",
//               'frame-src'       => "'self' data: blob:  https://eu-prod.oppwa.com https://eu-test.oppwa.com *.google.com *.youtube.com *.facebook.com https://googleads.g.doubleclick.net *.googlesyndication.com https://*.twitter.com *.youtube-nocookie.com https://tankie.tube",
//               'child-src'       => "'self' data: blob:  https://eu-prod.oppwa.com https://eu-test.oppwa.com",
//               'worker-src'      => "'self' data: blob:  https://eu-prod.oppwa.com https://eu-test.oppwa.com",
//               'frame-ancestors' => "'self'  https://eu-prod.oppwa.com https://eu-test.oppwa.com *.facebook.com",
//               'form-action'     => "'self'  https://eu-prod.oppwa.com https://eu-test.oppwa.com",
//           ],
//
//        ],
        'request' => [
            'csrfCookie' => ['httpOnly' => YII_ENV_PROD? true : false, 'secure' => YII_ENV_PROD? true : false],
            'enableCsrfValidation' => true,
            'baseUrl' => ''
        ],
        'session' => [
            'class' => 'yii\web\Session',
            'timeout' => 3600 * 24 * 30,
            'cookieParams' => [
                'httpOnly' => true,
                'secure' => YII_ENV_PROD? true : false,
                'sameSite' => 'Lax'
            ],
        ],
        'html' => [
            'class' => 'common\components\custom_base_html\CustomBaseHtml', //use custom one to use nonce
        ],
        'view' => [
            // 'class' => '\rmrevin\yii\minify\View', //old base one 
            'class' => 'common\components\custom_yii_base_view\CustomView', //use custom one to use nonce
            'enableMinify' => true,
            'concatCss' => true, // concatenate css
            'minifyCss' => true, // minificate css
            'concatJs' => true, // concatenate js
            'minifyJs' => true, // minificate js
            'minifyOutput' => true, // minificate result html page
            'webPath' => '@web', // path alias to web base
            'basePath' => '@webroot', // path alias to web base
            'minifyPath' => '@webroot/minify', // path alias to save minify result
            'jsPosition' => [\yii\web\View::POS_END], // positions of js files to be minified
            'forceCharset' => 'UTF-8', // charset forcibly assign, otherwise will use all of the files found charset
            'expandImports' => true, // whether to change @import on content
            'compressOptions' => ['extra' => true], // options for compress
            'excludeFiles' => [
            ],
            'excludeBundles' => [
            ],
            'theme' => [
                'pathMap' => [
                    '@backend/modules/yeesoft/yii2-yee-auth/views/default' => '@frontend/views/yii2-yee-auth/default',
                    '@backend/modules/yeesoft/yii2-yee-auth/views/layouts' => '@frontend/views/layouts',
                ],
            ],
            'as seo' => [
                'class' => 'yeesoft\seo\components\SeoViewBehavior',
            ]
        ],
        'seo' => [
            'class' => 'yeesoft\seo\components\Seo',
        ],
        'sitemap' => [
            'class' => 'yeesoft\seo\components\Sitemap',
            'links' => [
                ['loc' => ['/site/index'], 'priority' => '1'],
            ],
            'models' => [
                [
                    'items' => function () {
                        $itemQuery = Page::find()->active();
                        foreach ($itemQuery->batch(100) as $itemBatch) {
                            foreach ($itemBatch as $items) {
                                yield $items;
                            }
                        }
                    },
                    'loc' => function ($model) {
                        return ['/site/index', 'slug' => $model->slug];
                    },
                    'lastmod' => function ($model) {
                        return $model->updated_at;
                    },
                    'priority' => function ($model) {
                        return $model->sitemap_priority;
                    },
                ],

                [
                    'items' => function () {
                        $itemQuery = ZakatStories::find()->active();
                        foreach ($itemQuery->batch(100) as $itemBatch) {
                            foreach ($itemBatch as $items) {
                                yield $items;
                            }
                        }
                    },
                    'loc' => function ($model) {
                        return ['/zakat-stories/view/', 'slug' => $model->slug];
                    },
                    'lastmod' => function ($model) {
                        return $model->updated_at;
                    },
                    'priority' => function ($model) {
                        return $model->sitemap_priority;
                    },
                ],
                [
                    'items' => function () {
                        $itemQuery = EmpowermentProducts::find()->active();
                        foreach ($itemQuery->batch(100) as $itemBatch) {
                            foreach ($itemBatch as $items) {
                                yield $items;
                            }
                        }
                    },
                    'loc' => function ($model) {
                        return ['/empowerment-products/view/', 'slug' => $model->slug];
                    },
                    'lastmod' => function ($model) {
                        return $model->updated_at;
                    },
                    'priority' => function ($model) {
                        return $model->sitemap_priority;
                    },
                ],
                [
                    'items' => function () {
                        $itemQuery = DonationProgram::find()->active();
                        foreach ($itemQuery->batch(100) as $itemBatch) {
                            foreach ($itemBatch as $items) {
                                yield $items;
                            }
                        }
                    },
                    'loc' => function ($model) {
                        return ['/donation-programs/view/', 'slug' => $model->slug];
                    },
                    'lastmod' => function ($model) {
                        return $model->updated_at;
                    },
                    'priority' => function ($model) {
                        return $model->sitemap_priority;
                    },
                ],
                [
                    'items' => function () {
                        $itemQuery = Volunteers::find()->active();
                        foreach ($itemQuery->batch(100) as $itemBatch) {
                            foreach ($itemBatch as $items) {
                                yield $items;
                            }
                        }
                    },
                    'loc' => function ($model) {
                        return ['/volunteer-programs/view/', 'slug' => $model->slug];
                    },
                    'lastmod' => function ($model) {
                        return $model->updated_at;
                    },
                    'priority' => function ($model) {
                        return $model->sitemap_priority;
                    },
                ],
                [
                    'items' => function () {
                        $itemQuery = OfferedTenders::find()->active();
                        foreach ($itemQuery->batch(100) as $itemBatch) {
                            foreach ($itemBatch as $items) {
                                yield $items;
                            }
                        }
                    },
                    'loc' => function ($model) {
                        return ['/offer-tenders/view/', 'slug' => $model->slug];
                    },
                    'lastmod' => function ($model) {
                        return $model->updated_at;
                    },
                    'priority' => function ($model) {
                        return $model->sitemap_priority;
                    },
                ],



                [
                    'items' => function () {
                        $newsQuery = News::find()->active();
                        foreach ($newsQuery->batch(100) as $newsBatch) {
                            foreach ($newsBatch as $news) {
                                yield $news;
                            }
                        }
                    },
                    'loc' => function ($model) {
                        return ['/news/view/', 'slug' => $model->slug];
                    },
                    'lastmod' => function ($model) {
                        return $model->updated_at;
                    },
                    'priority' => function ($model) {
                        return $model->sitemap_priority;
                    },
                ],
                [
                    'items' => function () {
                        $blogsQuery = Blogs::find()->active();
                        foreach ($blogsQuery->batch(100) as $blogsBatch) {
                            foreach ($blogsBatch as $blogs) {
                                yield $blogs;
                            }
                        }
                    },
                    'loc' => function ($model) {
                        return ['/blogs/view/', 'slug' => $model->slug];
                    },
                    'lastmod' => function ($model) {
                        return $model->updated_at;
                    },
                    'priority' => function ($model) {
                        return $model->sitemap_priority;
                    },
                ],

                [
                    'items' => function () {
                        $itemQuery = Testimonials::find()->active();
                        foreach ($itemQuery->batch(100) as $itemBatch) {
                            foreach ($itemBatch as $items) {
                                yield $items;
                            }
                        }
                    },
                    'loc' => function ($model) {
                        return ['/testimonials'];
                    },
                    'lastmod' => function ($model) {
                        return $model->updated_at;
                    },
                    'priority' => function ($model) {
                        return $model->sitemap_priority;
                    },
                ],

                [
                    'items' => function () {
                        $itemQuery = AnnualReport::find()->active();
                        foreach ($itemQuery->batch(100) as $itemBatch) {
                            foreach ($itemBatch as $items) {
                                yield $items;
                            }
                        }
                    },
                    'loc' => function ($model) {
                        return ['/annual-report'];
                    },
                    'lastmod' => function ($model) {
                        return $model->updated_at;
                    },
                    'priority' => function ($model) {
                        return $model->sitemap_priority;
                    },
                ],

                [
                    'items' => function () {
                        $itemQuery = Faq::find()->active();
                        foreach ($itemQuery->batch(100) as $itemBatch) {
                            foreach ($itemBatch as $items) {
                                yield $items;
                            }
                        }
                    },
                    'loc' => function ($model) {
                        return ['/faq'];
                    },
                    'lastmod' => function ($model) {
                        return $model->updated_at;
                    },
                    'priority' => function ($model) {
                        return $model->sitemap_priority;
                    },
                ],



                [
                    'items' => function () {
                        $itemQuery = MediaGallery::find()->active();
                        foreach ($itemQuery->batch(100) as $itemBatch) {
                            foreach ($itemBatch as $items) {
                                yield $items;
                            }
                        }
                    },
                    'loc' => function ($model) {
                        return ['/photo-gallery'];
                    },
                    'lastmod' => function ($model) {
                        return $model->updated_at;
                    },
                    'priority' => function ($model) {
                        return $model->sitemap_priority;
                    },
                ],
            ],
        ],
        'urlManager' => [
            'class' => 'codemix\localeurls\UrlManager',
            'showScriptName' => false,
            'enablePrettyUrl' => true,
            'languageSessionKey' =>'language',
            'languageCookieName'=>'language',
            'languages' => ['en' => 'en', 'ar' => 'ar'],
            'enableDefaultLanguageUrlCode' => true,
            'enableLanguagePersistence' => true,
            'enableLanguageDetection'=>true,
            'normalizer' => [
                'class' => 'yii\web\UrlNormalizer',
                'action' => \yii\web\UrlNormalizer::ACTION_REDIRECT_PERMANENT,
            ],
            'rules' => array(
                '/' => 'site/index',
              
                'sitemap.xml' => 'site/sitemap',

                'account' => 'account/auth/index',
                'account/profile' => 'account/profile/index',
                'account/profile/update-phone' => 'account/profile/update-phone',
                'account/profile/update-password' => 'account/profile/update-password',
                'account/profile/delete' => 'account/profile/delete',
//                'account/guarantees' => 'account/guarantees/index',
//                'account/guarantees/request-visit' => 'account/guarantees/request-visit',
//                'account/guarantees/request-call' => 'account/guarantees/request-call',
                'account/donations-history' => 'account/donations-history/index',
//                'account/my-contributions' => 'account/my-contributions/index',
                'account/payment-schedule' => 'account/payment-schedule/index',
                'account/payment-schedule/delete' => 'account/payment-schedule/delete',
                'account/card-settings' => 'account/card-settings/index',
                'account/card-settings/create' => 'account/card-settings/create',
                'account/card-settings/delete' => 'account/card-settings/delete',
                'account/card-settings/payment-handler' => 'account/card-settings/payment-handler',
                'account/secondary-users' => 'account/secondary-users/index',
                'account/secondary-users/create' => 'account/secondary-users/create',
                'account/secondary-users/update-status' => 'account/secondary-users/update-status',
                'account/settings/currencies/<slug:[\w \-]+>/switch' => 'account/settings/currency-switch',
                'account/<action:[\w \-]+>' => 'account/auth/<action>',

                '<controller:(donation-programs)>' => '<controller>/index',
                '<controller:(donation-programs)>/add-cart' => '<controller>/add-to-cart',
                '<controller:(donation-programs)>/<slug:[\w \-]+>' => '<controller>/view/',

                '<controller:(cart)>' => '<controller>/index',
                '<controller:(cart)>/items-count' => '<controller>/items-count',
                '<controller:(cart)>/add' => '<controller>/add',
                '<controller:(cart)>/delete/<item:[\w \-]+>' => '<controller>/delete',
                '<controller:(cart)>/increment/<item:[\w \-]+>' => '<controller>/increment',
                '<controller:(cart)>/decrement/<item:[\w \-]+>' => '<controller>/decrement',

                '<controller:(payment)>' => '<controller>/index',
                '<controller:(payment)>/checkout' => '<controller>/checkout',
                '<controller:(payment)>/verify' => '<controller>/verify',
                '<controller:(payment)>/hyper-pay-handler' => '<controller>/hyper-pay-handler',
                '<controller:(payment)>/cards/<card:[\w \-]+>' => '<controller>/card',
                '<controller:(payment)>/success' => '<controller>/success',

                '<controller:(api)>/country/<id:[0-9]+>' => '<controller>/country',

                '<controller:(donate-child-gift)>' => '<controller>/index',
                
                '<controller:(news)>/search/<search_slugs:[\w /-]+>' => '<controller>/index/',
                
                '<controller:(news)>' => '<controller>/index',
                '<controller:(news)>/<slug:[\w \-]+>' => '<controller>/view/',

                '<controller:(empowerment-products)>' => '<controller>/index',
                '<controller:(empowerment-products)>/search/<search_slugs:[\w /-]+>' => '<controller>/index/',

                '<controller:(empowerment-products)>/<slug:[\w \-]+>' => '<controller>/view/',

                '<controller:(blogs)>/search/<search_slugs:[\w /-]+>' => '<controller>/index/',
                '<controller:(blogs)>' => '<controller>/index',
                '<controller:(blogs)>/<slug:[\w \-]+>' => '<controller>/view/',

                '<controller:(number-of-benefit)>' => '<controller>/index',
                '<controller:(number-of-benefit)>/<slug:[\w \-]+>' => '<controller>/view/',

                'donation-tool/search/<search_slugs:[\w /-]+>' => 'site/donation-tool',
                'our-partner/search/<search_slugs:[\w /-]+>' => 'site/our-partner',

                '<controller:(testimonials)>' => '<controller>/index',
                '<controller:(annual-report)>' => '<controller>/index/',

                '<controller:(faq)>' => '<controller>/index/',

                
                ///// our partner load more
                'our-partner/next' => 'site/our-partner-next',
                
                '<action:(contact-us|intimation|join-us|protection|sea-allegation|donation-campaign|udheia)>' => '/webforms/<action>',

                'udheia/<slug:[\w \-]+>' => 'webforms/udheia-result',
                
                '<controller:(e-card)>/step-one' => '<controller>/step-one',
                '<controller:(e-card)>/step-two' => '<controller>/step-two',
                '<controller:(e-card)>/step-three' => '<controller>/step-three',



                '<controller:(donate-gift)>/step-one' => '<controller>/step-one',
                '<controller:(donate-gift)>/step-two' => '<controller>/step-two',
                '<controller:(donate-gift)>/step-three' => '<controller>/step-three',


                'contact-us/complaint' => 'webforms/complaint',

                '<controller:(zakat-stories)>' => '<controller>/index',
                '<controller:(zakat-stories)>/search/<search_slugs:[\w /-]+>' => '<controller>/index/',
                '<controller:(zakat-stories)>/<slug:[\w \-]+>' => '<controller>/view/',
        
                '<controller:(offer-tenders)>' => '<controller>/index/',
                '<controller:(offer-tenders)>/<slug:[\w \-]+>' => '<controller>/view/',

                '<action:(contact-us|intimation|join-us|protection|sea-allegation|zakat-calculation)>' => '/webforms/<action>',

                '<controller:(volunteer-programs)>' => '<controller>/index',
                '<controller:(volunteer-programs)>/<action:(next)>' => '<controller>/<action>',

                '<controller:(volunteer-programs)>/country-city' => '<controller>/country-city',
                '<controller:(volunteer-programs)>/<slug:[\w \-]+>' => '<controller>/view/',



                '<controller:(photo-gallery)>/search/<search_slugs:[\w /-]+>' => '<controller>/index/',
                '<controller:(photo-gallery)>' => '<controller>/index',
                '<controller:(photo-gallery)>/<slug:[\w \-]+>' => '<controller>/view/',

                '<controller:(video-gallery)>' => '<controller>/index',
                '<controller:(video-gallery)>/<slug:[\w \-]+>' => '<controller>/view/',

                'page/<slug:[\w \-]+>' => 'site/page/',

                '<slug:[\w \-]+>' => 'site/index/',
                '<action:[\w \-]+>' => 'site/<action>',

                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),
            'ignoreLanguageUrlPatterns' => [
                '#^auth/default/oauth#' =>'#^auth/default/oauth#',
                '#^uploads/#' => '#^uploads/#',
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
        'assetManager' => [
            'bundles' => [
                'yii\jui\JuiAsset' => [
                    'sourcePath' => null,
                    'basePath' => '@webroot',
                    'baseUrl' => '@web',
                    'js' => [
                    ],
                    'css' => [
                    ]
                ],

                'yii\bootstrap\BootstrapAsset' => [
                    'sourcePath' => null,
                    'basePath' => '@webroot',
                    'baseUrl' => '@web',
                    'js' => [
                    ],
                    'css' => [
                    ]
                ],
                'yii\bootstrap4\BootstrapAsset' => [
                    'sourcePath' => null,
                    'basePath' => '@webroot',
                    'baseUrl' => '@web',
                    'js' => [
                    ],
                    'css' => [
                    ]
                ],
                'yii\bootstrap5\BootstrapAsset' => [
                    'sourcePath' => null,
                    'basePath' => '@webroot',
                    'baseUrl' => '@web',
                    'js' => [
                    ],
                    'css' => [
                    ]
                ],
                'yii\bootstrap\BootstrapPluginAsset' => false,
                'yii\bootstrap4\BootstrapPluginAsset' => false,
                'yii\bootstrap5\BootstrapPluginAsset' => false,
            ],
        ],
    ],
    'params' => $params,
];
