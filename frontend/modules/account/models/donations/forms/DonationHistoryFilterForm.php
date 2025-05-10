<?php

namespace frontend\modules\account\models\donations\forms;

use backend\modules\sponsorship_families\models\SponsorshipFamilies;
use backend\modules\webforms\models\RequestCallWebform;
use borales\extensions\phoneInput\PhoneInputValidator;
use frontend\modules\account\models\client\Client;
use libphonenumber\PhoneNumberUtil;
use Yii;
use yii\base\Model;

class DonationHistoryFilterForm extends Model
{
    public $start_date;
    public $end_date;
    public $name;


    public function rules()
    {
        return [
            ['start_date', 'date', 'format' => 'php:Y-m-d'],
            ['end_date', 'date', 'format' => 'php:Y-m-d'],
            ['name', 'string', 'max' => 255],
            ['page', 'integer']
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => Yii::t('site', 'Name'),
            'start_date' => Yii::t('site', 'Start Date'),
            'end_date' => Yii::t('site', 'End Date')
        ];
    }

    public function filter($donations, $users){
        if ($this->validate()){
            $filtered = [];
            $start_date = $this->start_date ? (new \DateTime($this->start_date))->getTimestamp() : 0;
            $end_date = $this->end_date ? (new \DateTime($this->end_date))->getTimestamp() : INF;
            $this->name = $this->name ? $users[$this->name] : null;

            foreach ($donations as $donation){
                if ($this->name && $donation['DonorName'] != $this->name)
                    continue;
                if ($donation['timestamp'] < $start_date || $donation['timestamp'] > $end_date)
                    continue;
                $filtered[] = $donation;
            }
            return $filtered;
        }
        return $donations;
    }
}