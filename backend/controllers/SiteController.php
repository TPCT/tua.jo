<?php

namespace backend\controllers;


use backend\modules\beneficiaries_countries\models\BeneficiariesCountries;
use backend\modules\campaigns\models\Campaign;
use backend\modules\city\models\City;
use backend\modules\countries\models\Country;
use backend\modules\donation_types\models\DonationTypes;
use backend\modules\sponsorship_families\models\SponsorshipFamilies;
use common\components\TuaClient;
use common\helpers\Utility;
use yeesoft\controllers\admin\DashboardController;
use Yii;
use yii\helpers\ArrayHelper;

class SiteController extends DashboardController
{

    public $layout = '@backend/views/layouts/admin/main.php';

    public function init()
    {
        parent::init();
        \Yii::$app->language = 'en';
    }

    public function actions()
    {

        if ($this->widgets === NULL) {
            $this->widgets = [
            ];
        }

        return parent::actions();
    }

    public function actionImportDonationTypes(){
        foreach (TuaClient::DonationTypes()['response'] as $type){
            $model = DonationTypes::find()->where(['guid' => $type['ID']]);
            $model = $model->exists() ? $model->one() : new DonationTypes();
            $model->guid = $type['ID'];
            $model->amount_jod = $type['Amount'];
            $model->title = $type['Name'];
            $model->title_ar = $type['Name'];
            $model->amount_usd = 0;
            $model->status = $type['IsActive'];
            $model->save(false);
        }
        Yii::$app->session->setFlash('crudMessage', Yii::t('site', 'Donation Types imported successfully'));
        return $this->redirect("/site-settings");
    }

    public function actionImportSponsorshipFamilies(){
        foreach (TuaClient::SponsorshipFamilies()['response'] as $family){
            $donation_type = DonationTypes::find()->where(['guid' => $family['Type']])->one();
            if (!$donation_type)
                continue;

            $model = SponsorshipFamilies::find()->where(['guid' => $family['FamilyID']]);
            $model = $model->exists() ? $model->one() : new SponsorshipFamilies();
            $model->title = $family['Family_Name'];
            $model->title_ar = $family['Family_Name'];
            $model->guid = $family['FamilyID'];
            $model->sponsored = $family['Sponsored'];
            $model->donation_type_id = $donation_type->id;
            $model->status = Utility::STATUS_PUBLISHED;
            $model->save(false);
        }
        Yii::$app->session->setFlash('crudMessage', 'Sponsorship families imported successfully');
        return $this->redirect("/site-settings");
    }

    public function actionImportCampaigns(){
        foreach (TuaClient::Campaigns()['response'] ?? []as $campaign){
            $donation_type = DonationTypes::find()->where(['guid' => $campaign['DonationType']])->one();
            if (!$donation_type)
                continue;

            $model = Campaign::find()->where(['guid' => $campaign['ID']]);
            $model = $model->exists() ? $model->one() : new Campaign();
            $model->title = $campaign['Name'];
            $model->title_ar = $campaign['Name'];
            $model->guid = $campaign['ID'];
            $model->start_date = $campaign['ProposedStart'] ? (new \DateTime($campaign['ProposedStart']))->getTimestamp() : null;
            $model->end_date = $campaign['ProposedEnd'] ? (new \DateTime($campaign['ProposedEnd']))->getTimestamp() : null;
            $model->estimated_amount = $campaign['EstimatedRevenue'];
            $model->reason = $campaign['Reason'];
            $model->reason_ar = $campaign['Reason'];
            $model->donation_type_id = $donation_type->id;
            $model->status = Utility::STATUS_PUBLISHED;
            $model->save(false);
        }
        Yii::$app->session->setFlash('crudMessage', 'Sponsorship families imported successfully');
        return $this->redirect("/site-settings");
    }

    public function actionImportBeneficiariesCountries(){
        foreach (TuaClient::NumberOfBeneficiaries()['response'] as $country){
            $model = BeneficiariesCountries::find()->where(['name' => $country['Governorate']]);
            $model = $model->exists() ? $model->one() : new BeneficiariesCountries();
            $model->name = $country['Governorate'];
            /*
             * model must have cms_title [localized], brief [localized]
             */
            $model->status = Utility::STATUS_PUBLISHED;
            $model->save(false);
        }
        Yii::$app->session->setFlash('crudMessage', 'Beneficiaries Countries imported successfully');
        return $this->redirect("/site-settings");
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->redirect(Yii::$app->homeUrl);
    }



}