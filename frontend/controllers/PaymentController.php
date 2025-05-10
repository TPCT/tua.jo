<?php

namespace frontend\controllers;

use backend\modules\bms\models\Bms;
use backend\modules\campaigns\models\Campaign;
use backend\modules\city\models\City;
use backend\modules\countries\models\Country;
use backend\modules\currency\models\Currency;
use backend\modules\donation_types\models\DonationTypes;
use backend\modules\recurring_items\models\RecurringItems;
use backend\modules\transaction\models\Transaction;
use backend\modules\webforms\models\DonationGiftWebform;
use backend\modules\webforms\models\ECardFormWebform;
use backend\modules\webforms\models\RatingWebform;
use common\components\TuaClient;
use frontend\components\HyperPay;
use frontend\modules\account\models\card\forms\CreateCardForm;
use frontend\modules\account\models\client\Client;
use frontend\modules\account\models\client\forms\LoginForm;
use frontend\modules\account\models\secondary_user\SecondaryUser;
use libphonenumber\PhoneNumberUtil;
use Mpdf\Tag\Tr;
use Mpdf\Tag\U;
use Yii;
use backend\modules\blogs\models\Blogs;
use backend\modules\blogs\models\BlogsLang;
use backend\modules\blogs\models\search\BlogsSearch;
use common\helpers\Utility;
use yii\base\DynamicModel;
use yii\data\Pagination;
use common\components\traits\ArticleSchemaTrait;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;


/**
 * BlogController
 */
class PaymentController extends \yeesoft\controllers\BaseController
{
    public $freeAccess = true;

    private function generateGuestModel(){
        $model = new DynamicModel([
            'first_name', 'last_name', 'email', 'phone', 'nationality', 'country', 'city', 'street', 'reCaptcha', 'country_code'
        ]);
        $model->addRule(['first_name', 'last_name', 'email', 'phone', 'nationality', 'country'], 'required');
        $model->addRule(['nationality', 'country'], function ($attribute, $params) use ($model){
            if (!Country::find()->where(['id' => $model->$attribute]))
                $model->addError($attribute, Yii::t('site', '{attribute} not found', [
                    '{attribute}' => $attribute
                ]));
        });
        $model->addRule(['first_name', 'last_name', 'email', 'phone'], 'string', ['max' => 255]);
        $model->addRule(
            ['first_name', 'last_name'],
            'match',
            [
                'pattern' => '/^[a-zA-Z\s\x{0600}-\x{06FF}]+$/u',
  
            ]
        );
        $model->addRule(['email'], 'email');
        $model->addRule(['phone'], 'integer');
        $model->addRule(['phone'], function($attribute, $params) use ($model) {
            $phone = PhoneNumberUtil::getInstance()->parse($this->$attribute);
            if (!PhoneNumberUtil::getInstance()->isValidNumber($phone)) {
                $model->addError($attribute, \Yii::t('site', 'Phone number is invalid'));
            }

            [$model->country_code, $model->phone] = [(String) $phone->getCountryCode(), $phone->getNationalNumber()];
            $model->country_code = str_replace('+', '', $model->country_code);
        });

        $model->country = Country::find()->where(['alpha_2_code' => 'JO'])->one()->id;
        $model->nationality = $model->country;

        return $model;
    }

    private function generateClientDonor(){
        $donor = Yii::$app->request->post('donor', "P|" . Yii::$app->user->identity->guid);
        $client = Yii::$app->user->identity;
        [$type, $guid] = explode('|', $donor);

        if ($type == "P")
            $donor = Client::find()->where(['guid' => $guid])->one();
        elseif ($type == "S")
            $donor = SecondaryUser::find()->where(['guid' => $guid])->one();

        $nationality = $client->nationality;
        $country = $client->residency;
        Yii::$app->session->set('donor', [
            'first_name' => $donor?->first_name,
            'last_name' => $donor?->last_name,
            'email' => $donor?->email,
            'phone' => $donor->country_code . " " . ($type == "S" ? $donor?->parent?->phone : $donor?->phone),
            'nationality' => $nationality->en_nationality,
            'country' => $country->alpha_2_code,
            'city' => $country->cities[0]->title,
            'street' => $country->cities[0]->title,
            'guid' => $donor?->guid,
        ]);

        Yii::$app->session->setFlash('redirection-from-payment');
        $this->response->redirect(['/payment/checkout'])->send();
    }

