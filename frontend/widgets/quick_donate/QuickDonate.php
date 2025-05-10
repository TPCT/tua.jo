<?php

namespace frontend\widgets\quick_donate;
use common\components\traits\BreadCrumbSchemaTrait;
use backend\modules\promoted_campaign\models\PromotedCampaign;


use frontend\modules\account\models\client\Client;
use Yii;


class QuickDonate extends \yii\base\Widget
{


    public function run()
    {
 
        $data['program'] = PromotedCampaign::find()->active()->where(['promoted_to_front'=>PromotedCampaign::STATUS_PUBLISHED])->one();

        
        return $this->render('view',$data);

 
    
    }
}