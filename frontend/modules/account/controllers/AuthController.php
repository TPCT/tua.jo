<?php

namespace frontend\modules\account\controllers;

use backend\modules\countries\models\Country;
use common\components\TuaClient;
use frontend\modules\account\models\client\Client;
use frontend\modules\account\models\client\forms\LoginForm;
use frontend\modules\account\models\client\forms\RegisterForm;
use frontend\modules\controllers\BaseController;
use libphonenumber\PhoneNumberUtil;
use Yii;
use backend\modules\bms\models\Bms;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

class AuthController extends BaseController
{
    public $freeAccess = true;

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'forget-password' => ['POST', 'GET'],
                    'logout' => ['post'],
                ],
            ],
        ]);
    }

    public function actionIndex(){
        if (!Yii::$app->user->isGuest)
            $this->response->redirect(['/account/profile'])->send();
        $this->response->redirect(['/account/login'])->send();
    }
    public function __construct($id, $module, $config = []){
        parent::__construct($id, $module, $config);
        $this->layout = 'auth';
    }

    public function actionLogin(){

        if (!Yii::$app->user->isGuest)
            $this->response->redirect(['/account/profile'])->send();

        $loginPageImage= Bms::find()
        ->activeWithCategory("login-page-image")
        ->one();


        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            switch (Yii::$app->request->get('redirect')){
                case '/payment/checkout':
                    $donor = Yii::$app->user->identity;
                    $nationality = $donor->nationality;
                    $country = $donor->residency;

                    Yii::$app->session->setFlash('redirection-from-payment');
                    Yii::$app->session->set('donor', [
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

                    $this->response->redirect(['/payment/checkout'])->send();
                    break;
            }
            $this->response->redirect([Yii::$app->getHomeUrl()])->send();
            return;
        }

        return $this->render('login', [
            'model' => $model,
            'loginPageImage'=>$loginPageImage
        ]);
    }

    public function actionRegister(){
        if (!Yii::$app->user->isGuest)
            $this->response->redirect(['/account/profile'])->send();

        $registerPageImage= Bms::find()
        ->activeWithCategory("register-page-image")
        ->one();

        $model = new RegisterForm();
        $model->residency_id = Country::find()->where(['alpha_2_code' => 'JO'])->one()->id;
        $model->nationality_id = $model->residency_id;

        if (\Yii::$app->request->isPost){
            if ($model->load(Yii::$app->request->post()) && $model->register()) {
                \Yii::$app->session->addFlash('success', \Yii::t('site', 'ACCOUNT_REGISTER_SUCCESS'));
                $this->response->redirect(['/account/login'])->send();
                return;
            }
        }

        return $this->render('register', [
            'model' => $model,
            'registerPageImage'=>$registerPageImage
        ]);
    }

    private function sendNewPassword($password, $email){
        try
        {
            $message = Yii::$app->mailer->compose()
                ->setTo($email)
                ->setFrom([Yii::$app->params['fromEmail'] => Yii::$app->params['fromName']])
                ->setSubject(Yii::t('site', 'YOUR_NEW_PASSWORD'))
                ->setTextBody(Yii::t('site', 'YOUR_NEW_PASSWORD') . "\n" . $password);

            return $message->send();
        }
        catch (\Exception $e)
        {
            var_dump($e); exit;
            return false;
        }
    }

    public function actionForgetPassword(){
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Yii::$app->response::FORMAT_JSON;
            $client = Client::find()->where(['email' => Yii::$app->request->post('email')])->one();
            if ($client) {
                $password = Yii::$app->security->generateRandomString(8);
                $client->updateAttributes([
                    'password' => Yii::$app->security->generatePasswordHash($password)
                ]);
                $this->sendNewPassword($password, $client->email);
            }

            return [
                'success' => true,
                'message' => Yii::t('site', 'ACCOUNT_FORGET_PASSWORD_SUCCESS')
            ];
        }

        $this->response->redirect(['/account/login'])->send();
        return;
    }

    public function actionLogout(){
        Yii::$app->user->logout();
        $this->redirect(Yii::$app->getHomeUrl())->send();
    }
}