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
class YoutubeAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';


    public $jsOptions = array(
        'position' => \yii\web\View::POS_END
    );



    public $css = [

        'css/youtube-faster.css'
    ];
    public $js = [

        'js/youtube-faster.js',
        'https://www.youtube.com/iframe_api'
        
    ];
    public $depends = [
        'frontend\assets\AppAsset',
        //'yii\jui\JuiAsset',
        //'yii\web\YiiAsset',
        //        'yii\bootstrap\BootstrapPluginAsset',//Both JS & CSS

    ];

    public function init()
    {
        parent::init();

    }

}