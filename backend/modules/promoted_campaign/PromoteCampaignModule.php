<?php

namespace backend\modules\promoted_campaign;

/**
 * PromoteCampaignModule definition class
 */
class PromoteCampaignModule extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'backend\modules\promoted_campaign\controllers';

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
