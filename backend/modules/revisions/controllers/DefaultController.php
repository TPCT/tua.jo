<?php

namespace backend\modules\revisions\controllers;

use yeesoft\controllers\admin\BaseController;
use yeesoft\helpers\YeeHelper;
use yeesoft\models\OwnerAccess;
use yeesoft\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\StringHelper;
use backend\modules\revisions\models\Revision;
use common\helpers\Utility;

/**
 * DefaultController implements the CRUD actions for common\models\Revision model.
 */
class DefaultController extends BaseController
{
    public $modelClass = 'backend\modules\revisions\models\Revision';
    public $modelSearchClass = 'backend\modules\revisions\models\search\RevisionSearch';
    public $modelOldSearchClass = 'backend\modules\revisions\models\search\RevisionOldSearch';

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
    public function actionIndexOld()
    {

        $parent_id = Yii::$app->getRequest()->getQueryParam('parent_id');
        $type = Yii::$app->getRequest()->getQueryParam('type');
        $revision = Yii::$app->getRequest()->getQueryParam('revision');
        $revision_id = Yii::$app->getRequest()->getQueryParam('revision_id');
        $revisionModel = Revision::findOne(["id"=>$revision_id]);
        //$modelClass = $this->getType($type);
        $modelClass = $revisionModel->model;

        $searchModel = $this->modelOldSearchClass ? $this->modelOldSearchClass : null;
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


            $query = $modelClass::find()->joinWith('translations');


            $dataProvider = new ActiveDataProvider([
                'query' => $query,
                'pagination' => [
                    'pageSize' => Yii::$app->request->cookies->getValue('_grid_page_size', 20),
                ],
                'sort' => [
                    'defaultOrder' => [
                        'id' => SORT_DESC,
                    ],
                ],
            ]);

            $user = Yii::$app->user->identity;
            if (\yeesoft\models\User::hasPermission('maker', false) ) //if maker handle with changes
            {
                $table_name = $modelClass::tableName();
                $query->andFilterWhere([
                    "$table_name.id" => $parent_id,
                ]);
            }
            else if(\yeesoft\models\User::hasPermission('checker', false) || $user->superadmin )// if checker handle with rejected
            {
                if($revision == -1) //new creation
                {
                    $table_name = $modelClass::tableName();
                    $query->andFilterWhere([
                        "revision" => -1,
                        "changed" => 1,
                        "$table_name.id" => $parent_id,
                    ]);
                }
                else
                {
                    $query->andFilterWhere([
                        "revision" => $parent_id,
                        "changed" => 0,
                    ]);
                }

            }
            $query->groupBy(["id"]);

        } else {
            $restrictParams = ($restrictAccess) ? [$modelClass::getOwnerField() => Yii::$app->user->identity->id] : [];
            $dataProvider = new ActiveDataProvider(['query' => $modelClass::find()->where($restrictParams)]);
        }
        //echo ($query->createCommand()->rawSql); exit;

        return $this->renderIsAjax('index-old', compact('dataProvider', 'searchModel', 'type'));
    }

    
}