    private function sendOtp($otp, $email){
        try
        {
            $message = Yii::$app->mailer->compose()
                ->setTo($email)
                ->setFrom([Yii::$app->params['fromEmail'] => Yii::$app->params['fromName']])
                ->setSubject('Payment Verification Otp')
                ->setTextBody("Your Payment Verification Code: " . $otp);
            return $message->send();
        }
        catch (\Exception $e)
        {
            var_dump($e); exit;
        }
    }

    private function generateGuestDonor($model){
        $nationalities = Country::findOne($model->nationality);
        $country = Country::findOne($model->country);
        Yii::$app->session->set('donor', [
            'first_name' => $model->first_name,
            'last_name' => $model->last_name,
            'phone' => $model->country_code . " " . $model->phone,
            'email' => $model->email,
            'nationality' => $nationalities?->en_nationality,
            'country' => $country?->alpha_2_code,
            'city' => $country->cities[0]->title,
            'street' => $country->cities[0]->title,
            'guid' => TuaClient::GUEST_DONOR_ID
        ]);

        $otp = random_int(1000, 9999);
        Yii::$app->session->set('redirection-verification', [
            'hash' => $otp,
            'expires_at' => time() + 5 * 60
        ]);
        $this->sendOtp($otp, $model->email);

        $this->response->redirect(['/payment/verify'])->send();
        return;
    }

    public function actionIndex()
    {
        $cart = Yii::$app->session->get('cart', []);
        $login_form = new LoginForm();
        $hide_guest_form = false;

        foreach ($cart as $id => $item) {
            $item = Utility::adjustItem($item);
            if (!$item){
                unset ($cart[$id]);
                continue;
            }
            if ($item['recurrence'] != "once")
                $hide_guest_form = true;
        }

        Yii::$app->session->set('cart', $cart);

        if (empty($cart)) {
            $this->response->redirect(['/cart/'])->send();
            return;
        }

        if (!Yii::$app->user->isGuest) {
            $this->generateClientDonor();
            return;
        }

        $this->layout = 'main-inner';
        $this->view->params['mainIdName'] = "donation-as-guest-or-login";
        $model = $this->generateGuestModel();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $this->generateGuestDonor($model);
            return;
        }

