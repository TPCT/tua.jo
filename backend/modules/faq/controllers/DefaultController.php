<?php

namespace backend\modules\faq\controllers;

use Exception;
use Yii;
use yeesoft\controllers\admin\BaseController;
use yii\helpers\ArrayHelper;

/**
 * DefaultController implements the CRUD actions for common\models\Faq model.
 */
class DefaultController extends BaseController 
{

    public $modelClass       = 'backend\modules\faq\models\Faq';
    public $modelSearchClass = 'backend\modules\faq\models\search\FaqSearch';

    
    
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