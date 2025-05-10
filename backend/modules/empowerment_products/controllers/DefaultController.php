<?php

namespace backend\modules\empowerment_products\controllers;

use Exception;
use Yii;
use yeesoft\controllers\admin\BaseController;
use yii\helpers\ArrayHelper;

/**
 * DefaultController implements the CRUD actions for common\models\News model.
 */
class DefaultController extends BaseController 
{

    public $modelClass       = 'backend\modules\empowerment_products\models\EmpowermentProducts';
    public $modelSearchClass = 'backend\modules\empowerment_products\models\search\EmpowermentProductsSearch';
    public $seoModelClass = 'yeesoft\seo\models\Seo';
    public $frontUrl= "/empowerment-products/";
    
    
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