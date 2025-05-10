<?php

namespace frontend\widgets\donation_programs;

use backend\modules\donation\models\Donation;
use backend\modules\donation_programs\models\DonationProgram;
use common\components\TuaClient;
use frontend\modules\account\models\client\Client;
use Yii;
use backend\modules\currency\models\Currency;
use yii\helpers\ArrayHelper;

class DonationPrograms extends \yii\base\Widget
{
    public $title = '';
    public $subtitle = '';
    public $id = '';

    public function run()
    {
        $data['title'] = $this->title;
        $data['subtitle'] = $this->subtitle;
        switch ($this->id){
            case 'payment-success-donations-programs';
                $data['programs'] = DonationProgram::find()->active()->andWhere(['promote_to_payment_page' => true])->all();
                break;
            default:
                $data['programs'] = DonationProgram::find()->active()->all();
        }
        $data['id'] = $this->id;
        return $this->render('view',$data);
    }
}