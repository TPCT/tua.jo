<?php

namespace backend\modules\youtube;

/**
 * youtube module definition class
 */
class YoutubeModule extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'backend\modules\youtube\controllers';

    public $thumbnailSize = 'medium';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
