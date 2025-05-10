<?php

namespace common\jobs;

use frontend\widgets\WebpImage;
use yii\base\BaseObject;
use Yii;

class ConvertImageToWebpJob extends BaseObject implements \yii\queue\JobInterface
{

    public $config;

    public function execute($queue = null)
    {
        Yii::setAlias('@webroot', Yii::getAlias('@frontend') . '/web');
        WebpImage::widget($this->config);
    }

}
