<?php

namespace frontend\controllers;

use backend\modules\bms\models\Bms;
use Yii;
use common\components\TuaClient;
use backend\modules\beneficiaries_countries\models\BeneficiariesCountries;
use common\helpers\Utility;
use yii\data\Pagination;
use common\components\traits\ArticleSchemaTrait;


/**
 * BlogController
 */
class NumberOfBenefitController extends \yeesoft\controllers\BaseController
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
        $this->view->params['mainIdName'] = "NumberOfBeneficiariesOptionOne";

        $beneficiaries  = BeneficiariesCountries::find()->active()->all();

        // Governorate
        $apiResponse  = TuaClient::NumberOfBeneficiaries()['response'];

        $mergedData = [];

        foreach ($beneficiaries as $item) {
            $name = $item->name;
            $brief = $item->brief;
            $title = $item->title;
            $img = $item->img;
            $quantity = 0;
            foreach ($apiResponse as $apiItem) {
                if (trim($apiItem['Governorate']) === trim($name)) {
                    $quantity = $apiItem['Quantity'] ?? 0;
                    break;
                }
            }

            $mergedData[] = [
                'name' => $name,
                'title'=>$title,
                'brief' => $brief, 
                'img'=> $img,
                'number_of_quantity' => number_format($quantity, 0)
            ];

        }
        $data['BeneficiariesWithQuantity'] = $mergedData;

  
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

        // Define Main Tag ID To Layout 
        $this->view->params['mainIdName'] = "NumberOfBeneficiariesOptionOne";

        // //try to display static page from datebase
        $target = BeneficiariesCountries::find()->active()
        ->andWhere([BeneficiariesCountries::tableName() . '.slug' => $slug])
        ->one();

        $apiResponse  = TuaClient::NumberOfBeneficiaries()['response'];


            $name = $target->name;
            $brief = $target->brief;
            $title = $target->title;
            $img = $target->img;

            $quantity = 0;
            foreach ($apiResponse as $apiItem) {
                if (trim($apiItem['Governorate']) === trim($name)) {
                    $quantity = $apiItem['Quantity'] ?? 0;
                    break;
                }
            }

            $mergedData[] = [
                'name' => $name,
                'title'=>$title,
                'brief' => $brief, 
                'img'=> $img,
                'number_of_quantity' => $quantity
            ];        



        // if (!$targetBlog) {
        //     throw new \yii\web\NotFoundHttpException('Page not found.');
        // }
        // $this->generateArticleSchema($targetBlog);


        return $this->render('view',[
            'target'=>$target,
            'mergedData'=>$mergedData
        ]);
      
    }
}