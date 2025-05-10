<?php

namespace backend\modules\newsletter\controllers;

use Yii;
use yeesoft\controllers\admin\BaseController;

/**
 * DefaultController implements the CRUD actions for backend\modules\newsletter\models\NewsletterClientList model.
 */
class DefaultController extends BaseController 
{
    public $modelClass       = 'backend\modules\newsletter\models\NewsletterClientList';
    public $modelSearchClass = 'backend\modules\newsletter\models\search\NewsletterClientListSearch';

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