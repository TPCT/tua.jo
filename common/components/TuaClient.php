<?php

namespace common\components;

use backend\modules\transaction\models\TransactionItem;
use common\helpers\Utility;
use frontend\modules\account\models\client\Client;
use yeesoft\Yee;

class TuaClient
{
    public const GUEST_DONOR_ID = "3A117908-F96B-E911-80CD-00155D82D33E";
    public const PUBLIC_DONATIONS_TYPE_ID = "6f743002-50de-e211-948f-940c6d83a924";
    public const E_CARD_RECEIPT_TYPE = "157630000";
    public const GIFTS_RECEIPT_TYPE = "157630001";
    public const CHILD_GIFTS_RECEIPT_TYPE = "157630002";

    private const GENDERS = [
        'Male' => '157630000',
        'Female' => '157630001',
    ];

    private const TRANSACTION_TYPES = [
        'ONE TIME' => 157630000,
        'RECURRING' => 157630001
    ];

    public const CURRENCIES = [
        "jod" => "6CF8768F-54C1-E211-873C-940C6D83A924",
        "usd" => "B0A91E97-7C8D-E811-94FB-00155D82C842"
    ];

    public const QOption1 = [
        157630000 => "Very Easy",
        157630001 => "Easy",
        157630002 => "Neutral",
        157630003 => "Difficult",
        157630004 => "Very Difficult",
    ];

    public const QOption2 = [
        157630000 => "No, the process was smooth",
        157630001 => "Yes, I faced challenge",
    ];

    public const QOption3 = [
        157630000 => "Very Satisfied",
        157630001 => "Satisfied",
        157630002 => "Neutral",
        157630003 => "Unsatisfied",
        157630004 => "Very Unsatisfied",
    ];

    public const CompliantType = [
        157630001 => "complaint_type_1",
        157630002 => "complaint_type_2",
        157630003 => "complaint_type_3",
    ];

    public const QOption5_7 = [
        1 => "true",
        0 => "false",

    ];

    private static function sendRequest($endpoint, $method = 'POST', $payload = null){
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization: Basic ' . base64_encode(\Yii::$app->params['TUA_CLIENT_AUTH_USERNAME'] . ':' . \Yii::$app->params['TUA_CLIENT_AUTH_PASSWORD']),
        ];

        if ($method == "POST"){
            $headers['Content-Length'] = strlen(json_encode($payload));
        }

        $client = new \yii\httpclient\Client();

