<?php

namespace frontend\modules\account\controllers;

use frontend\components\HyperPay;
use frontend\modules\account\models\card\Card;
use frontend\modules\account\models\card\forms\CreateCardForm;
use frontend\modules\account\models\client\Client;
use frontend\modules\account\models\secondary_user\forms\CreateForm;
use frontend\modules\controllers\BaseController;
use GuzzleHttp\Promise\Create;
use kartik\form\ActiveForm;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class CardSettingsController extends BaseController
{
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ]);
    }

    public function __construct($id, $module, $config = []){
        parent::__construct($id, $module, $config);
        $this->layout = 'dashboard';
    }

    public function actionIndex(){
        $cards = Yii::$app->user->identity->cards;
        return $this->render('index', [
            'cards' => $cards,
        ]);
    }

    public function actionCreate(){
        $donor = Yii::$app->user->identity;
        $nationality = $donor->nationality;
        $country = $donor->residency;

        $checkout = HyperPay::checkout(0.1, [
            'first_name' => $donor?->first_name,
            'last_name' => $donor?->last_name,
            'email' => $donor?->email,
            'phone' => $donor->country_code . " " . $donor?->phone,
            'nationality' => $nationality->en_nationality,
            'country' => $country->alpha_2_code,
            'city' => $country->cities[0]->title,
            'street' => $country->cities[0]->title,
            'guid' => $donor?->guid,
        ]);

        return $this->render('create', [
            'checkoutId' => $checkout['data']['id'],
            'integrity' => $checkout['data']['integrity']
        ]);
    }

    public function actionDelete(){
        $card = Card::findOne(Yii::$app->request->post('id'));
        $card?->delete();
        $this->response->redirect(Url::to(['/account/card-settings']))->send();
    }

    public function actionPaymentHandler(){
        $payment = HyperPay::status(Yii::$app->request->get('id'));
        if ($payment['status']){
            $response = $payment['data'];
            $card = new Card();
            $card->parent_id = Yii::$app->user->id;
            $card->token = $response['registrationId'];
            $card->bin = $response['card']['bin'];
            $card->last_four_digits = $response['card']['last4Digits'];
            $card->holder = $response['card']['holder'];
            $card->expiry_month = $response['card']['expiryMonth'];
            $card->expiry_year = $response['card']['expiryYear'];
            $card->type = $response['paymentBrand'];
            $card->recurring_payment_agreement = $response['customParameters']['recurringPaymentAgreement'];
            $card->save();
            $this->response->redirect(['/account/card-settings']);
            return;
        }

        Yii::$app->session->setFlash('add-card-status', [
            'status' => false,
            'message' => Yii::t('site', "Card Cannot be added")
        ]);
        $this->response->redirect(['/account/card-settings/create']);
    }
}