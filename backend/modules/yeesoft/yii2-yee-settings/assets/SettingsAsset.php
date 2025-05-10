<?php

namespace yeesoft\settings\assets;

use yii\web\AssetBundle;

/**
 * SettingsAsset.
 *
 * @author Taras Makitra <makitrataras@gmail.com>
 */
class SettingsAsset extends AssetBundle
{
    public $sourcePath = '@backend/modules/yeesoft/yii2-yee-settings/assets/source';
    public $css = [
        'css/settings.css',
    ];
    public $js = [
        '/js/ace.js',
    ];
    public $depends = [
        'yii\bootstrap5\BootstrapAsset',
        'yii\web\JqueryAsset',
        'yeesoft\assets\YeeAsset'
    ];

}