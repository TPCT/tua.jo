<?php

namespace backend\modules\subdistrict\controllers;

use Yii;
use yeesoft\controllers\admin\BaseController;

/**
 * DefaultController implements the CRUD actions for backend\modules\subdistrict\models\Subdistrict model.
 */
class DefaultController extends BaseController 
{
    public $modelClass       = 'backend\modules\subdistrict\models\Subdistrict';
    public $modelSearchClass = 'backend\modules\subdistrict\models\search\SubdistrictModelSearch';

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