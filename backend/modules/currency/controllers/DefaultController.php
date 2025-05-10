<?php

namespace backend\modules\currency\controllers;

use common\components\implementation\ImportExcelNoraml;
use common\components\SaveDynamicFormControllerTrait;
use common\components\SaveInBetweenTableControllerTrait;
use yeesoft\controllers\admin\BaseController;

use Exception;
use Yii;


/**
 * DefaultController implements the CRUD actions for common\models\News model.
 */
class DefaultController extends BaseController
{
    use SaveInBetweenTableControllerTrait;
    use SaveDynamicFormControllerTrait;
    
    public $modelClass = 'backend\modules\currency\models\Currency';
    public $modelSearchClass = 'backend\modules\currency\models\search\CurrencySearch';

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