        return $client->createRequest()
            ->setMethod($method)
            ->setUrl(\Yii::$app->params['TUA_CLIENT_HOST'] . $endpoint)
            ->setFormat(\yii\httpclient\Client::FORMAT_JSON)
            ->setHeaders($headers)
            ->setData($payload)
            ->send()
            ->data;
    }

    public static function createContact(Client $client){
        $payload = [
            'Fullname' => $client->first_name . ' ' . $client->last_name,
            'phonenumber' => '',
            'Internationalphone' => '',
            'Email' => $client->email,
            'Country' => $client->residency->guid,
            'Nationality' => $client->nationality->guid,
            'Gender' => self::GENDERS[$client->gender],
        ];

        if ($client->country_code == "962")
            $payload['phonenumber'] = $client->phone;
        else
            $payload['Internationalphone'] = $client->country_code . $client->phone;

        return static::sendRequest("CreateContact", "POST", $payload);
    }

    public static function insertDonation($transaction, $item, $receipt_type=0){
        $donation_item = new TransactionItem();
        $donation_item->transaction_id = $transaction->id;
        $donation_item->donation_id = '40' . date('y') . '-' . '0000000';
        $donation_item->donor_id = $item['donor_id'];
        $donation_item->donation_type = $item['donation'];
        $donation_item->campaign_id = $item['campaign'];
        $donation_item->type = $item['type'];
        $donation_item->amount = (float)$item['total_jod'];
        $donation_item->amount_usd = (float)$item['total_usd'];
        $donation_item->quantity = (int)$item['quantity'];
        $donation_item->quantity *= ($item['type'] == 2 && $item['recurrence'] == "yearly" ? 12 : 1);


        $donation_item->currency = $item['currency'] ?? self::CURRENCIES[Utility::selected_currency('slug')];
        $donation_item->order_id = $transaction->payment_id;
        $donation_item->transaction_type = $item['recurrence'] == "once" ? self::TRANSACTION_TYPES["ONE TIME"] : self::TRANSACTION_TYPES["RECURRING"];
        $donation_item->receipt_type = $receipt_type;
        $donation_item->recipient_name = $item['recipient_name'] ?? "";
        $donation_item->recipient_email = $item['recipient_email'] ?? "";
        $donation_item->recipient_phone = $item['recipient_phone'] ?? "";
        $donation_item->save(false);

        $donation_id = '40' . date('y') . '-' . str_pad(12000 + $donation_item->id, 7, '0', STR_PAD_LEFT);
//        $donation_id = '4000-' . str_pad(3 + $donation_item->id, 7, '0', STR_PAD_LEFT);

        $donation_item->updateAttributes([
            'donation_id' => $donation_id
        ]);
        self::Donate($donation_item);
        return $donation_item;
    }

    public static function Donate(TransactionItem $item){
        $payload = [
            'DonationDate' => date('Y-m-d H:i:s'),
            'DonationID' => $item->donation_id,
            'DonorID' => $item->donor_id,
            'DonationType' => $item->donation_type,
            'CampaignID' => $item->campaign_id,
            'Amount' => (float)$item->amount,
            'AmountUSD' => (float)$item->amount_usd,
            'Quantity' => (int)$item->quantity,
            "Currency" => $item->currency,
            "OrderID" => $item->order_id,
            'TransactionType' => $item->transaction_type,
            'ReceiptType' => $item->receipt_type,
            'RecipientName' => $item->recipient_name ?? "",
            'RecipientEmail' => $item->recipient_email ?? "",
            'RecipientPhoneNumber' => $item->recipient_phone ?? ""
        ];

        $response = static::sendRequest("InsertDonation", "POST", $payload);

        if ($response['success']){
            $item->updateAttributes([
                'api_transaction_id' => $response['response'][0],
                'status' => true
            ]);
        }
    }

    public static function DonationTypes(){
        return static::sendRequest("DonationTypes", "GET", null);
    }

    public static function SponsorshipFamilies(){
        return static::sendRequest("SponsorshipFamilys", "GET", null);
    }

    public static function Sponsorships($id){
        return static::sendRequest("SponsorshipDetails/{$id}", "GET", null);
    }

    public static function Campaigns(){
        return static::sendRequest("Campaigns", "GET", null);
    }

    public static function Donations($id, $page=1, $from='', $to=''){
        [$id, $all_users, $name] = explode("|", $id);
        $from = $from ? date('Y-m-d', strtotime($from)) : '';
        $from = $from ? $from . "%2000:00:00" : "";
        $to = $to ? date('Y-m-d', strtotime($to)) : '';
        $to = $to ? $to . "%2023:59:59" : "";
        return static::sendRequest("DonationsHistory/{$id}?alluser=" . ($all_users == "A" ?"true":"false") . ("&page=" . $page) . ("&from=" . $from) . ("&to=" . $to), "GET", null);
    }

    public static function UdhiyahStatus($id){
        return static::sendRequest("UdhiyahStatus/{$id}", "GET", null);
    }

    public static function NumberOfBeneficiaries(){
        return static::sendRequest("NumberOfBeneficiaries", "GET", null);
    }

    public static function DonorFeedback($model, $donor_id){
        return static::sendRequest("DonorFeedback", "POST", [
            "DonorID"       => $donor_id,
            "QOption_1"     => (int)$model->question_1_id,
            "QOption_2"     => (int)$model->question_2_id,
            "QOption_2_Text"=> $model->question_2_text,
            "QOption_3"     => (int)$model->question_3_id,
            "QText_4"       => $model->question_4_text,
            "QOption_5"     => (int)$model->question_5_id,
            "QOption_6"     => (int)$model->question_6_id,
            "QOption_7"     => (int)$model->question_7_id,
            "QText_8"       => $model->question_8_text
        ]);
    }

    public static function Complaint($model){
        $Payload = [
            "SurveyType" => (int) $model->survey_type,
            "Name" => $model->name,
            "PhoneNumber" => $model->mobile_number,
            "Email" => $model->email,
            "Text" => $model->message,
            "ByTelephone" =>(bool) $model->by_phone,
            "ByEmail" => (bool)$model->by_email,
            "PreferNotToCommunicate" => (bool)$model->prefer_not_to_communicate,
            "OtherContactMethod" => $model->another_way
        ];
        return static::sendRequest("ComplimentSurvey", "POST", $Payload);
    }

    public static function CreateCampaign($model){
        $donor_id = static::GUEST_DONOR_ID;
        if (!\Yii::$app->user->isGuest) {
            $donor_id = \Yii::$app->user->identity->guid;
        }
        return static::sendRequest("CreateCampaign", "POST", [
            "DonorID" => $donor_id,
            "Name" => $model->name,
            "EstimatedRevenue" => $model->donation_goal,
            "ProposedStart" => $model->start_date,
            "ProposedEnd" => $model->end_date,
            "DonationType" => $model->donationType->guid,
            "Reason" => ""
        ]);
    }

    public static function UpdatePhoneNumber($client){
        $Payload = [
            'ContactId' => $client->guid,
            'Phonenumber' => '',
            'Internationalphone' => ''
        ];

        if ($client->country_code == "962")
            $Payload['Phonenumber'] = $client->phone;
        else
            $Payload['Internationalphone'] = $client->country_code . $client->phone;


        return static::sendRequest("UpdatePhoneNumber", "POST", $Payload);
    }
}