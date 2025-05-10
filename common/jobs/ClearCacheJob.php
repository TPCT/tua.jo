<?php

namespace common\jobs;

use frontend\widgets\WebpImage;
use yeesoft\helpers\YeeHelper;
use Yii;
use yii\base\BaseObject;

class ClearCacheJob extends BaseObject implements \yii\queue\JobInterface
{

//    public $config;

    public function execute($queue = null)
    {

        $frontendAssetPath = Yii::getAlias('@frontend') . '/web/assets/';
        $backendAssetPath = Yii::getAlias('@backend') . '/web/assets/';

        YeeHelper::recursiveDelete($frontendAssetPath);
        YeeHelper::recursiveDelete($backendAssetPath);

        if (!is_dir($frontendAssetPath)) {
            @mkdir($frontendAssetPath);
        }

        if (!is_dir($backendAssetPath)) {
            @mkdir($backendAssetPath);
        }

        Yii::$app->cache->flush();

    }

}
