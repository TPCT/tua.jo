<?php

namespace yeesoft\controllers\admin\implementations;

use backend\modules\revisions\models\Revision;
use common\helpers\Utility;
use yeesoft\controllers\admin\BaseController;
use yeesoft\controllers\admin\interfaces\BaseActionInterface;
use yeesoft\helpers\YeeHelper;
use yeesoft\models\OwnerAccess;
use yeesoft\models\User;
use Yii;
use yii\base\InvalidConfigException;
use yii\data\ActiveDataProvider;
use yii\helpers\StringHelper;
use yii\web\Cookie;
use yii\web\NotFoundHttpException;
use Exception;

class BaseActions  implements BaseActionInterface
{
    protected $parentController;

    public function __construct(BaseController $parentController)
    {
        $this->parentController = $parentController;
    }
    
    /**
     * Lists all models.
     * @return mixed
     */
    public function actionIndex()
    {

        $modelClass = $this->parentController->modelClass;
        $searchModel = $this->parentController->modelSearchClass ? new $this->parentController->modelSearchClass : null;
        $restrictAccess = (YeeHelper::isImplemented($modelClass, OwnerAccess::CLASSNAME)
            && !User::hasPermission($modelClass::getFullAccessPermission()));

        if ($searchModel) 
        {
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

        return compact('dataProvider', 'searchModel');
        // return $this->renderIsAjax($this->indexView, compact('dataProvider', 'searchModel'));

    }

    /**
     * Displays a single model.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        return compact('model');
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($model)
    {

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('crudMessage', Yii::t('yee', 'Your item has been created.'));
            //return $this->redirect($this->getRedirectPage('create', $model));
        }

        return compact('model');

        //return $this->renderIsAjax($this->createView, compact('model'));
        

    }

    /**
     * Updates an existing model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param object $model
     *
     * @return mixed
     */
    public function actionUpdate($model)
    {
        if ($model->load(Yii::$app->request->post()) AND $model->save()) {
            Yii::$app->session->setFlash('crudMessage', Yii::t('yee', 'Your item has been updated.'));
            //return $this->redirect($this->getRedirectPage('update', $model));
        }

        return compact('model');
       // return $this->renderIsAjax($this->updateView, compact('model'));

    }

    /**
     * Deletes an existing model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionDelete($id)
    {
        /* @var $model \yeesoft\db\ActiveRecord */
        $model = $this->findModel($id);

        try
        {
            $model->delete();

            Yii::$app->session->setFlash('crudMessage', Yii::t('yee', 'Your item has been deleted.'));
        }
        catch (Exception $e)
        {
            Yii::$app->session->setFlash('crudMessage', "Can't delete because of ". $e->getMessage());
        }

        return compact('model');
        //return $this->redirect($this->getRedirectPage('delete', $model));
    }


    public function actionHistory($id)
    {
        $modelClass = $this->parentController->modelClass;
        $model = $this->findModel($id);
        
        $query = $modelClass::find();
        $query = $query->andWhere(["revision"=>$id]);
        $dataProvider = new ActiveDataProvider(['query' => $query]);

        $label = $modelClass::labelAtView();

        return compact('model','dataProvider', 'label', 'modelClass');
    }

    public function actionMakeRevisionAction()
    {
        $modelClass = $this->parentController->modelClass;
        Yii::$app->session->setFlash('crudMessage', Yii::t('yee', Revision::getAllActiveModlesandModuleKey()[$modelClass].' is not in revision table, add it to make revision'));
        return $this->parentController->redirect('index');
    }

    public function actionRemoveRejection()
    {
        $modelClass = $this->parentController->modelClass;
        Yii::$app->session->setFlash('crudMessage', Yii::t('yee', Revision::getAllActiveModlesandModuleKey()[$modelClass].' is not in revision table, add it to make revision'));
        $revision = false;
        return compact("revision");
        //return $this->parentController->redirect('index');
    }



