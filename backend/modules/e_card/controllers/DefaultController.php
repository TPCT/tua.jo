<?php

namespace backend\modules\e_card\controllers;

use Exception;
use Yii;
use yeesoft\controllers\admin\BaseController;
use yii\helpers\ArrayHelper;

/**
 * DefaultController implements the CRUD actions for common\models\e_card model.
 */
class DefaultController extends BaseController 
{

    public $modelClass       = 'backend\modules\e_card\models\ECard';
    public $modelSearchClass = 'backend\modules\e_card\models\search\ECardSearch';

    
    
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