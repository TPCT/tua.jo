<?php

namespace backend\modules\header_image;

/**
 * news module definition class
 */
class HeaderImageModule extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'backend\modules\header_image\controllers';

    public $viewList;
    public $layoutList;

    public $headerImageView;

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
        if (empty($this->headerImageView)) {
            $this->headerImageView = [
                'header_image' => \Yii::t('yee', 'Header Image Default'),
                'header_image_with_ticker' => \Yii::t('yee', 'Header Image With Ticker'),
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
