<?php

namespace yeesoft\page\controllers;

use common\components\SaveMorphTableControllerTrait;
use common\helpers\Utility;
use Yii;
use yeesoft\controllers\admin\BaseController;

use common\models\User;
use Exception;
use yeesoft\helpers\YeeHelper;
use yeesoft\models\OwnerAccess;
use yeesoft\page\models\Page;
use yii\data\ActiveDataProvider;
use yii\helpers\StringHelper;


/**
 * DefaultController implements the CRUD actions for common\models\News model.
 */
class BmsController extends BaseController
{

    use SaveMorphTableControllerTrait;

    public $modelClass = 'backend\modules\bms\models\Bms';
    public $modelSearchClass = 'backend\modules\bms\models\search\BmsSearch';


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


        $module_id = Yii::$app->request->get('module_id');

        $dataProvider->query->andWhere(['NOT', ['module_id' => null]]);

        $dataProvider->query->andFilterWhere(['module_id' => $module_id, 'module_class' => Page::className()]);

        return $this->renderIsAjax($this->indexView, compact('dataProvider', 'searchModel', 'module_id'));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new $this->modelClass;
        $model->module_id = Yii::$app->request->get('module_id');
        $model->module_class = Page::className();

        if(!$model->module_id)
            return $this->redirect(['/page']);

        if($model->load(Yii::$app->request->post())  && $model->validate() )
        {

            $transaction = \Yii::$app->db->beginTransaction();
            try 
            {
                $this->actionBehaviors->actionCreate($model);

                
                $transaction->commit();
            } 
            catch (Exception $e) 
            {
                // var_dump($e->getMessage());exit;
                $transaction->rollBack();
                error_log($e->getMessage());
            }
            

            return $this->redirect($this->getRedirectPage('create', $model));
        }
        return $this->renderIsAjax($this->createView, compact(['model']) );
    }


    public function actionUpdate($id)
    {
        
        /* @var $model \yeesoft\db\ActiveRecord */
        $model = $this->findModel($id);


        if($model->load(Yii::$app->request->post())  && $model->validate() )
        {
            $transaction = \Yii::$app->db->beginTransaction();
            try 
            {
                $this->actionBehaviors->actionUpdate($model);


                $transaction->commit();
            } 
            catch (Exception $e) 
            {
                // var_dump($e->getMessage());exit;
                $transaction->rollBack();
                error_log($e->getMessage());
            }

            return $this->redirect($this->getRedirectPage('update', $model));
        }
        return $this->renderIsAjax($this->updateView, compact(['model']));

    }

    

}