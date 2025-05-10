<?php

namespace frontend\modules\account\models\card\forms;

use frontend\components\HyperPay;
use frontend\modules\account\models\card\Card;
use frontend\modules\account\models\client\Client;
use Yii;
use yii\base\Model;

class CreateCardForm extends Model
{
    public $card_number;
    public $expiry_date;
    public $card_holder_name;
    public $card_cvv;

    private ?Client $_client = null;

    public function rules()
    {
        return [
            [['card_number', 'expiry_date', 'card_holder_name', 'card_cvv'], 'required'],
            [['card_number', 'card_holder_name'], 'string', 'max' => 255],
            [['expiry_date'], 'string', 'max' => 7],
            [['card_cvv'], 'number'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'card_number' => 'Card Number',
            'expiry_date' => 'Expiry Date',
            'card_holder_name' => 'Card Holder Name',
            'card_cvv' => 'Card CVV',
        ];
    }

    public function create(){
        if ($this->validate()){
            [$month, $year] = explode('.', $this->expiry_date);
            $response = HyperPay::checkout(1);
            if ($response['status'] && $payment = HyperPay::pay($response['data']['registrationId'], 1)){

            }
            if ($response['status']){
                $response = $response['data'];
                $card = new Card();
                $card->parent_id = Yii::$app->user->id;
                $card->token = $response['id'];
                $card->bin = $response['card']['bin'];
                $card->last_four_digits = $response['card']['last4Digits'];
                $card->holder = $response['card']['holder'];
                $card->expiry_month = $response['card']['expiryMonth'];
                $card->expiry_year = $response['card']['expiryYear'];
                return $card->save();
            }
            $this->addError("card_number", Yii::t("app", "Card number not valid"));
        }
    }
}