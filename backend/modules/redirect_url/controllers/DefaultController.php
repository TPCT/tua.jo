<?php

namespace backend\modules\redirect_url\controllers;

use common\components\implementation\ImportExcelNoraml;
use Exception;
use yeesoft\controllers\admin\BaseController;
use Yii;

/**
 * DefaultController implements the CRUD actions for common\models\News model.
 */
class DefaultController extends BaseController
{
    
    public $modelClass = 'backend\modules\redirect_url\models\RedirectUrl';
    public $modelSearchClass = 'backend\modules\redirect_url\models\search\RedirectUrlSearch';
 
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

    public function actionImportFile()
    {
        $import = new ImportExcelNoraml();
        $data = $import->importExcel($this->modelClass);
        return $this->render("//common/xcel_form",$data);
    }



}