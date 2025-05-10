<?php

namespace frontend\controllers;

use common\components\TuaClient;
use frontend\components\HyperPay;
use frontend\modules\account\models\client\Client;
use Yii;
use common\helpers\Utility;
use backend\modules\webforms\models\DonationGiftWebform;
use backend\modules\e_card\models\ECard;
use common\components\traits\ArticleSchemaTrait;
use yii\helpers\ArrayHelper;


/**
 * BlogController
 */
class DonateGiftController extends \yeesoft\controllers\BaseController
{
    use ArticleSchemaTrait;

    public $freeAccess = true;

    public function actionStepOne()
    {
    $this->layout = "main";
    $this->view->params['mainIdName'] = 'donate-gift-step-1';

      $data['e_cards'] = ECard::find()->active()->all();

      // create a session 
      Yii::$app->session->set('e_card_id', false);


      $model = new DonationGiftWebform();

      $model->scenario = 'step_one';
      $postData = Yii::$app->request->post('DonationGiftWebform', []);
      $DonationGiftWebform = Utility::sanitize($postData);

      if (Yii::$app->request->isPost && $model->load(['DonationGiftWebform' => $DonationGiftWebform], 'DonationGiftWebform')) {
        Yii::$app->session->set('e_card_id', $model->e_card_id);
        return $this->redirect(['donate-gift/step-two']);

    }
      

      return $this->render('step-1' , $data);
    }
    public function actionStepTwo(){
        $this->layout = "main";
        $this->view->params['mainIdName'] = 'donate-gift-step-1';

        if(!Yii::$app->session->get('e_card_id'))
        {
            $this->response->redirect(['/donate-gift/step-one']);
            return;
        }

        $e_card_id = Yii::$app->session->get('e_card_id');
        $data['card'] = ECard::find()->active()->where(['e_cards.id'=>$e_card_id])->one();
        $data['users'] = [];

        if (!Yii::$app->user->isGuest) {
            $data['users'][Yii::$app->user->id] = [
                'name' => Yii::$app->user->identity->name,
                'guid' => Yii::$app->user->identity->guid
            ];

            foreach (Yii::$app->user->identity->secondaryUsers as $user){
                $data['users'][$user->id] = [
                    'name' => $user->name,
                    'guid' => $user->guid,
                ];
            }
        }

        $model = new DonationGiftWebform();
        $model->scenario = 'step_two';
        $postData = Yii::$app->request->post('DonationGiftWebform', []);
        $DonationGiftWebform = Utility::sanitize($postData);
        $DonationGiftWebform['donor_id'] ??= TuaClient::GUEST_DONOR_ID;

        if (!Yii::$app->user->isGuest){
            $donor = $data['users'][$DonationGiftWebform['donor_id']] ?? null;
            $DonationGiftWebform['donor_id'] = $donor ? $donor['guid'] : null;
        }
        $model->load(['DonationGiftWebform' => $DonationGiftWebform]);


        if (Yii::$app->request->isPost) {
            Yii::$app->session->set('step_two_data', $model->attributes);
            $this->response->redirect(['/donate-gift/step-three']);
            return;
        }
        $data['model']  = $model;

        return $this->render('step-2' , $data); 
    }

    public function actionStepThree(){
        $this->layout = "main";
        $this->view->params['mainIdName'] = 'donate-gift-step-1';
        $stepTwo = Yii::$app->session->get('step_two_data', []);
        $e_card_id = Yii::$app->session->get('e_card_id', []);

        if ($e_card_id == false || empty($stepTwo)) {
            return $this->redirect(['step-two']);
        }
    

        $model = new DonationGiftWebform();

        $model->attributes = $stepTwo;
        $model->scenario = 'step_three';
        $postData = Yii::$app->request->post('DonationGiftWebform', []);
        $DonationGiftWebform = Utility::sanitize($postData);


        $checkout = HyperPay::checkout($model->amount, [
            'first_name' => $model->sender_name,
            'email' => $model->sender_email,
            'phone' => $model->sender_mobile_number,
            'guid' => $model->donor_id
        ]);
        $DonationGiftWebform['checkout_id'] = $checkout['data']['id'];
        $DonationGiftWebform['status'] = 0;

        if ($model->load(['DonationGiftWebform' => $DonationGiftWebform]) && $model->save()) {
            Yii::$app->session->remove('e_card_id');
            Yii::$app->session->remove('step_two_data');
        }

        return $this->render('step-3', [
            'checkout' => $checkout
        ]);
    }
}