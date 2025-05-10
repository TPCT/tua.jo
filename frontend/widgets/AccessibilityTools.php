<?php

namespace frontend\widgets;

use backend\modules\news\models\News;
use common\helpers\Utility;
use frontend\assets\AccessibilityAsset;

class AccessibilityTools extends \yii\base\Widget
{


    public function init()
    {
        parent::init();

    }

    public function run()
    {


        return $this->render('accessibility', []);
    }
}