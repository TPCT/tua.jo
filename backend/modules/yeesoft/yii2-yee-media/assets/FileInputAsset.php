<?php

namespace yeesoft\media\assets;

use yii\web\AssetBundle;

class FileInputAsset extends AssetBundle
{
    public $sourcePath = '@backend/modules/yeesoft/yii2-yee-media/assets/source';

    public $js = [
        'js/fileinput.js',
    ];

    public $depends = [
        'yii\bootstrap5\BootstrapAsset',
        'yii\web\JqueryAsset',
        'yeesoft\media\assets\ModalAsset',
    ];
}
