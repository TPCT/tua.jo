<?php

namespace frontend\models;

use backend\modules\currency\models\Currency;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class ZakaForm extends Model
{
    public $type;
    public $calender;
    public $currency_with_gold;
    public $weight_gold_24;
    public $weight_gold_21;
    public $weight_gold_18;

    public $cashList;

    public $reCaptcha;


    const HAS_GOLD = 1;
    const HAS_CASH = 2;

    const HIJRI=1;
    const GREGORIAN=2;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return 
        [

            [
                [
                    'type', 'calender', 'currency_with_gold', 'weight_gold_24',
                     'weight_gold_21', 'weight_gold_18'
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
                    'type', 'calender', 'currency_with_gold', 'weight_gold_24',
                     'weight_gold_21', 'weight_gold_18'
                ], function ($attribute) {
                $this->$attribute = \yii\helpers\HtmlPurifier::process($this->$attribute);
            }],

            [
                [
                    // 'reCaptcha',
                    'type', 'calender'
                ], 'required'
            ],
            [['type', 'calender', 'currency_with_gold'],'integer'],
            [
                [
                    'weight_gold_24',
                    'weight_gold_21', 'weight_gold_18', 
                ],'number'
            ],
            [
                [
                    'currency_with_gold'
                ],'required', 'when' => function ($model) {
                    if($model->type == self::HAS_GOLD)
                    {return true;}
                },'whenClient' => "function (attribute, value) {
                    if( $('#zakaform-type-gold').val() == 1 ){
                        return true;
                    }
                }"
            ],

            // [['reCaptcha'], \himiklab\yii2\recaptcha\ReCaptchaValidator::className(),
            //     'uncheckedMessage' => 'Please confirm that you are not a bot.'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {   
        return 
        [
            'type' => Yii::t('site', 'Type'),
            'calender' => Yii::t('site', 'CALENDER'),
            'currency_with_gold' => Yii::t('site', 'CURRENCY_LABEL'),
            'weight_gold_24' => Yii::t('site', 'WEIGHT_GOLD_24'),
            'weight_gold_21' => Yii::t('site', 'WEIGHT_GOLD_21'),
            'weight_gold_18' => Yii::t('site', 'WEIGHT_GOLD_18'),
        ];
    }

    public function getTypeList()
    {
        return
        [
            self::HAS_GOLD => Yii::t("site","HAS_GOLD"),
            self::HAS_CASH => Yii::t("site","HAS_CASH"),
        ];
    }

    public function getCalenderList()
    {
        return
        [
            self::HIJRI => Yii::t("site","HIJRI"),
            self::GREGORIAN => Yii::t("site","GREGORIAN"),
        ];
    }

    public static function getAllCurrencies()
    {
        $items = Currency::find()->active()->all();
        return ArrayHelper::map($items,"id","title");
    }


    public function getResult()
    {
        $total =0;


        if($this->type == self::HAS_CASH)
        {

            $data = Yii::$app->request->post();

            $amounts = $data["ZakaFormDynamicAmoutCurrency"];
            foreach($amounts as $item)
            {
                
                $total += $this->convertoNationalCurrency($item["currency_with_cash"],$item["amount"]);
            }
 
            return $this->calculateElzaka($total);
        }
        else if($this->type == self::HAS_GOLD)
        {
            $total += (float) $this->weight_gold_24 * (float) Yii::$app->settings->get('site.gold_24_price');
            $total += (float) $this->weight_gold_21 * (float) Yii::$app->settings->get('site.gold_21_price');
            $total += (float) $this->weight_gold_18 * (float) Yii::$app->settings->get('site.gold_18_price');

            $zakaInNationalCurrency = $this->calculateElzaka($total);
            if(is_numeric($zakaInNationalCurrency))
            {
     
                return $this->converFromNationalCurrency($this->currency_with_gold,$zakaInNationalCurrency);
            }
            return $zakaInNationalCurrency;
            
        }



    }


    private function calculateElzaka($total)
    {

        $alnisab = 85 * Yii::$app->settings->get('site.gold_21_price');

        if($total >= $alnisab)
        {
            if ($this->calender == self::HIJRI)
            {
                $total = ($total * 2.5)/100; 
                $result = round($total,2);

            }
            else if ($this->calender == self::GREGORIAN)
            {
                $total = ($total * 2.577)/100; 
                $result = round($total,2);

            
            }
            else
            {
                $result = Yii::t("site","INVALID_CALENDER");
            }

        }
        else
        {
            $result = "<br/>" . Yii::t("site","SORRY_THE_INSERTED_AMOUNT") . "<br/>" . Yii::t("site","AL_NISAB") . " = " . $alnisab ;
        }
        return $result;
    }


    private function convertoNationalCurrency($currencyID,$amount)
    {
        $result = "NOT VALID CURRENCY";
        $currency = Currency::find()->active()->andWhere(["id"=>$currencyID])->one();
        if($currency)
        {            
            if(!$currency->national_currency)
            {
                $result = $amount * $currency->currencyPrice->sell_price;
            }
            else
            {
                $result = $amount;
            }
        }

        return $result;

    }


    private function converFromNationalCurrency($currencyID,$amount)
    {
        $result = "NOT VALID CURRENCY";
        $currency = Currency::find()->active()->andWhere(["id"=>$currencyID])->one();
        if($currency)
        {            
            if(!$currency->national_currency)
            {
                $result = round( $amount / $currency->currencyPrice->sell_price, 2);
            }
            else
            {
                $result = round($amount,2) ;
            }
        }

        return $result;

    }


}
