<?php

namespace frontend\controllers;


use Yii;
use backend\modules\faq\models\Faq;
use backend\modules\dropdown_list\models\DropdownList;
use backend\modules\faq\models\search\FaqSearch;
use common\helpers\Utility;
use yii\data\Pagination;
use common\components\traits\FaqPageTrait;


/**
 * FaqController
 */
class FaqController extends \yeesoft\controllers\BaseController
{
    use FaqPageTrait;

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
        $this->view->params['mainIdName'] = 'FAQs';

     //   Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $data['categories'] = DropdownList::find()
        ->with('faqs')
        ->where(['category' => DropdownList::FAQ_CATEGORY])
        ->active()
        ->all();

        // get all faqs 
        $faqs = Faq::find()->active()->all();
        $this->generateFaqSchema($faqs);
        
        //         return [
        //     'success' => true,
        //     'data' => $data['categories'],
        // ];


        return $this->render('index',$data);
    }



}