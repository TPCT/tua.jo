<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;

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
        'position' => \yii\web\View::POS_BEGIN
    );

    public $css = [
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css',
        'css/site.css',
    ];
    public $js = [

        'js/scripts.js',
        'js/jquery.redirect.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset',
    ];


    public function init()
    {
        //$mapKey = \Yii::$app->params['googleMapsApiKey'];

        //$this->js[] = "https://maps.googleapis.com/maps/api/js?key={$mapKey}&language=3.1.18&version=3.1.18&libraries=en";

        parent::init();
    }

}
