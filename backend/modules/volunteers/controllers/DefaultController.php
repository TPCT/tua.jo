<?php

namespace backend\modules\volunteers\controllers;

use Exception;
use Yii;
use yeesoft\controllers\admin\BaseController;
use yii\helpers\ArrayHelper;

/**
 * DefaultController implements the CRUD actions for common\models\volunteers model.
 */
class DefaultController extends BaseController 
{

    public $modelClass       = 'backend\modules\volunteers\models\Volunteers';
    public $modelSearchClass = 'backend\modules\volunteers\models\search\VolunteersSearch';
    public $seoModelClass = 'yeesoft\seo\models\Seo';
    public $frontUrl= "/volunteers/";
    
    
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