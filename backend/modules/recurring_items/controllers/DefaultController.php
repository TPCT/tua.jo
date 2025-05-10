<?php

namespace backend\modules\recurring_items\controllers;

use Exception;
use Yii;
use yeesoft\controllers\admin\BaseController;
use yii\helpers\ArrayHelper;

/**
 * DefaultController implements the CRUD actions for common\models\News model.
 */
class DefaultController extends BaseController 
{

    public $modelClass       = 'backend\modules\recurring_items\models\RecurringItems';
    public $modelSearchClass = 'backend\modules\recurring_items\models\search\RecurringItemsSearch';

    
    
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