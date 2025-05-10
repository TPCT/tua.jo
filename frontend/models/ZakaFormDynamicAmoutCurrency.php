<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class ZakaFormDynamicAmoutCurrency extends Model
{
    public $currency_with_cash;
    public $amount;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return 
        [
            [
                [
                    'currency_with_cash', 'amount'
                ], 
                function ($attribute) 
                {
                    if (preg_match('/<[^b][^r][^>]*>/', $this->$attribute)) {
                        $this->addError($attribute, Yii::t('site', 'HTML is invalid.'));
                    }
                }
            ],
            
            [   
                [
                    'currency_with_cash', 'amount'
                ], function ($attribute) {
                $this->$attribute = \yii\helpers\HtmlPurifier::process($this->$attribute);
            }],
            
            [['amount'],'number'],
            [['currency_with_cash'],'integer'],
            
            [['amount','currency_with_cash'],'required', 'when' => function ($model) {
                    if($model->type == ZakaForm::HAS_CASH) {return true;}
                },'whenClient' => "function (attribute, value) {
                    if( $('#zakaform-type').val() == 2 ){
                        return true;
                    }
                }"
            ],
            
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {   
        return 
        [
            'currency_with_cash' => Yii::t('site', 'CURRENCY'),
            'amount' => Yii::t('site', 'AMOUNT'),
        ];
    }

    
    


}
