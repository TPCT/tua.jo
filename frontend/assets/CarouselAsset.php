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
class CarouselAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';


    public $jsOptions = array(
        'position' => \yii\web\View::POS_END
    );



    public $css = [
        '/theme/css/carousel.css',
        '/theme/css/owl.carousel.css',
    ];
    public $js = [
        '/theme/js/carousel.umd.js',
        '/theme/js/owl.carousel.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',

    ];

    public function init()
    {
        parent::init();
    }

}