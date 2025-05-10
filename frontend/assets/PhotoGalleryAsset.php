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
class PhotoGalleryAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';





    public $css = [
        'css/PhotoGallery.css',
        'css/PhotoGallery2.css'
    ];


    public $depends = [
        'frontend\assets\AppAsset',
        'yii\jui\JuiAsset',
    ];


    public function init()
    {
        parent::init();
    }

}