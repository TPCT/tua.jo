<?php

namespace frontend\controllers;

use backend\modules\bms\models\Bms;
use Yii;
use backend\modules\city\models\City;
use backend\modules\volunteers\models\Volunteers;
use backend\modules\webforms\models\VolunteerWebform;
use common\helpers\Utility;
use yii\data\Pagination;
use common\components\traits\ArticleSchemaTrait;


/**
 * VolunteerPrograms
 */
class VolunteerProgramsController extends \yeesoft\controllers\BaseController
{
    use ArticleSchemaTrait;

    public $freeAccess = true;


//    public function behaviors()
//    {
//        return [
//            [
//                 'class' => 'yii\filters\PageCache',
////                 'only' => ['index'],
//                 'duration' => 600,
//                 'variations' => [
//                     \Yii::$app->language,
//                     Yii::$app->request->get(),
//                 ],
// //                'dependency' => [
// //                    'class' => 'yii\caching\DbDependency',
// //                    'sql' => 'SELECT COUNT(*) FROM post',
// //                ],
//            ],
//        ];
//    }


    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {

        $this->layout = 'main-inner';
        $this->view->params['mainIdName'] = "VolunteeringPrograms";

        $query = Volunteers::find()->active();
        $countQuery = clone $query;
        $pagination = new Pagination([
            'totalCount' => $countQuery->count(),
            'defaultPageSize' =>  Yii::$app->settings->get('site.volunteer_page_size', Yii::$app->settings->get('site.default_page_size')),
        ]);
        $data['pagination'] = $pagination;

        $data['volunteerPrograms'] = Volunteers::getDb()->cache(function ($db) use ($query, $pagination) {

            return
                $query
                ->offset($pagination->offset)
                ->limit($pagination->limit)
                ->all();
        }, 3600);

        return $this->render('index', $data);
    }

    public function actionNext()
    {
        $this->layout = 'main-inner';
        $this->view->params['mainIdName'] = "VolunteeringPrograms";

        $query = Volunteers::find()->active();
        $countQuery = clone $query;
        $pagination = new Pagination([
            'totalCount' => $countQuery->count(),
            'defaultPageSize' =>  Yii::$app->settings->get('site.volunteer_page_size', Yii::$app->settings->get('site.default_page_size')),
        ]);
        $data['pagination'] = $pagination;

        $data['volunteerPrograms'] = Volunteers::getDb()->cache(function ($db) use ($query, $pagination) {

            return
                $query
                ->offset($pagination->offset)
                ->limit($pagination->limit)
                ->all();
        }, 3600);

        return $this->renderAjax('next', $data);


    }

    public function actionCountryCity()
    {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    
        $out = ['results' => ['id' => '', 'name' => '']];
        
        Yii::error('depdrop_parents POST: ' . json_encode($_POST), 'debug');


        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];

  
    
            if ($parents != null && !empty($parents[0])) {
                $countryId = $parents[0];
    
                $cities = City::find()
                    ->where(['country_id' => $countryId])
                    ->all();
    
                $data = [];
                foreach ($cities as $city) {
                    $data[] = ['id' => $city->id, 'name' => $city->title];
                }
    
                return ['output' => $data, 'selected' => ''];
            }
        }

        return $out;
    }


    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionView($slug)
    {
        // Define Layout
        $this->layout = 'main-inner';

        // Define Main Tag ID To Layout 
        $this->view->params['mainIdName'] = "VolunteeringProgramsApply";


        $targetVolunteers = null;

        if($slug != "other")
        {
         //try to display static page from datebase
        $targetVolunteers = Volunteers::find()->active()
        ->andWhere([Volunteers::tableName() . '.slug' => $slug])
        ->one();

        $this->generateArticleSchema($targetVolunteers);


        }
        else{
         
            // get the id of other volunteer 
            $targetVolunteers = Volunteers::find()
            ->andWhere([Volunteers::tableName() . '.slug' => 'other'])
            ->one();
            $this->generateArticleSchema($targetVolunteers);

        }

        if (!$targetVolunteers && $slug != "other" ) {
            throw new \yii\web\NotFoundHttpException('Page not found.');
        }


        try {
            $model = new VolunteerWebform();
            $postData = Yii::$app->request->post('VolunteerWebform', []);
            $cleanPostData = Utility::sanitize($postData);

   
    
            if (Yii::$app->request->isPost && $model->load(['VolunteerWebform' => $cleanPostData], 'VolunteerWebform') && $model->save()) {
    
                $emails = Yii::$app->settings->get('site.volunteer_email');
                Utility::sendEmailToAdmin($model, $emails);
                Yii::$app->session->addFlash('success', Yii::t('site', 'TNKX_FOR_SUBMITION'));
                return $this->redirect(Yii::$app->request->referrer);
    
            }
            $model->volunteer_id = $targetVolunteers->id;
            $data['model'] = $model;
        } catch (\Exception $th) {
            return $th->getMessage();
        }


        $data['targetVolunteers'] = $targetVolunteers;



        if (!$targetVolunteers) {
            throw new \yii\web\NotFoundHttpException('Page not found.');
        }


    
        return $this->render('view', $data);
      
    }

    


}