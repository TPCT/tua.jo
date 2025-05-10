<?php

namespace frontend\models;

use backend\modules\currency\models\Currency;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class UdheiaForm extends Model
{
    public $reciept_number;


    public $reCaptcha;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return 
        [

            [
                [
                    'reciept_number'
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
                    'reciept_number'
                ], function ($attribute) {
                $this->$attribute = \yii\helpers\HtmlPurifier::process($this->$attribute);
            }],

            [
                [
                    // 'reCaptcha',
                    'reciept_number'
                ], 'required'
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
            'reciept_number' => Yii::t('site', 'RECIEPT_NUMBER'),

        ];
    }

}
