<?php

namespace backend\modules\district\controllers;

use Yii;
use yeesoft\controllers\admin\BaseController;

/**
 * DefaultController implements the CRUD actions for backend\modules\district\models\District model.
 */
class DefaultController extends BaseController 
{
    public $modelClass       = 'backend\modules\district\models\District';
    public $modelSearchClass = 'backend\modules\district\models\search\DistrictModelSearch';

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