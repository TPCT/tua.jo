<?php

namespace frontend\controllers;

use backend\modules\bms\models\Bms;
use backend\modules\dropdown_list\models\DropdownList;
use backend\modules\youtube\models\YoutubeLinks;
use common\helpers\Utility;
use Yii;
use yii\data\Pagination;

/**
 * LettersController
 */
class VideoGalleryController extends \yeesoft\controllers\BaseController
{
    public $freeAccess = true;


    /**
     * Displays homepage.
     *
     * @return mixed
     */




    /**
     * Displays homepage.
     *
     * @return mixed
     */


     public function actionView($slug)
     {
        $this->layout = 'main-inner';
        $this->view->params['mainIdName'] = "VideoGallery";

        $data['categories'] = DropdownList::find()
            ->activeWithCategory(DropdownList::VIDEO_ALBUM)
            ->all();

            $data['targetCategory'] = DropdownList::find()->active()
            ->andWhere([DropdownList::tableName() . '.slug' => $slug])
            ->one();



            if (!$data['targetCategory']) {
                throw new \yii\web\NotFoundHttpException('Page not found.');
            }



            $query = YoutubeLinks::find()->active()->andWhere([YoutubeLinks::tableName() . '.album_id' => $data['targetCategory']->id]);
            $countQuery = clone $query;
            $pagination = new Pagination([
                'totalCount' => $countQuery->count(),
                'defaultPageSize' =>  Yii::$app->settings->get('site.media_post_page_size', Yii::$app->settings->get('site.default_page_size')),
            ]);
            $data['pagination'] = $pagination;
    
            $data['videos'] = YoutubeLinks::getDb()->cache(function ($db) use ($query, $pagination) {
    
                return
                    $query
                   
                    ->offset($pagination->offset)
                    ->limit($pagination->limit)
                    ->all();
            }, 3600);
    







            return $this->render('view', $data);
     }
}