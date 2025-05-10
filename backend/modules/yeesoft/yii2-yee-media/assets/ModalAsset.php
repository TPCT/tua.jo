<?php

namespace yeesoft\media\assets;

use yii\web\AssetBundle;

class ModalAsset extends AssetBundle
{
    public $sourcePath = '@backend/modules/yeesoft/yii2-yee-media/assets/source';
    public $css = [
        'css/modal.css',
    ];
    public $depends = [
        'yii\bootstrap5\BootstrapAsset',
    ];
}
