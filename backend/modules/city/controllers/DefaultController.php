<?php

namespace backend\modules\city\controllers;

use Yii;
use yeesoft\controllers\admin\BaseController;

/**
 * DefaultController implements the CRUD actions for backend\modules\city\models\City model.
 */
class DefaultController extends BaseController 
{
    public $modelClass       = 'backend\modules\city\models\City';
    public $modelSearchClass = 'backend\modules\city\models\search\CityModelSearch';

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
}