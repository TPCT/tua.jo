<?php

namespace frontend\modules\account\controllers;

use frontend\modules\account\models\client\Client;
use frontend\modules\account\models\secondary_user\forms\CreateForm;
use frontend\modules\controllers\BaseController;
use GuzzleHttp\Promise\Create;
use kartik\form\ActiveForm;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class PaymentScheduleController extends BaseController
{
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post']
                ],
            ],
        ]);
    }

    public function __construct($id, $module, $config = []){
        parent::__construct($id, $module, $config);
        $this->layout = 'dashboard';
    }

    public function actionIndex(){
        return $this->render('index', [
            'items' => Yii::$app->user->identity->recurringItems,
        ]);
    }

    public function actionDelete(){
        $item = Yii::$app->user->identity->getRecurringItems()->where(['id' => Yii::$app->request->post('id')])->one();
        $item?->delete();
        $this->response->redirect(['/account/payment-schedule']);
    }
}