<?php

namespace frontend\controllers;

use backend\modules\zakat_stories\models\ZakatStories;
use backend\modules\zakat_stories\models\search\ZakatStoriesSearch;
use Yii;

use common\helpers\Utility;
use yii\data\Pagination;
use common\components\traits\ArticleSchemaTrait;


/**
 * ZakatStoriesController
 */
class ZakatStoriesController extends \yeesoft\controllers\BaseController
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
        $this->view->params['mainIdName'] = "ZakatStories";
        $searchModel = new ZakatStoriesSearch();
        
        $availableAttributeNamesAtFront = 
        [
            "year" => "year",
        ];
        $params = Utility::newSearchIncludingFilters($availableAttributeNamesAtFront);

        //Clean User Input        
        $params['status'] = Utility::STATUS_PUBLISHED;
        $dataProvider = $searchModel->search(['ZakatStoriesSearch' => $params]);
        $data['searchModel'] = $searchModel;

        $query = $dataProvider->query;
        $query->orderBy(['published_at' => SORT_DESC, "weight"=> SORT_ASC]);

        $countQuery = clone $query;

        $pagination = new Pagination([
            'totalCount' => $countQuery->count(),
            'defaultPageSize' => Yii::$app->settings->get('site.zakat_page_size', Yii::$app->settings->get('site.default_page_size')),
        ]);

        $data['pagination'] = $pagination;

        //try to display static page from datebase
        $data['zakat_stories'] = ZakatStories::getDb()->cache(function ($db) use ($query, $pagination) {
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

        // Define Main Tag ID To Layout 
        $this->view->params['mainIdName'] = "ZakatStoriesInner";

        //try to display static page from datebase
        $targetZakatStory = ZakatStories::find()->active()
        ->andWhere([ZakatStories::tableName() . '.slug' => $slug])
        ->one();

        if (!$targetZakatStory) {
            throw new \yii\web\NotFoundHttpException('Page not found.');
        }
        $this->generateArticleSchema($targetZakatStory);



        $latestZakatStories = ZakatStories::getDb()->cache(function ($db) use ($targetZakatStory) {
            return ZakatStories::find()
                ->where(['status' => ZakatStories::STATUS_PUBLISHED])
                ->andWhere(['!=', ZakatStories::tableName() . '.id', $targetZakatStory->id])
                ->orderBy(['published_at' => SORT_DESC]) 
                ->limit(4)
                ->all();
        }, 3600);
    
        return $this->render('view', [
            'targetZakatStory' => $targetZakatStory,
            'latestZakatStories' => $latestZakatStories, 
        ]);
      
    }
}