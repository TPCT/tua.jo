<?php

namespace backend\modules\redirect_url;

/**
 * news module definition class
 */
class RedirectUrlModule extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'backend\modules\redirect_url\controllers';

    public $viewList;
    public $layoutList;

    public $thumbnailSize = 'medium';

    /**
     * {@inheritdoc}
     */

    public function init()
    {
        if (empty($this->viewList)) {
            $this->viewList = [
                'page' => \Yii::t('site', 'Page view')
            ];
        }

        if (empty($this->layoutList)) {
            $this->layoutList = [
                'main' => \Yii::t('site', 'Main layout')
            ];
        }

        parent::init();
    }

}
