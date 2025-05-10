<?php

namespace yeesoft\media\assets;

use yii\web\AssetBundle;

class MediaAsset extends AssetBundle
{
    public $sourcePath = '@backend/modules/yeesoft/yii2-yee-media/assets/source';
    public $css = [
        'css/media.css',
    ];
    public $js = [
        'js/media.js',
    ];
    public $depends = [
        'yii\bootstrap5\BootstrapAsset',
        'yii\web\JqueryAsset',
    ];
}
