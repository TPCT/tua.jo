<?php

namespace frontend\components;


use yii\httpclient\Client;

class JOSms
{
    private const USERNAME = "tumali";
    private const PASSWORD = "fEbo!2gKuj704DWi";
    private const PROXY_HOST = "https://proxy.dev2.dot.jo";

    private static function sendRequest($url, $method = 'POST', $payload = null){
        $payload = [
            'method' => $method,
            'url' => $url,
            'json' => $payload,
            'body' => null
        ];

        $client = new \yii\httpclient\Client();
        return $client->createRequest()
            ->setMethod('POST')
            ->setUrl(self::PROXY_HOST)
            ->setFormat(\yii\httpclient\Client::FORMAT_JSON)
            ->setHeaders([
                'Content-Type' => 'application/json',
            ])
            ->setData($payload)
            ->send();
    }

    public static function send($phoneNumber, $text){
        $phone = urlencode($phoneNumber);
        $text = urlencode($text);
        $username = urlencode(self::USERNAME);
        $password = urlencode(self::PASSWORD);
        $url = "https://www.josms.net/sms/api/SendInternationalMessages.cfm?numbers={$phone}&senderid=TkiyetUmAli&AccName={$username}&AccPass={$password}&msg={$text}&requesttimeout=5000000";
        $response = self::sendRequest($url, 'GET');
        return $response->isOk;
    }
}