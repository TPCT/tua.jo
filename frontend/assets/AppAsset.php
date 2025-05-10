<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use Yii;
use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';


    public $jsOptions = array(
        'position' => \yii\web\View::POS_END,
    );

    public $css = [
        '/theme/css/bootstrap/bootstrap.min.css',
        '/theme/js/slick-1.8.1/slick/slick.css',
        '/theme/css/carousel.css',
         '/theme/css/swiper-bundle.min.css',
       // '/theme/css/intlTelInput.min.css',
        '/theme/css/fancybox.css',
        '/theme/css/regular.css',
        '/theme/css/solid.css',
        '/theme/css/brands.css',
        '/theme/css/fontawesome.css',
        '/theme/css/footer.css',
        '/theme/css/navbar.css',
    ];

    public $js = [
        '/theme/js/slick-1.8.1/slick/slick.min.js',
        '/theme/js/fancybox.js',
        '/theme/js/bootstrap/bootstrap.bundle.min.js',
        '/theme/js/swiper-bundle.min.js',
        '/theme/js/share-btn.js',
        '/theme/js/menu.js',
        '/theme/js/main.js',
        '/theme/js/charts.js',

    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];

    public function init()
    {
        parent::init();
    }

}