<?php

namespace frontend\modules\account\controllers;

use backend\modules\donation_types\models\DonationTypes;
use common\components\TuaClient;
use frontend\components\HistoryPdf;
use frontend\modules\account\models\donations\forms\DonationHistoryFilterForm;
use frontend\modules\controllers\BaseController;
use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

class DonationsHistoryController extends BaseController
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

    private function generatePdf($data, $donor, $start, $end){
        ob_get_clean();
        $pdf = new HistoryPdf();
        $pdf->setFont('dejavusans', '', 12);
        $pdf->generate($data, $donor, $start, $end);
        $pdf->Output('donations [' . date('Y-m-d') . "].pdf", 'D');
        Yii::$app->end();
    }

    public function actionIndex(){
        $filter_form = new DonationHistoryFilterForm();
        $filter_form->load(Yii::$app->request->get());

        $user = Yii::$app->user->identity;
        $donor = $filter_form->name ?: $user->guid."|A|" . $user->first_name . " " . $user->last_name;

        $page = Yii::$app->request->get('page', 1);
        $donations = TuaClient::Donations($donor, $page, $filter_form->start_date, $filter_form->end_date)['response'] ?? [];
        $pages = $donations['pages'] ?? 1;

        if (Yii::$app->request->get('type') == 'pdf'){
            $data = [];
            for ($i = 1; $i <= $pages; $i++){
                $data[] = TuaClient::Donations($donor, $i, $filter_form->start_date, $filter_form->end_date)['response']['items'] ?? [];
            }
            $this->generatePdf($data, $donor, $filter_form->start_date, $filter_form->end_date);
        }

        $donations = $donations['items'] ?? [];

        $users = [
            $user->guid."|A|" . Yii::t('site', 'All Donors') => Yii::t('site', 'All Donors'),
            $user->guid."|S|" . $user->name => $user->name
        ];

        foreach ($user->secondaryUsers as $user){
            $users[$user->guid."|s|" > $user->name] = $user->name;
        }

        foreach ($donations as &$donation){
            $donation_type = DonationTypes::find()->where(['guid' => $donation['DonationType']])->one();
            $donation['Amount'] = $donation['Amount'] * $donation['Quantity'];
            if (!$donation_type) {
                $donation['image'] = null;
                $donation['title'] = $donation['DonationType'];
                continue;
            }
            $donation['image'] = $donation_type->image;
            $donation['title'] = $donation_type->cms_title ?: $donation_type->title;
        }

        return $this->render('index', [
            'donations' => $donations,
            'filter_form' => $filter_form,
            'users' => $users,
            'pages' => $pages,
            'page' => $page,
        ]);
    }
}