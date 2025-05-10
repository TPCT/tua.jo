<?php

namespace frontend\controllers;

use backend\modules\bms\models\Bms;
use Yii;
use backend\modules\blogs\models\Blogs;
use backend\modules\blogs\models\BlogsLang;
use backend\modules\blogs\models\search\BlogsSearch;
use common\helpers\Utility;
use yii\data\Pagination;
use common\components\traits\ArticleSchemaTrait;


/**
 * BlogController
 */
class BlogsController extends \yeesoft\controllers\BaseController
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
        $this->view->params['mainIdName'] = "Blogs";

        $latestBlogsQuery = Blogs::find()
        ->active()
        ->orderBy(['published_at' => SORT_DESC])
        ->limit(4);

        $data['latestBlogs'] =  $latestBlogsQuery->all();


// Extract IDs of the latest blogs items
    $latestBlogsIds = array_map(function($blogs) {
        return $blogs->id;
    }, $data['latestBlogs']);

    
        // get All blogs 

        $searchModel = new BlogsSearch();
        
        $availableAttributeNamesAtFront = 
        [
            "year" => "year",
        ];
        $params = Utility::newSearchIncludingFilters($availableAttributeNamesAtFront);

        //Clean User Input        
        $params['status'] = Utility::STATUS_PUBLISHED;
        $dataProvider = $searchModel->search(['BlogsSearch' => $params]);
        $data['searchModel'] = $searchModel;

        $query = $dataProvider->query;
        $query->orderBy(['published_at' => SORT_DESC, "weight"=> SORT_ASC]);
        
        // Exclude the latest blogs items
        if (!empty($latestBlogsIds)) {
            $query->andWhere(['not in', 'blogs.id', $latestBlogsIds]);
        }

        $countQuery = clone $query;

        $pagination = new Pagination([
            'totalCount' => $countQuery->count(),
            'defaultPageSize' => Yii::$app->settings->get('site.blogs_page_size', Yii::$app->settings->get('site.default_page_size')),
        ]);

        $data['pagination'] = $pagination;

        //try to display static page from datebase
        $data['blogs'] = Blogs::getDb()->cache(function ($db) use ($query, $pagination) {
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
        $this->view->params['mainIdName'] = "BlogsInner";

        //try to display static page from datebase
        $targetBlog = Blogs::find()->active()
        ->andWhere([Blogs::tableName() . '.slug' => $slug])
        ->one();
        

        if (!$targetBlog) {
            throw new \yii\web\NotFoundHttpException('Page not found.');
        }
        $this->generateArticleSchema($targetBlog);

        $latestBlogs = Blogs::getDb()->cache(function ($db) use ($targetBlog) {
            return Blogs::find()
                ->where(['status' => Blogs::STATUS_PUBLISHED])
                ->andWhere(['!=', Blogs::tableName() . '.id', $targetBlog->id])
                ->orderBy(['published_at' => SORT_DESC]) 
                ->limit(4)
                ->all();
        }, 3600);
    
        return $this->render('view', [
            'targetBlog' => $targetBlog,
            'latestBlogs' => $latestBlogs, 
        ]);
      
    }
}