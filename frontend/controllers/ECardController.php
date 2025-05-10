<?php

namespace frontend\controllers;

use common\components\TuaClient;
use frontend\components\HyperPay;
use frontend\modules\account\models\client\Client;
use Yii;
use common\helpers\Utility;
use backend\modules\webforms\models\ECardFormWebform;
use backend\modules\e_card\models\ECard;
use common\components\traits\ArticleSchemaTrait;
use yii\helpers\ArrayHelper;


/**
 * BlogController
 */
class ECardController extends \yeesoft\controllers\BaseController
{
    use ArticleSchemaTrait;

    public $freeAccess = true;

    public function actionStepOne(){
        $items = Yii::$app->request->post('items', []);
        if (!$items || !$items[0]['amount']){
            $this->response->redirect(['/cart/'])->send();
            return;
        }
        Yii::$app->session->set('e_card_step_one_data', $items[0]['amount']);
        return $this->redirect(['step-two']);

    }
    public function actionStepTwo(){
 
        $this->layout = "main";
        $this->view->params['mainIdName'] = 'ecard-step-1';
    
        $stepOne= Yii::$app->session->get('e_card_step_one_data', []);

        if ( empty($stepOne)) {
            return $this->redirect(['/']);
        }

        $data['amount'] = $stepOne;
        $data['cards'] = ECard::find()->active()->where(['promote_to_form'=>ECard::STATUS_PUBLISHED])->all();
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

        $model = new ECardFormWebform();
        $model->amount = $stepOne;
        $model->scenario = 'step_two';
        $postData = Yii::$app->request->post('ECardFormWebform', []);
        $ECardFormWebform = Utility::sanitize($postData);
        $ECardFormWebform['donor_id'] ??= TuaClient::GUEST_DONOR_ID;

        if (!Yii::$app->user->isGuest){
            $donor = $data['users'][$ECardFormWebform['donor_id']] ?? null;
            $ECardFormWebform['donor_id'] = $donor ? $donor['guid'] : null;
        }
        $model->load(['ECardFormWebform' => $ECardFormWebform]);


        if (Yii::$app->request->isPost) {
            Yii::$app->session->set('e_card_step_two_data', $model->attributes);
            $this->response->redirect(['/e-card/step-three'])->send();
            return;
        }
        $data['model']  = $model;

        return $this->render('step-2' , $data); 
    }




    public function actionStepThree(){
        $this->layout = "main";
        $this->view->params['mainIdName'] = 'donate-gift-step-1';
        $stepTwo = Yii::$app->session->get('e_card_step_two_data', []);
        $stepOne= Yii::$app->session->get('e_card_step_one_data', []);


        if (  empty($stepOne) || empty($stepTwo)) {
            return $this->redirect(['step-two']);
        }
    

        $model = new ECardFormWebform();

        $model->attributes = $stepTwo;
        $model->scenario = 'step_three';
        $postData = Yii::$app->request->post('ECardFormWebform', []);
        $ECardFormWebform = Utility::sanitize($postData);

        $checkout = HyperPay::checkout($model->amount, [
            'first_name' => $model->sender_name,
            'email' => $model->sender_email,
            'phone' => $model->sender_mobile_number,
            'guid' => $model->donor_id
        ]);
        $ECardFormWebform['checkout_id'] = $checkout['data']['id'];
        $ECardFormWebform['status'] = 0;

        if ($model->load(['ECardFormWebform' => $ECardFormWebform]) && $model->save()) {
            Yii::$app->session->remove('amount_session');
            Yii::$app->session->remove('e_card_step_two_data');
        }

        return $this->render('step-3', [
            'checkout' => $checkout
        ]);
    }
}