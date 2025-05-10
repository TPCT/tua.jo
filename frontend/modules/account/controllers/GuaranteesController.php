<?php

namespace frontend\modules\account\controllers;

use backend\modules\donation_types\models\DonationTypes;
use backend\modules\sponsorship_families\models\SponsorshipFamilies;
use common\components\TuaClient;
use frontend\modules\account\models\guarantees\forms\RequestCallForm;
use frontend\modules\account\models\guarantees\forms\RequestVisitForm;
use frontend\modules\account\models\client\Client;
use frontend\modules\account\models\secondary_user\forms\CreateForm;
use frontend\modules\account\models\secondary_user\SecondaryUser;
use frontend\modules\controllers\BaseController;
use GuzzleHttp\Promise\Create;
use kartik\form\ActiveForm;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class GuaranteesController extends BaseController
{
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'request-visit' => ['POST'],
                    'request-call' => ['POST'],
                ],
            ],
        ]);
    }

    public function __construct($id, $module, $config = []){
        parent::__construct($id, $module, $config);
        $this->layout = 'dashboard';
    }

    public function actionIndex(){
        $donor_id = Yii::$app->user->identity->guid;
        $sponsorships = TuaClient::Sponsorships($donor_id)['response'] ?? [];
        foreach ($sponsorships as &$sponsorship){
            if ($sponsorship['DonorID'] == $donor_id) {
                $sponsorship['donor'] = Yii::$app->user->identity->first_name . " " . Yii::$app->user->identity->last_name;
            }elseif ($secondary_user = SecondaryUser::find()->where(['guid' => $sponsorship['DonorID']])->one()){
                $sponsorship['donor'] = $secondary_user->name;
            }else{
                $sponsorship['donor'] = Yii::t('site', 'Unknown');
            }

            $donation = DonationTypes::find()->where(['guid' => $sponsorship['Type']])->one();
            if (!$donation){
                $sponsorship['amount'] = Yii::t('site', 'Unknown');
            }else{
                $sponsorship['amount'] = $donation->amount_jod;
            }

            $family = SponsorshipFamilies::find()->where(['guid' => $sponsorship['FamilyID']])->one();
            if (!$family) {
                $sponsorship['id'] = null;
                $sponsorship['image'] = null;
                $sponsorship['title'] = $sponsorship['Family_Name'];
                $sponsorship['age'] = Yii::t('site', 'Unknown');
                $sponsorship['gender'] = Yii::t('site', 'Unknown');
            }else{
                $sponsorship['id'] = $family->id;
                $sponsorship['image'] = $family->image;
                $sponsorship['title'] = $family->cms_title ?: $family->title;
                $sponsorship['age'] = $family->age;
                $sponsorship['gender'] = $family->gender;
            }
        }
        return $this->render('index', [
            'sponsorships' => $sponsorships,
            'request_visit_form' => new RequestVisitForm(),
            'request_call_form' => new RequestCallForm(),
        ]);
    }

    public function actionRequestVisit(){
        $model = new RequestVisitForm();

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
                'success' => $model->save(),
                'errors' => null,
                'response' => null,
            ];
        }

        $this->response->redirect(['/account/guarantees'])->send();
    }

    public function actionRequestCall(){
        $model = new RequestCallForm();

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
                'success' => $model->save(),
                'errors' => null,
                'response' => null,
            ];
        }

        $this->response->redirect(['/account/guarantees'])->send();
    }
}