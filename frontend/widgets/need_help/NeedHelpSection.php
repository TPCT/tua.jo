<?php

namespace frontend\widgets\need_help;

use backend\modules\bms\models\Bms;
use backend\modules\newsletter\models\NewsletterClientList;
use Yii;

class NeedHelpSection extends \yii\base\Widget
{

    public function run()
    {
        $data['needHelp'] = Bms::find()
                            ->activeWithCategoryAndSection("second-design-home-page-need-help")
                            ->one();

        $data['model'] = new NewsletterClientList();
       
                            
        return $this->render('view', $data);
        
        
    }
}