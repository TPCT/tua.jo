<?php

namespace backend\modules\sponsorship_families\controllers;

use common\helpers\Utility;
use common\models\User;
use yeesoft\controllers\admin\BaseController;
use yeesoft\helpers\YeeHelper;
use yeesoft\models\OwnerAccess;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\StringHelper;


/**
 * DefaultController implements the CRUD actions for common\models\donation model.
 */
class DefaultController extends BaseController
{
    public $modelClass = 'backend\modules\sponsorship_families\models\SponsorshipFamilies';
    public $modelSearchClass = 'backend\modules\sponsorship_families\models\search\SponsorshipFamiliesSearch';


 
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
            if( isset($params[$searchName]) )
            {
                $params[$searchName] = Utility::sanitize($params[$searchName]);
            }
            if ($restrictAccess) {
                $params[$searchName][$modelClass::getOwnerField()] = Yii::$app->user->identity->id;
            }

            $dataProvider = $searchModel->search($params);

        } else {
            $restrictParams = ($restrictAccess) ? [$modelClass::getOwnerField() => Yii::$app->user->identity->id] : [];
            $dataProvider = new ActiveDataProvider(['query' => $modelClass::find()->where($restrictParams)]);
        }


        return $this->renderIsAjax($this->indexView, compact('dataProvider', 'searchModel'));
    }

}