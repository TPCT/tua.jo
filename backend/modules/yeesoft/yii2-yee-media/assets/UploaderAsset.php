<?php

namespace yeesoft\media\assets;

use yii\web\AssetBundle;

class UploaderAsset extends AssetBundle
{
    public $sourcePath = '@backend/modules/yeesoft/yii2-yee-media/assets/source';
    public $css = [
        'css/uploader.css',
    ];
    public $depends = [
        'yii\bootstrap5\BootstrapAsset',
    ];
}
