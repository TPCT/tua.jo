<?php

namespace frontend\controllers;

use backend\modules\bms\models\Bms;
use Yii;
use backend\modules\news\models\News;
use backend\modules\news\models\NewsLang;
use backend\modules\news\models\search\NewsSearch;
use common\helpers\Utility;
use yii\data\Pagination;
use common\components\traits\ArticleSchemaTrait;

use backend\modules\webforms\models\RatingWebform;
use backend\modules\dropdown_list\models\DropdownList;

/**
 * NewsController
 */
class NewsController extends \yeesoft\controllers\BaseController
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
        $this->view->params['mainIdName'] = "LatestNews";






        
        $latestNewsQuery = News::find()
        ->active()
        ->orderBy(['published_at' => SORT_DESC])
        ->limit(4);

    
    $data['latestNews'] = $latestNewsQuery->all();
    
    // Extract IDs of the latest news items
    $latestNewsIds = array_map(function($news) {
        return $news->id;
    }, $data['latestNews']);



    $searchModel = new NewsSearch();

    $availableAttributeNamesAtFront = [
        "year" => "year",
    ];
    $params = Utility::newSearchIncludingFilters($availableAttributeNamesAtFront);

    // Clean User Input
    $params['status'] = Utility::STATUS_PUBLISHED;
    $dataProvider = $searchModel->search(['NewsSearch' => $params]);
    $data['searchModel'] = $searchModel;

    $query = $dataProvider->query;
    $query->orderBy(['published_at' => SORT_DESC, "weight_order" => SORT_ASC]);

    // Exclude the latest news items
    if (!empty($latestNewsIds)) {
        $query->andWhere(['not in', 'news.id', $latestNewsIds]);
    }

    $countQuery = clone $query;

    $pagination = new Pagination([
        'totalCount' => $countQuery->count(),
        'defaultPageSize' => Yii::$app->settings->get('site.news_page_size', Yii::$app->settings->get('site.default_page_size')),
    ]);

    $data['pagination'] = $pagination;

    // Fetch the news items with caching
    $data['news'] = News::getDb()->cache(function ($db) use ($query, $pagination) {
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
        $this->view->params['mainIdName'] = "LatestNewsInner";

        //try to display static page from datebase
        $targetNew = News::find()->active()
        ->andWhere([News::tableName() . '.slug' => $slug])
        ->one();







        if (!$targetNew) {
            throw new \yii\web\NotFoundHttpException('Page not found.');
        }
        $this->generateArticleSchema($targetNew);

        $latestNews = News::getDb()->cache(function ($db) use ($targetNew) {
            return News::find()
                ->where(['status' => News::STATUS_PUBLISHED])
                ->andWhere(['!=', News::tableName() . '.id', $targetNew->id])
                ->orderBy(['published_at' => SORT_DESC]) 
                ->limit(4)
                ->all();
        }, 3600);
    
        return $this->render('view', [
            'targetNew' => $targetNew,
            'latestNews' => $latestNews, 
        ]);
      
    }
}