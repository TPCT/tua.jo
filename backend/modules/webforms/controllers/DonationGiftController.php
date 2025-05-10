<?php

namespace backend\modules\webforms\controllers;

use common\models\User;
use yeesoft\controllers\admin\BaseController;
use yeesoft\helpers\YeeHelper;
use yeesoft\models\OwnerAccess;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\StringHelper;
use yii2tech\spreadsheet\Spreadsheet;

/**
 * DonationGiftController implements the CRUD actions for backend\modules\webforms\models\DonationGiftController model.
 */
class DonationGiftController extends BaseController
{
    public $modelClass       = 'backend\modules\webforms\models\DonationGiftWebform';
    public $modelSearchClass = 'backend\modules\webforms\models\search\DonationGiftWebformSearch';

    public $disabledActions = ['create', 'update','delete'];

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

    /**
     * Lists all models.
     * @return mixed
     */
    public function actionIndex()
    {

        $modelClass = $this->modelClass;
        $searchModel = $this->modelSearchClass ? new $this->modelSearchClass : null;
        $restrictAccess = (YeeHelper::isImplemented($modelClass, OwnerAccess::CLASSNAME)
            && !User::hasPermission($modelClass::getFullAccessPermission()));

        if ($searchModel) {
            $searchName = StringHelper::basename($searchModel::className());
            $params = Yii::$app->request->getQueryParams();

            if ($restrictAccess) {
                $params[$searchName][$modelClass::getOwnerField()] = Yii::$app->user->identity->id;
            }

            $dataProvider = $searchModel->search($params);
        } else {
            $restrictParams = ($restrictAccess) ? [$modelClass::getOwnerField() => Yii::$app->user->identity->id] : [];
            $dataProvider = new ActiveDataProvider(['query' => $modelClass::find()->where($restrictParams)]);
        }

        if (Yii::$app->request->get('Export')) {
            $exporter = new Spreadsheet([
                'dataProvider' => $dataProvider,
               'columns' => [
                    'name',
                    'email:email',
                    'phone',
                    'message',
                    'created_at'=>[
                        'attribute' => 'created_at',
                        'format' => ['date', 'php:d/m/Y h:m:s']
                    ],
                    
               ],
            ]);
            $exporter->send('ContactUs.xls');
        }
        return $this->renderIsAjax($this->indexView, compact('dataProvider', 'searchModel'));
    }

    
}