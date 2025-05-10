<?php

namespace yeesoft\page\controllers;

use backend\modules\city\models\City;
use yeesoft\controllers\admin\BaseController;

/**
 * Controller implements the CRUD actions for Page model.
 */
class DefaultController extends BaseController
{
    public $modelClass = 'yeesoft\page\models\Page';
    public $modelSearchClass = 'yeesoft\page\models\search\PageSearch';
    public $seoModelClass = 'yeesoft\seo\models\Seo';
    public $frontUrl= "/";

    protected function getRedirectPage($action, $model = null)
    {
        switch ($action) {
            case 'update':
                return ['update', 'id' => $model->id];
                break;
            case 'create':
                return ['update', 'id' => $model->id];
                break;
            default:
                return parent::getRedirectPage($action, $model);
        }
    }

    public function actionList()
    {
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            if ($parents != null) {
                $country_id = $parents[0]; 
                $cities = City::find()->where(['country_id' => $country_id])->all(); 
                $out = [];
                foreach ($cities as $city) {
                    $out[] = ['id' => $city->id, 'name' => $city->title];
                }
                echo \yii\helpers\Json::encode(['output' => $out, 'selected' => '']);
                return;
            }
        }
        
        echo \yii\helpers\Json::encode(['output' => '', 'selected' => '']);
    }
}