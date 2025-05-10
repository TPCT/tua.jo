<?php

namespace frontend\controllers;

use backend\modules\bms\models\Bms;
use backend\modules\dropdown_list\models\DropdownList;
use Yii;
use backend\modules\letters\models\Letters;
use backend\modules\letters\models\search\LettersSearch;
use backend\modules\letters\models\LettersLang;
use backend\modules\media_gallery\models\MediaGallery;
use common\helpers\Utility;
use yii\data\Pagination;


/**
 * LettersController
 */
class PhotoGalleryController extends \yeesoft\controllers\BaseController
{
    public $freeAccess = true;


    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {

        $this->layout = 'main-inner';
        $this->view->params['mainIdName'] = "PhotoGallery";




        $query = MediaGallery::find()->active();
        $countQuery = clone $query;
        $pagination = new Pagination([
            'totalCount' => $countQuery->count(),
            'defaultPageSize' =>  Yii::$app->settings->get('site.photo_gellary_page_size', Yii::$app->settings->get('site.default_page_size')),
        ]);
        $data['pagination'] = $pagination;

        $data['photoGellaries'] = MediaGallery::getDb()->cache(function ($db) use ($query, $pagination) {

            return
                $query
                ->offset($pagination->offset)
                ->limit($pagination->limit)
                ->all();
        }, 3600);



        return $this->render('index', $data);
    }





}