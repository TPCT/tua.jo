<?php

namespace frontend\modules\account\models\client\forms;

use frontend\modules\account\models\client\Client;
use libphonenumber\PhoneNumberUtil;
use Yii;
use yii\base\Model;

class UpdatePhoneForm extends Model
{
    public $country_code;
    public $phone;
    public $otp;

    public function rules()
    {
        return [
            [['phone'], 'required', 'on' => 'updatePhone'],
            [['phone'], 'string', 'max' => 255, 'on' => 'updatePhone'],
            [['phone'], 'validatePhone', 'on' => 'updatePhone'],
            [['phone'], 'validateTime', 'on' => 'updatePhone'],

            [['otp'], 'required', 'on' => 'updateOtp'],
            [['otp'], 'string', 'max' => 50, 'on' => 'updateOtp'],
            [['otp'], 'validateOtp', 'on' => 'updateOtp']
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'phone' => Yii::t('site','PHONE'),
        ];
    }

    public function scenarios()
    {
        return [
            'updatePhone' => ['country_code', 'phone'],
            'updateOtp' => ['otp'],
        ];
    }

    public function validatePhone($attribute, $params){
        try{
            $phone = PhoneNumberUtil::getInstance()->parse($this->$attribute);
            if (!PhoneNumberUtil::getInstance()->isValidNumber($phone)){
                $this->addError($attribute, \Yii::t('site','Phone number is invalid'));
                return false;
            }

            [$this->country_code, $this->phone] = [(String) $phone->getCountryCode(), $phone->getNationalNumber()];
            $this->country_code = str_replace('+', '', $this->country_code);

            if (Client::find()->where([
                'country_code' => $this->country_code,
                'phone' => $this->phone,
            ])->exists()){
                $this->addError($attribute, \Yii::t('site','Phone number is invalid'));
                return false;
            }

        }catch (\Exception $e){
            $this->addError($attribute, \Yii::t('site','Phone number is invalid'));
        }
    }

    public function validateTime($attribute, $params)
    {
        $client = Yii::$app->user->identity;
        if (time() - $client->phone_changed_at < 3600 * 24 || ($client->otp_counts >= 3 && time() - $client->otp_send_at < 3600 * 24)) {
            $this->addError($attribute, \Yii::t('site', "This phone can't be changed"));
        }
    }


    public function validateOtp($attribute, $params){
        $client = Yii::$app->user->identity;
        if (time() - $client->otp_send_at < 60*3 && $this->$attribute == $client->otp){
            return true;
        }

        $this->addError($attribute, \Yii::t('site', "This otp is invalid"));
        return false;
    }
}