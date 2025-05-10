<?php

namespace frontend\controllers;

use backend\modules\dropdown_list\models\DropdownList;
use Yii;
use backend\modules\annual_report\models\AnnualReport;

use backend\modules\annual_report\models\search\AnnualReportSearch;
use common\helpers\Utility;
use yii\data\Pagination;

class AnnualReportController extends \yeesoft\controllers\BaseController
{
    public $freeAccess = true; 

    public function actionIndex(  ){
 
        $this->layout = 'main-inner';
        $this->view->params['mainIdName'] = 'AnnualReports';

      //  Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;


        $query = AnnualReport::find()->active();

   
        $data['firstThreeReports'] = $query->limit(3)->all();

        // Clone the query and reset the limit before applying the offset
        $remainingQuery = clone $query;
        $data['remainingReports'] = $remainingQuery->offset(3)->limit(null)->all();


            return $this->render('index',$data);


        throw new \yii\web\NotFoundHttpException('Page not found.');

    }

    public function actionSustainabilityReports(){

        $this->layout = 'main_inner';
        $this->view->params['mainIdName'] = 'AnnualReport';

        $annualReport = DropdownList::find()->active()->andWhere(['slug'=>'sustenability-report'])->one();

        $data['sustainabilityReports'] = AnnualReport::find()->active()->andWhere(['category_id' => $annualReport->id])->all();

        return $this->render('sustainability_report', [
            'data' => $data,
        ]);
    }

    public function actionView($slug)
    {
        $this->layout = 'main_inner';
        $this->view->params['mainIdName'] = 'AnnualReportsInner';

        //try to display static page from datebase
        $data['annual_report'] = AnnualReport::find()->active()
        ->andWhere([AnnualReport::tableName() . '.slug' => $slug])
        ->one();


        if (!$data['annual_report']) {
            throw new \yii\web\NotFoundHttpException('Page not found.');
        }
        return $this->render('view', $data);

    }

    public function actionNext($category = 'annual-report'){

        $this->layout = 'main_inner';
        $this->view->params['mainIdName'] = 'AnnualReport';

        $annualReport = DropdownList::find()->active()->andWhere(['slug'=>$category])->one();



        $data['firstThreeReports'] = AnnualReport::find()->active()->andWhere(['category_id' => $annualReport->id])->limit(3)->all();



        $query = AnnualReport::find()
            ->active()
            ->andWhere(['category_id' =>$annualReport->id])
         
            ->orderBy(['weight' => SORT_ASC]);

            $countQuery = clone $query;

            $totalCount = max(0, $countQuery->count() - 3);


        $pagination = new Pagination([
            'totalCount' => $totalCount,
            'defaultPageSize' => Yii::$app->settings->get('site.annualreport_page_size', Yii::$app->settings->get('site.default_page_size')),
        ]);
        $data['pagination'] = $pagination;
        

        $data['remainingReports'] = $query
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();


        // $data['remainingReports'] = AnnualReport::find()->active()->andWhere(['sustainability_report' => 0])->orderBy(['weight' => SORT_ASC])->offset(3)->all();

        return $this->renderAjax('next', $data);


    }
}