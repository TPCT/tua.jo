<?php

namespace frontend\modules\account\controllers;

use backend\modules\donation_types\models\DonationTypes;
use common\components\TuaClient;
use frontend\modules\account\models\client\Client;
use frontend\modules\account\models\secondary_user\forms\CreateForm;
use frontend\modules\controllers\BaseController;
use GuzzleHttp\Promise\Create;
use kartik\form\ActiveForm;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class MyContributionsController extends BaseController
{
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
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
        $donation_types = DonationTypes::find()->all();
        $contributions = [];
        $donations = TuaClient::Donations($donor_id)['response'] ?? [];
        foreach ($donation_types as $donation_type){
            $contributions[$donation_type->guid] = 0;
        }
        return $this->render('index');
    }
}