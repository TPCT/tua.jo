<?php

namespace console\controllers;


use backend\modules\recurring_items\models\RecurringItems;
use backend\modules\transaction\models\Transaction;
use common\components\TuaClient;
use frontend\components\HyperPay;
use Yii;
use yii\console\Controller;
use yii\db\Exception;

class RecurringItemsController extends Controller
{
    public function actionTransaction(){
        $todayStartTS = strtotime(date('Y-m-d', time()) . ' 00:00:00');
        $items = RecurringItems::find()->where(['status' => 1])
            ->andWhere(['>=', 'next_due_at', $todayStartTS])->andWhere(['<', 'next_due_at', $todayStartTS + 24 * 3600])
            ->all();
        ini_set("date.timezone", "Asia/Amman");
        foreach ($items as $item) {
            try{
                [$first_name, $last_name] = explode(' ', $item->name);
                $donor = [
                    'first_name' => $first_name,
                    'last_name' => $last_name,
                    'email' => $item->email,
                    'phone' => $item->phone,
                    'guid' => $item->donor_id,
                    'nationality' => $item->nationality,
                    'country' => $item->country,
                    'city' => $item->city,
                    'state' => $item->city,
                    'street' => $item->street
                ];

                $response = HyperPay::pay($item->registration_token, $item->recurring_payment_agreement, $item->total_jod, $donor, "JOD", "RECURRING");
                $status = $response['status'];
                $payment = $response['data'];
                $transaction = new Transaction();
                $transaction->client_id = $item->client_id;
                $transaction->first_name = $payment['customer']['givenName'] ?? '---------';
                $transaction->last_name = $payment['customer']['surname'] ?? '---------';
                $transaction->email = $payment['customer']['email'];
                $transaction->phone = $payment['customer']['phone'];
                $transaction->nationality = $payment['customParameters']['SHOPPER_nationality'] ?? '';
                $transaction->country = $payment['billing']['country'];
                $transaction->city = $payment['billing']['city'];
                $transaction->street = $payment['billing']['street1'];
                $transaction->donor_id = str_replace('.', '-', $payment['customParameters']['SHOPPER_customerId']);
                $transaction->payment_id = $status ? $payment['id'] : null;
                $transaction->amount = $payment['amount'];
                $transaction->type = "RECURRING";
                $transaction->status = $status;
                $transaction->error_message = "Payment Response: " . json_encode($payment);
                $transaction->save(false);

                if ($transaction->status == "Accepted"){
                    $cart_item = [
                        'donor_id' => $item->donor_id,
                        'title' => $item->title,
                        'donation' => $item->donation_type_id,
                        'campaign' => $item->campaign_id,
                        'amount_jod' => $item->amount_jod,
                        'amount_usd' => $item->amount_usd,
                        'quantity' => $item->quantity,
                        'recurrence' => $item->frequency,
                        'recipient_name' => $item->name,
                        'recipient_email' => $item->email,
                        'recipient_phone' => $item->phone,
                        'total_jod' => $item->total_jod,
                        'total_usd' => $item->total_usd,
                        'type' => $item->type,
                        'currency' => $item->currency,
                    ];

                    $donation = TuaClient::insertDonation($transaction, $cart_item, $cart_item['receipt'] ?? 0);
                    $cart_item['donation_id'] = $donation->donation_id;
                    Yii::$app->mailer->compose([
                        'html' => 'email',
                    ], [
                        'transaction' => $transaction,
                        'sub_total' => $transaction->amount,
                        'total' => $transaction->amount,
                        'cart' => [$cart_item]
                    ])
                        ->setTo($transaction->email)
                        ->setFrom([Yii::$app->params['fromEmail']])
                        ->setSubject('Payment Confirmation Order: #' . $transaction->id)
                        ->send();

                    $next_due_at = match ($item->frequency) {
                        "daily" => strtotime("+1 day", time()),
                        "weekly" => strtotime("+1 week", time()),
                        "monthly" => strtotime("+1 month", time()),
                        default => strtotime("+1 year", time()),
                    };

                    $item->updateAttributes([
                        'next_due_at' => $next_due_at
                    ]);

                    echo $item->title . " Transacted Successfully\n";
                }
            }catch(Exception $e){
                echo "Failed to Transact " . $item->title . ": " . $e->getMessage() . "\n";
            }
        }
    }
}
