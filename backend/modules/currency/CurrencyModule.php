<?php

namespace backend\modules\currency;

/**
 * news module definition class
 */
class CurrencyModule extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'backend\modules\currency\controllers';

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
