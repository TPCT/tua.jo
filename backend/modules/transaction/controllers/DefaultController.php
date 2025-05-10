<?php

namespace backend\modules\transaction\controllers;

use Exception;
use Yii;
use yeesoft\controllers\admin\BaseController;
use yii\helpers\ArrayHelper;

/**
 * DefaultController implements the CRUD actions for common\models\News model.
 */
class DefaultController extends BaseController 
{

    public $modelClass       = 'backend\modules\transaction\models\Transaction';
    public $modelSearchClass = 'backend\modules\transaction\models\search\TransactionSearch';

    
    
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