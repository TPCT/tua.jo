<?php

namespace frontend\controllers;

use backend\modules\bms\models\Bms;
use Yii;
use backend\modules\empowerment_products\models\EmpowermentProducts;
use backend\modules\empowerment_products\models\search\EmpowermentProductsSearch;
use backend\modules\empowerment_products\models\EmpowermentProductsLang;

use common\helpers\Utility;
use yii\data\Pagination;


/**
 * EmpowermentProductsController
 */
class EmpowermentProductsController extends \yeesoft\controllers\BaseController
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
        $this->view->params['mainIdName'] = "Empowerment-products";



        $searchModel = new EmpowermentProductsSearch();

        // $params = Yii::$app->request->get('DoctorSearch');
 
        $availableAttributeNamesAtFront = 
        [

            "category" => "category_slug",
            "sort" => "sort"
        ];
 
         $params = Utility::newSearchIncludingFilters($availableAttributeNamesAtFront);
 
          $params['status']= Utility::STATUS_PUBLISHED;
 
         $dataProvider = $searchModel->search(['EmpowermentProductsSearch' => $params]);
         $data['searchModel'] = $searchModel;
 
         $query = $dataProvider->query;
 
 
         $countQuery = clone $query;
 
         $pagination = new Pagination([
             'totalCount' => $countQuery->count(),
             'defaultPageSize' => Yii::$app->settings->get('site.empowerment_page_size', Yii::$app->settings->get('site.default_page_size')),
         ]);
         $data['pagination'] = $pagination;
 
 
         $data["count"] = $query->count();
         //try to display static page from datebase
         $data['EmpowermentProducts'] = EmpowermentProducts::getDb()->cache(function ($db) use ($query, $pagination) {
             return $query->offset($pagination->offset)
                 ->limit($pagination->limit)
                 ->all();
         }, 3600);
 
 
     

        return $this->render('index',$data);
    }

    public function actionView($slug)
    {
        // Define Layout
        $this->layout = 'main';

        // Define Main Tag ID To Layout 
        $this->view->params['mainIdName'] = "Empowerment-details-new";

          //try to display static page from datebase
          $targetEmpowermentProduct = EmpowermentProducts::find()->active()
          ->andWhere([EmpowermentProducts::tableName() . '.slug' => $slug])
          ->one();
  
          if (!$targetEmpowermentProduct) {
              throw new \yii\web\NotFoundHttpException('Page not found.');
          }
          $moreEmpowermentProducts = EmpowermentProducts::getDb()->cache(function ($db) use ($targetEmpowermentProduct) {
            return EmpowermentProducts::find()
                ->where([
                    'status' => EmpowermentProducts::STATUS_PUBLISHED,
                    'category_id' => $targetEmpowermentProduct->category_id,
                ])
                ->andWhere(['!=', 'id', $targetEmpowermentProduct->id])
                ->orderBy(['published_at' => SORT_DESC])
                ->limit(Yii::$app->settings->get('site.empowerment_product_inner_page_size', Yii::$app->settings->get('site.default_page_size')))
                ->all();
        }, 3600);
    
        return $this->render('view', [
            'targetEmpowermentProduct' => $targetEmpowermentProduct,
            'moreEmpowermentProducts' => $moreEmpowermentProducts, 
        ]);
      
    }



}