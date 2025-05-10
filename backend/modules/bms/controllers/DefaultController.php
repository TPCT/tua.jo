<?php

namespace backend\modules\bms\controllers;

use common\helpers\Utility;
use common\models\User;
use yeesoft\controllers\admin\BaseController;
use yeesoft\helpers\YeeHelper;
use yeesoft\models\OwnerAccess;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\StringHelper;

use backend\modules\bms\models\BmsFeature;

use common\components\SaveDynamicFormControllerTrait;
use common\components\SaveInBetweenTableControllerTrait;
use common\components\SaveMorphTableControllerTrait;
use Exception;

/**
 * DefaultController implements the CRUD actions for common\models\News model.
 */
class DefaultController extends BaseController
{
    use SaveDynamicFormControllerTrait;
    use SaveInBetweenTableControllerTrait;
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


        $dataProvider->query->andWhere(['module_class' => null]);

        return $this->renderIsAjax($this->indexView, compact('dataProvider', 'searchModel'));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new $this->modelClass;

        $model->bmsFeatureList = count($model->bmsFeatures) ? $model->bmsFeatures : [new BmsFeature()];


        if($model->load(Yii::$app->request->post())  && $model->validate() )
        {

            $transaction = \Yii::$app->db->beginTransaction();
            try 
            {
                $this->actionBehaviors->actionCreate($model);

                

                $data = Yii::$app->request->post();
                if(isset($data["BmsFeature"]))
                {
                    $bmsFeatures = $data["BmsFeature"];
                    $this->DynamicFormCreateUpdate($bmsFeatures,BmsFeature::className(),$model,"bms_id");
                }

                
                $transaction->commit();
            } 
            catch (Exception $e) 
            {
                $transaction->rollBack();
                var_dump($e->getMessage());exit;
            }
            

            return $this->redirect($this->getRedirectPage('create', $model));
        }
        return $this->renderIsAjax($this->createView, compact(['model']) );

    }
        
    /**
     * Updates an existing model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionUpdate($id)
    {
        
        /* @var $model \yeesoft\db\ActiveRecord */
        $model = $this->findModel($id);

        $model->bmsFeatureList = count($model->bmsFeatures) ? $model->bmsFeatures : [new BmsFeature()];

        if($model->load(Yii::$app->request->post())  && $model->validate() )
        {
            $transaction = \Yii::$app->db->beginTransaction();
            try 
            {
                $this->actionBehaviors->actionUpdate($model);
    
                $data = Yii::$app->request->post();
                $this->deleteOldData($model->bmsFeatures,$data["BmsFeature"]??null,BmsFeature::class);
                if(isset($data["BmsFeature"]))
                {
                    $bmsFeatures = $data["BmsFeature"];
                    $this->DynamicFormCreateUpdate($bmsFeatures,BmsFeature::className(),$model,"bms_id");
                }

                    
                $transaction->commit();
            } 
            catch (Exception $e) 
            {
                $transaction->rollBack();
                var_dump($e->getMessage());exit;
            }

            return $this->redirect($this->getRedirectPage('update', $model));
        }
        return $this->renderIsAjax($this->updateView, compact(['model']));

    }

}