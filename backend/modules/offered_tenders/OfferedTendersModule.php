<?php

namespace backend\modules\offered_tenders;

/**
 * OfferedTendersModule definition class
 */
class OfferedTendersModule extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'backend\modules\offered_tenders\controllers';

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
