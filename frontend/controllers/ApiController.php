<?php

namespace frontend\controllers;

use backend\modules\countries\models\Country;
use backend\modules\dropdown_list\models\DropdownList;
use Yii;
use backend\modules\annual_report\models\AnnualReport;

use backend\modules\annual_report\models\search\AnnualReportSearch;
use common\helpers\Utility;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;

class ApiController extends \yeesoft\controllers\BaseController
{
    public $freeAccess = true; 

    public function actionCountry($id){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $country = Country::find()->where(['id' => $id])->one();
        if (!$country)
            return [
                'success' => false,
                'response' => 'Country not found',
            ];
        return [
            'success' => true,
            'response' => ArrayHelper::map($country->cities, 'id', 'title'),
        ];
    }
}