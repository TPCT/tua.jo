<?php

namespace frontend\controllers;


use Yii;
use backend\modules\testimonials\models\Testimonials;
use backend\modules\testimonials\models\TestimonialsLang;
use backend\modules\testimonials\models\search\TestimonialsSearch;
use common\helpers\Utility;
use yii\data\Pagination;


/**
 * TestimonialController
 */
class TestimonialsController extends \yeesoft\controllers\BaseController
{
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
        $this->view->params['mainIdName'] = 'Testimonials';


        $searchModel = new TestimonialsSearch();

        //Clean User Input        
        $params['status'] = Utility::STATUS_PUBLISHED;
        $dataProvider = $searchModel->search(['TestimonialsSearch' => $params]);
        $data['searchModel'] = $searchModel;

        $query = $dataProvider->query;
        $countQuery = clone $query;

        $pagination = new Pagination([
            'totalCount' => $countQuery->count(),
            'defaultPageSize' => Yii::$app->settings->get('site.testimonisl_page_size',  Yii::$app->settings->get('site.default_page_size')),
        ]);
        $data['pagination'] = $pagination;

        //try to display static page from datebase
        $data['Testimonials'] = Testimonials::getDb()->cache(function ($db) use ($query, $pagination) {
            return $query->offset($pagination->offset)
                ->limit($pagination->limit)
                ->all();
        }, 3600);



        return $this->render('index',$data);
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



     
            return $this->render('view');
       

        return $this->goHome();

        //if nothing suitable was found then throw 404 error
        throw new \yii\web\NotFoundHttpException('Page not found.');
    }
}