<?php

namespace frontend\modules\account\controllers;

use common\components\TuaClient;
use frontend\components\JOSms;
use frontend\modules\account\models\client\Client;
use frontend\modules\account\models\client\forms\UpdatePasswordForm;
use frontend\modules\account\models\client\forms\UpdatePhoneForm;
use frontend\modules\account\models\secondary_user\forms\CreateForm;
use frontend\modules\controllers\BaseController;
use libphonenumber\PhoneNumberUtil;
use Yii;
use backend\modules\bms\models\Bms;

use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class ProfileController extends BaseController
{
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ]);
    }

    public function __construct($id, $module, $config = []){
        parent::__construct($id, $module, $config);
        $this->layout = 'dashboard';
    }

    public function actionIndex(){
        $data['client'] = Client::find()->where([
            'id' => Yii::$app->user->id
        ])->one();

        $data['profilePageBlocks'] =  Bms::find()
        ->activeWithCategory("profile-page-blocks")
        ->all();

        $data['update_password_form'] = new UpdatePasswordForm();
        $data['update_phone_form'] = new UpdatePhoneForm();
        return $this->render('index', $data);
    }

    public function actionUpdatePhone(){
        $client = Yii::$app->user->identity;
        $step = Yii::$app->request->post('step');
        if ($step == 'phone' && time() - $client->otp_send_at > 3600) {
            $client->updateAttributes(['otp_counts' => 0]);
            $client->refresh();
        }

        $form = Yii::$app->request->post('UpdatePhoneForm');
        $model = new UpdatePhoneForm();

        $otp = implode('', Yii::$app->request->post('otp', []));

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = 'json';
            $model->scenario = "updatePhone";
            $model->otp = null;
            $model->phone = $form['phone'] ?? null;

            if ($step == 'otp'){
                $model->scenario = "updateOtp";
                $model->otp = $otp;
            }

            if (!$model->validate()){
                return [
                    'success' => false,
                    'errors' => $model->errors,
                    'response' => null
                ];
            }

           if ($step == 'phone'){
               $client->updateAttributes([
                   'otp' => random_int(1000, 9999),
                   'otp_counts' => $client->otp_counts + 1,
                   'otp_send_at' => time()
               ]);

               $client->refresh();

               JOSms::send($model->country_code . $model->phone, Yii::t('site', "Your OTP Code: {$client->otp}"));
           }else{
               $phone = PhoneNumberUtil::getInstance()->parse($model->phone);
               [$country_code, $phone] = [$phone->getCountryCode(), $phone->getNationalNumber()];
               $client->updateAttributes([
                   'country_code' => $country_code,
                   'phone' => $phone,
                   'otp' => null,
                   'phone_changed_at' => time()
               ]);

               TuaClient::UpdatePhoneNumber($client);
           }

            return [
                'success' => true,
                'errors' => null,
                'response' => Url::to(['/account/profile'], true),
                'step' => $step == 'otp' ? 'final' : 'starter'
            ];
        }

        $this->response->redirect(['/account/profile'])->send();
    }

    public function actionUpdatePassword(){
        $model = new UpdatePasswordForm();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = 'json';
            if (!$model->validate()){
                return [
                    'success' => false,
                    'errors' => $model->errors,
                    'response' => null
                ];
            }

            return [
                'success' => $model->update(),
                'errors' => null,
                'response' => Url::to(['/account/profile'], true),
            ];
        }

        $this->response->redirect(['/account/profile'])->send();
    }
    public function actionDelete(){
        Client::deleteAll([
            'id' => Yii::$app->user->id
        ]);

        Yii::$app->session->destroy();
        return $this->goHome();
    }
}