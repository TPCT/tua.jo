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
class PhoneAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';


    public $jsOptions = array(
        'position' => \yii\web\View::POS_END,
    );

    public $css = [

        '/theme/css/intlTelInput.min.css',

    ];

    public $js = [

       '/theme/js/intlTelInputWithUtils.min.js',

    ];

    public $depends = [
        'yii\web\JqueryAsset',
    ];

    public function init()
    {
        parent::init();
    }

}