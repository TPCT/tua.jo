<?php

namespace frontend\components;

use yii\httpclient\Client;

class HyperPay
{
    public const PAYMENT_URL = "https://eu-prod.oppwa.com/v1/";

    public static function checkout($total, $donor, $currency="JOD"){
        if ($total == 0)
            return [
                'status' => False,
                'data' => []
            ];

        $payload = [
            "entityId" => \Yii::$app->params['HYPER_PAY_ENTITY_ID'],
            "integrity" => "true",
            "amount" => number_format((float)$total, 2, '.', ''),
            "currency" => $currency,
            "paymentType" => "DB",
            "createRegistration" => "true",
            "standingInstruction.mode" => "INITIAL",
            "standingInstruction.source" => "CIT",
            "standingInstruction.type" => "RECURRING",
            "standingInstruction.recurringType" => "SUBSCRIPTION",
            "standingInstruction.frequency" => "0030",
            "standingInstruction.expiry" => date("Y-m-d", strtotime("+10 years")),
            "customer.givenName" => $donor['first_name'] ?? null,
            "customer.surname" => $donor['last_name'] ?? null,
            "customer.email" => $donor['email'] ?? null,
            "customer.phone" => $donor['phone'] ?? null,
            "billing.country" => $donor['country'] ?? null,
            "billing.city" => $donor['city'] ?? null,
            "billing.state" => $donor['city'] ?? null,
            "billing.street1" => $donor['street'] ?? null,
            "customParameters[SHOPPER_customerId]" => str_replace('-', '.', $donor['guid']),
            "customParameters[SHOPPER_nationality]" => $donor['nationality'] ?? null,
            "merchantTransactionId" => uniqid(),
            "customParameters[recurringPaymentAgreement]" => uniqid(),
            "customParameters[paymentFrequency]" => "monthly",
            "standingInstruction.numberOfInstallments" => 999,
        ];

        $client = new Client();
        $response = $client->createRequest()
            ->setMethod("POST")
            ->setUrl(self::PAYMENT_URL . "/checkouts")
            ->addHeaders(['Authorization' => \Yii::$app->params['HYPER_PAY_AUTHORIZATION_TOKEN']])
            ->setData($payload)
            ->send();


        return [
            'status' => $response->isOk,
            'data' => $response->data,
        ];
    }

    /*
     *
     * adding refund
     *
     * */

    public static function pay($registration_id, $recurring_payment_agreement, $total, $donor, $currency="JOD", $type="RECURRING"){
        $payload = [
            "entityId" => \Yii::$app->params['HYPER_PAY_RECURRING_ENTITY_ID'],
            "amount" => number_format($total, 2, '.', ''),
            "currency" => $currency,
            "paymentType" => "DB",
            "standingInstruction.type" => $type,
            "standingInstruction.mode" => "REPEATED",
            "standingInstruction.source" => "MIT",
            "customer.givenName" => $donor['first_name'],
            "customer.surname" => $donor['last_name'],
            "customer.email" => $donor['email'],
            "customer.phone" => $donor['phone'],
            "billing.country" => $donor['country'],
            "billing.city" => $donor['city'],
            "billing.state" => $donor['city'],
            "billing.street1" => $donor['street'],
            "customParameters[SHOPPER_customerId]" => str_replace('-', '.', $donor['guid']),
            'customParameters[SHOPPER_nationality]' => $donor['nationality'] ?? null,
            "customParameters[recurringPaymentAgreement]" => $recurring_payment_agreement,
            "merchantTransactionId" => uniqid(),
        ];

        $client = new Client();
        $response = $client->createRequest()
            ->setMethod("POST")
            ->setUrl(self::PAYMENT_URL . "/registrations/" . $registration_id . "/payments")
            ->addHeaders(['Authorization' => \Yii::$app->params['HYPER_PAY_AUTHORIZATION_TOKEN']])
            ->setData($payload)
            ->send();

        return [
            'status' => $response->isOk,
            'data' => $response->data,
        ];
    }

    public static function status($payment_id){
        $payload = [
            "entityId" => \Yii::$app->params['HYPER_PAY_ENTITY_ID'],
        ];

        $client = new Client();
        $response = $client->createRequest()
            ->setMethod("GET")
            ->setUrl(self::PAYMENT_URL . "/checkouts/" . $payment_id . "/payment")
            ->addHeaders(['Authorization' => \Yii::$app->params['HYPER_PAY_AUTHORIZATION_TOKEN']])
            ->setData($payload)
            ->send();

        return [
            'status' => $response->isOk && preg_match('/^(000\.000\.|000\.100\.1|000\.[36])/', $response->data['result']['code']),
            'data' => $response->data,
        ];
    }
}