        return $this->render('index', [
            'model' => $model,
            'login_form' => $login_form,
            'hide_guest_form' => $hide_guest_form
        ]);
    }

    public function actionVerify(){
        $this->view->params['mainIdName'] = 'otp-page';
        if (!($otp = Yii::$app->session->get('redirection-verification')) || $otp['expires_at'] < time()) {
            Yii::$app->session->set('redirection-verification', false);
            $this->response->redirect(['/payment/'])->send();
            return;
        }

        if ($data = Yii::$app->request->post('otp')){
            $data = implode("", $data);
            if ($data == $otp['hash']){
                Yii::$app->session->setFlash('redirection-from-payment');
                $this->response->redirect(['/payment/checkout'])->send();
                return;
            }

            Yii::$app->session->set('redirection-verification', false);
            $this->response->redirect(['/payment/'])->send();
            return;
        }

        Yii::$app->session->setFlash('email-verification-status', [
            'type' => 'danger',
            'message' => Yii::t('site', 'PLEASE_REFILL_THE_INPUT')
        ]);
        return $this->render('email-verification');
    }

    public function actionCheckout(){
        $this->view->params['mainIdName'] = "payment-method-options";
        $cart = Yii::$app->session->get('cart', []);

        $donor = Yii::$app->session->get('donor');
        if (!Yii::$app->session->getFlash('redirection-from-payment')) {
            $this->response->redirect(['/cart/'])->send();
            return;
        }

        [$subtotal, $total] = Utility::calculateCartTotals($cart);
        Yii::$app->session->set('cart', $cart);
        $checkout = HyperPay::checkout($total, $donor);

        if (!$checkout['status']) {
            Yii::$app->session->setFlash('payment-status', [
                'status' => false,
                'message' => Yii::t('site', 'Payment rejected')
            ]);
            $this->response->redirect(['/cart/'])->send();
            return null;
        }

        $cards = [];

        if (!Yii::$app->user->isGuest) {
            $cards = Yii::$app->user->identity->cards;
        }

        return $this->render('method', [
            'total_donation_scheme' => count($cart),
            'sub_total' => number_format($subtotal, 2) . " " . Utility::selected_currency('title', 'jod'),
            'total' => number_format($total, 2) . " " . Utility::selected_currency('title', 'jod'),
            'checkout' => $checkout,
            'cards' => $cards
        ]);
    }

    public function actionCard($card){
        if (Yii::$app->user->isGuest){
            $this->response->redirect(['/cart/'])->send();
            return;
        }

        $card = Yii::$app->user->identity->getCards()->where(['id' => $card])->one();
        $cart = Yii::$app->session->get('cart', []);
        $donor = Yii::$app->session->get('donor');

        [$subtotal, $total] = Utility::calculateCartTotals($cart);

        if (!$card || !$total) {
            $this->response->redirect(['/cart/'])->send();
            return;
        }

        $payment = HyperPay::pay($card->token, $card->recurring_payment_agreement, $total, $donor);
        $transaction = $this->generateTransaction($payment);

        if (!$payment['status']) {
            Yii::$app->session->setFlash('payment-status', [
                'status' => false,
                'message' => Yii::t('site', 'Payment rejected')
            ]);
            $this->response->redirect(['/cart/'])->send();
            return;
        }

        $this->sendCartItems($transaction, $card->token, $card->recurring_payment_agreement);

        Yii::$app->session->setFlash('redirection-from-payment');
        $this->response->redirect(['/payment/success?reference=' . $payment['data']['id']])->send();
    }

    private function generateRecurringItem($item, $registrationToken, $recurring_payment_agreement, $donor){
        $recurring_item = new RecurringItems();
        $recurring_item->client_id = Yii::$app->user?->id;
        $recurring_item->name = $donor['first_name'] . " " . $donor['last_name'];
        $recurring_item->email = $donor['email'];
        $recurring_item->phone = $donor['phone'];
        $recurring_item->nationality = $donor['nationality'];
        $recurring_item->country = $donor['country'];
        $recurring_item->city = $donor['city'];
        $recurring_item->street = $donor['street'];
        $recurring_item->donor_id = $donor['guid'];
        $recurring_item->registration_token = $registrationToken;
        $recurring_item->frequency = $item['recurrence'];
        $recurring_item->amount_jod = $item['amount_jod'];
        $recurring_item->amount_usd = $item['amount_usd'];
        $recurring_item->total_jod = $item['total_jod'];
        $recurring_item->total_usd = $item['total_usd'];
        $recurring_item->quantity = $item['quantity'];
        $recurring_item->next_due_at = $item['recurrence'] == "monthly" ? strtotime("+1 months", time()) : strtotime("+12 months");
        $recurring_item->donation_type_id = $item['donation'];
        $recurring_item->recurring_payment_agreement = $recurring_payment_agreement;
        $recurring_item->campaign_id = $item['campaign'];
        $recurring_item->type = $item['type'];
        $recurring_item->currency = TuaClient::CURRENCIES[Utility::selected_currency('slug')];
        $recurring_item->status = 1;
        $recurring_item->save(false);
        return $recurring_item;
    }

    private function sendCartItems($transaction, $registrationToken, $recurring_payment_agreement){
        $cart = Yii::$app->session->get('cart', []);
        $donor = Yii::$app->session->get('donor');
        Yii::$app->session->set('donor', null);

        $subtotal = 0;
        $total = 0;

        foreach ($cart as $id => $item) {
            $item['recipient_name'] = $donor['first_name'] . " " . $donor['last_name'];
            $item['recipient_email'] = $donor['email'];
            $item['recipient_phone'] = $donor['phone'];
            $item['donor_id'] = $donor['guid'];
            $donation = TuaClient::insertDonation($transaction, $item, $item['receipt'] ?? 0);
            $item['donation_id'] = $donation->donation_id;
            $cart[$id] = $item;
            $subtotal += $item['amount_jod'] * $item['quantity'] * ($item['type'] == 2 && $item['recurrence'] == "yearly" ? 12 : 1);
            $total += $item['total_jod'];
            if ($item['recurrence'] != "once")
                $this->generateRecurringItem($item, $registrationToken, $recurring_payment_agreement, $donor);
        }

        Yii::$app->mailer->compose([
            'html' => 'email',
        ], [
            'transaction' => $transaction,
            'sub_total' => $subtotal,
            'total' => $total,
            'cart' => $cart
        ])
            ->setTo($transaction->email)
            ->setFrom([Yii::$app->params['fromEmail']])
            ->setSubject('Payment Confirmation Order: #' . $transaction->id)
            ->send();

        Yii::$app->session->set('cart', []);

    }

    private function adjustCardAmount(&$item, $amount){
        if (Utility::selected_currency('slug') == 'jod'){
            $item['amount_jod']= $amount;
            $item['amount_usd'] = $item['amount_jod'] * 1 / (Currency::find()->where(['slug' => 'usd'])->one()->rate);
        }else{
            $item['amount_jod'] = $amount * (Currency::find()->where(['slug' => 'usd'])->one()->rate);
            $item['amount_usd'] = $amount;
        }
        $item['total_jod'] = $item['amount_jod'];
        $item['total_usd'] = $item['amount_usd'];

    }

    private function sendGiftCard($transaction, $checkoutId){
        $card = DonationGiftWebform::find()->where(['checkout_id' => $checkoutId])->one();
        $card->status = $transaction->status == "Accepted";
        $card->save();

        $item = [
            'donor_id' => $card->donor_id,
            'title' => Yii::t('site', 'Gift Card'),
            'donation' => TuaClient::PUBLIC_DONATIONS_TYPE_ID,
            'campaign' => "",
            'type' => 3,
            'quantity' => 1,
            'recurrence' => "once",
            'recipient_name' => $card->recipient_name,
            'recipient_email' => $card->recipient_email,
            'recipient_phone' => $card->recipient_mobile_number,
        ];

        $this->adjustCardAmount($item, $transaction->amount);

        $donation = TuaClient::insertDonation($transaction, $item, TuaClient::GIFTS_RECEIPT_TYPE);
        $item['donation_id'] = $donation->donation_id;
        Yii::$app->mailer->compose([
            'html' => 'email',
        ], [
            'transaction' => $transaction,
            'sub_total' => $transaction->amount,
            'total' => $transaction->amount,
            'cart' => [$item]
        ])
            ->setTo($transaction->email)
            ->setFrom([Yii::$app->params['fromEmail']])
            ->setSubject('Payment Confirmation Order: #' . $transaction->id)
            ->send();

        $emails = Yii::$app->settings->get('site.donation_gift_card_email');
        Utility::sendEmailToAdmin($card, $emails);
        $this->sendCardMail($card);

    }

    private function sendCardMail($card){
        $mailer = Yii::$app->mailer->compose();
        $imageCid = $mailer->embed(Yii::getAlias('@frontend') . '/web' . $card->eCards->image);
        $htmlBody = Yii::$app->view->render("@common/mail/gift", [
            'name' => $card->recipient_name,
            'message' => $card->message,
            'image' => $imageCid,
        ]);

        $to = [$card->recipient_email];

        if ($card->send_when_finished){
            $to[] = $card->sender_email;
        }

        $mailer->setFrom([Yii::$app->params['fromEmail']])
            ->setTo($to)
            ->setSubject('Tkiyet Um Ali Gift')
            ->setHtmlBody($htmlBody)
            ->send();
    }

    private function sendECard($transaction, $checkoutId){
       $card = ECardFormWebform::find()->where(['checkout_id' => $checkoutId])->one();
       $card->status = $transaction->status == "Accepted";
       $card->save();

       $item = [
           'donor_id' => $card->donor_id,
           'title' => Yii::t('site', 'E Card'),
           'donation' => TuaClient::PUBLIC_DONATIONS_TYPE_ID,
           'campaign' => "",
           'quantity' => 1,
           'type' => 3,
           'recurrence' => "once",
           'recipient_name' => $card->recipient_name,
           'recipient_email' => $card->recipient_email,
           'recipient_phone' => $card->recipient_mobile_number
       ];

       $this->adjustCardAmount($item, $transaction->amount);


       $donation = TuaClient::insertDonation($transaction, $item, TuaClient::E_CARD_RECEIPT_TYPE);
       $item['donation_id'] = $donation->donation_id;

       $emails = Yii::$app->settings->get('site.donation_e_card_email');
       Utility::sendEmailToAdmin($card, $emails);

        Yii::$app->mailer->compose([
            'html' => 'email',
        ], [
            'transaction' => $transaction,
            'sub_total' => $transaction->amount,
            'total' => $transaction->amount,
            'cart' => [$item]
        ])
            ->setTo($transaction->email)
            ->setFrom([Yii::$app->params['fromEmail']])
            ->setSubject('Payment Confirmation Order: #' . $transaction->id)
            ->send();

        $this->sendCardMail($card);
    }

    private function generateTransaction($payment){
        $status = $payment['status'];
        $payment = $payment['data'];
        $transaction = new Transaction();
        $transaction->client_id = Yii::$app->user?->id;
        $transaction->first_name = $payment['customer']['givenName'] ?? '';
        $transaction->last_name = $payment['customer']['surname'] ?? '';
        $transaction->email = $payment['customer']['email'];
        $transaction->phone = $payment['customer']['phone'];
        $transaction->nationality = $payment['customParameters']['SHOPPER_nationality'] ?? '';
        $transaction->country = $payment['billing']['country'] ?? null;
        $transaction->city = $payment['billing']['city'] ?? null;
        $transaction->street = $payment['billing']['street1'] ?? null;
        $transaction->donor_id = str_replace('.', '-', $payment['customParameters']['SHOPPER_customerId']);
        $transaction->payment_id = $status ? $payment['id'] : null;
        $transaction->amount = $payment['amount'] ?? 0;
        $transaction->type = "ONE TIME";
        $transaction->status = $status;
        $transaction->error_message = "Payment Response: " . json_encode($payment);
        $transaction->merchant_transaction_id = $payment['merchantTransactionId'];
        $transaction->save(false);
        return $transaction;
    }

    public function actionHyperPayHandler(){
        $checkout_id = Yii::$app->request->get('id');
        $payment = HyperPay::status($checkout_id);
        $transaction = $this->generateTransaction($payment);

        if (!$payment['status']) {
            Yii::$app->session->setFlash('payment-status', [
                'status' => false,
                'message' => Yii::t('site', 'Payment rejected')
            ]);
            $this->response->redirect(['/cart/'])->send();
            return;
        }

        switch (Yii::$app->request->get('type')){
            case 'cart':
                $this->sendCartItems($transaction, $payment['data']['registrationId'], $payment['data']['customParameters']['recurringPaymentAgreement']);
                break;
            case 'gift-card':
                $this->sendGiftCard($transaction, $checkout_id);
                break;
            case 'e-card':
                $this->sendECard($transaction, $checkout_id);
                break;
        }

        $this->response->redirect(['/payment/success?reference=' . $payment['data']['id']])->send();
    }

    public function actionSuccess(){
        $reference = Yii::$app->request->get('reference');
        $show_popup = !Yii::$app->request->get('rated');
        $transaction = Transaction::find()->where(['payment_id' => $reference])->one();
        if (!$transaction) {
            $this->response->redirect(['/cart/'])->send();
            return;
        }

        $model = new RatingWebform();
        $postData = Yii::$app->request->post('RatingWebform', []);
        $cleanPostData = Utility::sanitize($postData);

        if (Yii::$app->request->isPost && $model->load(['RatingWebform' => $cleanPostData], 'RatingWebform') && $model->save()) {
            $emails = Yii::$app->settings->get('site.RatingWebform');
            Utility::sendEmailToAdmin($model, $emails);
            TuaClient::DonorFeedback($model, $transaction->donor_id);
            $this->response->redirect(['/payment/success?reference=' . $reference.'&rated=1'])->send();
            return;
        }

        $this->view->params['mainIdName'] = 'payment-method-options';

        return $this->render('success', [
            'reference' => $reference,
            'model' => $model,
            'show_popup' => $show_popup,
        ]);
    }
}