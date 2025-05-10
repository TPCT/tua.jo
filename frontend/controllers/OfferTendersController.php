<?php

namespace frontend\controllers;

use backend\modules\bms\models\Bms;
use Yii;
use backend\modules\offered_tenders\models\OfferedTenders;
use backend\modules\dropdown_list\models\DropdownList;
use common\components\traits\ArticleSchemaTrait;

use common\helpers\Utility;
use yii\data\Pagination;


/**
 * OfferTendersController
 */
class OfferTendersController extends \yeesoft\controllers\BaseController
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





    public  function actionIndex()
    {
        $this->layout = 'main-inner';
        $this->view->params['mainIdName'] = "offered-tenders";


        $data['offerTendersFirstsection']= Bms::find()
        ->activeWithCategory("offer-tenders-first-section")
        ->one();

        $data['offerTendersSecondsections']= Bms::find()
        ->activeWithCategory("offer-tenders-second-sections")
        ->all();

        
        $data['categories'] = DropdownList::find()
            ->activeWithCategory(DropdownList::OFFER_TENDERS_CATEGORY)
            ->all();

            // get all active offers 
            $data['OfferedTenders'] = OfferedTenders::find()->with('category')->active()->all();

        // if (!$data['targetCategory']) {
        //     throw new \yii\web\NotFoundHttpException('Page not found.');
        // }


        return $this->render('index',$data);
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionView($slug)
    {
        $this->layout = 'main-inner';
        $this->view->params['mainIdName'] = 'offered-tenders-inner';

        $data['targetOfferedTender'] = OfferedTenders::find()->active()
        ->andWhere([OfferedTenders::tableName() . '.slug' => $slug])
        ->one();



        if (!$data['targetOfferedTender']) {
            throw new \yii\web\NotFoundHttpException('Page not found.');
        }        
        $this->generateArticleSchema($data['targetOfferedTender']);

        $data['images'] = $data['targetOfferedTender']->getAllFiles()->all();

    
        return $this->render('view',$data);
      
    }
}