<?php

namespace backend\modules\zakat_stories\controllers;

use Exception;
use Yii;
use yeesoft\controllers\admin\BaseController;
use yii\helpers\ArrayHelper;

/**
 * DefaultController implements the CRUD actions for common\models\News model.
 */
class DefaultController extends BaseController 
{

    public $modelClass       = 'backend\modules\zakat_stories\models\ZakatStories';
    public $modelSearchClass = 'backend\modules\zakat_stories\models\search\ZakatStoriesSearch';
    public $seoModelClass = 'yeesoft\seo\models\Seo';
    public $frontUrl= "/zakat-stories/";
    
    
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