<?php

namespace backend\modules\recurring_items;

/**
 * NewsModule definition class
 */
class RecurringItemsModule extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'backend\modules\recurring_items\controllers';

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
                'page' => \Yii::t('yee', 'Page view')
            ];
        }

        if (empty($this->layoutList)) {
            $this->layoutList = [
                'main' => \Yii::t('yee', 'Main layout')
            ];
        }

        parent::init();
    }
}