    /**
     * @param string $attribute
     * @param int $id
     */
    public function actionToggleAttribute($attribute, $id)
    {
        //TODO: Restrict owner access
        /* @var $model \yeesoft\db\ActiveRecord */
        $model = $this->findModel($id);
        $model->{$attribute} = ($model->{$attribute} == 1) ? 0 : 1;
        $model->save(false);
          
    }

    /**
     * Activate all selected grid items
     */
    public function actionBulkActivate()
    {
        if (Yii::$app->request->post('selection')) {
            $modelClass = $this->parentController->modelClass;
            $restrictAccess = (YeeHelper::isImplemented($modelClass, OwnerAccess::CLASSNAME)
                && !User::hasPermission($modelClass::getFullAccessPermission()));
            $where = ['id' => Yii::$app->request->post('selection', [])];

            if ($restrictAccess) {
                $where[$modelClass::getOwnerField()] = Yii::$app->user->identity->id;
            }

            $model = new $modelClass();
            if( $model->hasAttribute("status") )
            {
                $modelClass::updateAll(['status' => 1], $where);
            }

            $modelClassLang = $modelClass."Lang";
            if( class_exists($modelClassLang) )
            {
                $langModel = new $modelClassLang();
                if( $langModel->hasAttribute("status") )
                {
                    $whereLang = ['parent_id' => Yii::$app->request->post('selection', [])];
                    $modelClassLang::updateAll(['status' => 1], $whereLang);
                }
            }
            
        }
    }

    /**
     * Deactivate all selected grid items
     */
    public function actionBulkDeactivate()
    {
        if (Yii::$app->request->post('selection')) {
            $modelClass = $this->parentController->modelClass;
            $restrictAccess = (YeeHelper::isImplemented($modelClass, OwnerAccess::CLASSNAME)
                && !User::hasPermission($modelClass::getFullAccessPermission()));
            $where = ['id' => Yii::$app->request->post('selection', [])];

            if ($restrictAccess) {
                $where[$modelClass::getOwnerField()] = Yii::$app->user->identity->id;
            }

            $model = new $modelClass();
            if( $model->hasAttribute("status") )
            {
                $modelClass::updateAll(['status' => 0], $where);
            }

            $modelClassLang = $modelClass."Lang";
            if( class_exists($modelClassLang) )
            {
                $langModel = new $modelClassLang();
                if( $langModel->hasAttribute("status") )
                {
                    $whereLang = ['parent_id' => Yii::$app->request->post('selection', [])];
                    $modelClassLang::updateAll(['status' => 0], $whereLang);
                }
            }
        }
    }

    /**
     * Deactivate all selected grid items
     */
    public function actionBulkDelete()
    {
        if (Yii::$app->request->post('selection')) {
            $modelClass = $this->parentController->modelClass;
            $restrictAccess = (YeeHelper::isImplemented($modelClass, OwnerAccess::CLASSNAME)
                && !User::hasPermission($modelClass::getFullAccessPermission()));

            foreach (Yii::$app->request->post('selection', []) as $id) {
                $where = ['id' => $id];

                if ($restrictAccess) {
                    $where[$modelClass::getOwnerField()] = Yii::$app->user->identity->id;
                }

                $model = $modelClass::findOne($where);

                if ($model) $model->delete();
            }
        }
    }



    /**
     * Finds the model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param mixed $id
     *
     * @return ActiveRecord the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $modelClass = $this->parentController->modelClass;
        $model = new $modelClass;
        
        if (method_exists($model, 'isMultilingual') && $model->isMultilingual()) {
            $condition = [];
            $primaryKey = $modelClass::primaryKey();
            $query = $modelClass::find();

            if (isset($primaryKey[0])) {
                $condition = [$primaryKey[0] => $id];
            } else {
                throw new InvalidConfigException('"' . Pos . '" must have a primary key.');
            }

            $model = $query->andWhere($condition)->multilingual()->one();
        } else {
            $model = $modelClass::findOne($id);
        }

        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }
    }


}