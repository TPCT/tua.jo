<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;

use Yii;
use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class SweetAlertAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';


    public $jsOptions = array(
        'position' => \yii\web\View::POS_END
    );



    public $css = [
        
    ];
    public $js = [
        'https://cdn.jsdelivr.net/npm/sweetalert',
    ];
    public $depends = [
        'backend\assets\AppAsset',

    ];

    public function init()
    {
        parent::init();

    }

}