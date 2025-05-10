<?php

namespace common\helpers;

use Yii;

class PushNotifications
{

    // (Android)API access key from Google API's Console.
    private static $_API_ACCESS_KEY = 'AAAAXqLc9xo:APA91bGX4NK-iQjWmt7FDGuDRoGUQeObpBnYg61afCg2InAbVcbdwXEOV9uBI0Wx8tMlCxCl8ev1mYqqmTVB-hCI3JbYmX-QFXVEIT69AeOwrf4iIEg_ufcaLm_Rh3rZUlpnd2ETHGK2';
// (iOS) Private key's passphrase.
    private static $_passphrase = '123';
    private static $_passphrase_voip = 'Kinz!@#Jo';
    // (Windows Phone 8) The name of our push channel.
    private static $_channelName = '';

    // Change the above three vriables as per your app.
    public function __construct()
    {
        exit('Init function is not allowed');
    }

    // Sends Push notification for Android users
    public static function android($data, $reg_id, $user)
    {
        Utility::ADD_API_LOG('Push Notifications  => ' . $reg_id, $data, $user);

        $url = 'https://fcm.googleapis.com/fcm/send';
        $message = $data;

//        $newNotifications = CrmNotifications::find()->where(['to_user_id' => $user->id, 'view' => 0])->count();
//        $message['newNotificationsCount'] = $newNotifications;

        $headers = array(
            'Authorization: key=' . self::$_API_ACCESS_KEY,
            'Content-Type: application/json'
        );

        $fields = array(
            'registration_ids' => array($reg_id),
            'data' => $message,
        );

        $a = self::useCurl($url, $headers, json_encode($fields));
    }

    // Sends Push's toast notification for Windows Phone 8 users
    public static function WP($data, $uri)
    {
        $delay = 2;
        $msg = "<?xml version=\"1.0\" encoding=\"utf-8\"?>" .
            "<wp:Notification xmlns:wp=\"WPNotification\">" .
            "<wp:Toast>" .
            "<wp:Text1>" . htmlspecialchars($data['mtitle']) . "</wp:Text1>" .
            "<wp:Text2>" . htmlspecialchars($data['mdesc']) . "</wp:Text2>" .
            "</wp:Toast>" .
            "</wp:Notification>";

        $sendedheaders = array(
            'Content-Type: text/xml',
            'Accept: application/*',
            'X-WindowsPhone-Target: toast',
            "X-NotificationClass: $delay"
        );

        $response = self::useCurl($uri, $sendedheaders, $msg);

        $result = array();
        foreach (explode("\n", $response) as $line) {
            $tab = explode(":", $line, 2);
            if (count($tab) == 2)
                $result[$tab[0]] = trim($tab[1]);
        }

        return $result;
    }

    // Sends Push notification for iOS users
    public static function ios($data, $devicetoken, $user)
    {

        $iosLink = self::getIosPushLink();
        $certificate = self::getIosCertificate();

        $deviceToken = $devicetoken;


//        $newNotifications = CrmNotifications::find()->where(['to_user_id' => $user->id, 'view' => 0])->count();
        //$message['newNotificationsCount'] = $newNotifications;


        $ctx = stream_context_create();
        stream_context_set_option($ctx, 'ssl', 'local_cert', $certificate);
        stream_context_set_option($ctx, 'ssl', 'passphrase', self::$_passphrase);
        // Open a connection to the APNS server
        $fp = stream_socket_client($iosLink, $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);
        if (!$fp)
            exit("Failed to connect: $err $errstr" . PHP_EOL);
        // Create the payload body
        $body['aps'] = array(
            'alert' => $data,
            'sound' => 'default'
        );

        // Encode the payload as JSON
        $payload = json_encode($body);
        // Build the binary notification


        @$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
        // Send it to the server
        @$result = fwrite($fp, $msg, strlen($msg));

        // Close the connection to the server
        @fclose($fp);
        /* if (!$result)
          return false;
          else
          return true; */
        Utility::ADD_API_LOG('IOS Silent Push Notifications Certificate', ['Certificate' => $certificate, 'iosLink' => $iosLink], $user);
        Utility::ADD_API_LOG('IOS Silent Push Notifications', ['deviceToken' => $deviceToken, 'body' => $body], $user);
    }


    // Sends Push notification for iOS users
    public static function iosSilent($data, $devicetoken, $user, $isSilent = true)
    {

        $iosLink = self::getIosPushLink();
        //$certificate = self::getIosCertificateVoip();
        $certificate = self::getIosCertificate();

        $deviceToken = $devicetoken;


//        $newNotifications = CrmNotifications::find()->where(['to_user_id' => $user->id, 'view' => 0])->count();
        //$message['newNotificationsCount'] = $newNotifications;


        $ctx = stream_context_create();
        stream_context_set_option($ctx, 'ssl', 'local_cert', $certificate);
        //stream_context_set_option($ctx, 'ssl', 'passphrase', self::$_passphrase_voip);
        stream_context_set_option($ctx, 'ssl', 'passphrase', self::$_passphrase);
        // Open a connection to the APNS server
        $fp = stream_socket_client($iosLink, $err, $errstr, 60, STREAM_CLIENT_CONNECT | STREAM_CLIENT_PERSISTENT, $ctx);
        if (!$fp)
            exit("Failed to connect: $err $errstr" . PHP_EOL);
        // Create the payload body
//        $body['aps'] = array(
//            'alert' => $data,
//            'sound' => 'default'
//        );
        $body['aps'] = array(
            'data' => $data,
            "content-available" => 1
        );

        // Encode the payload as JSON
        $payload = json_encode($body);
        // Build the binary notification


        @$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
        // Send it to the server
        @$result = fwrite($fp, $msg, strlen($msg));

        // Close the connection to the server
        @fclose($fp);
        /* if (!$result)
          return false;
          else
          return true; */
        Utility::ADD_API_LOG('IOS Silent Push Notifications Certificate', ['Certificate' => $certificate, 'iosLink' => $iosLink], $user);
        Utility::ADD_API_LOG('IOS Silent Push Notifications', ['deviceToken' => $deviceToken, 'body' => $body], $user);
    }

    // Curl
    private static function useCurl($url, $headers, $fields = null)
    {
        // Open connection
        $ch = curl_init();
        if ($url) {
            // Set the url, number of POST vars, POST data
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            // Disabling SSL Certificate support temporarly
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            if ($fields) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
            }
            // Execute post
            $result = curl_exec($ch);
            if ($result === FALSE) {
                die('Curl failed: ' . curl_error($ch));
            }
            // Close connection
            curl_close($ch);
            return $result;
        }
    }

    public static function getIosPushLink()
    {
        return ((YII_ENV == 'dev') ? 'ssl://gateway.sandbox.push.apple.com:2195' : 'ssl://gateway.push.apple.com:2195');
    }

    public static function getIosCertificateVoip()
    {
        return Yii::getAlias('@common') . '/certificate' . '/' . 'VOIP' . '.pem';
    }
    public static function getIosCertificate()
    {
        return Yii::getAlias('@common') . '/certificate' . '/' . YII_ENV . '.pem';
    }

}
