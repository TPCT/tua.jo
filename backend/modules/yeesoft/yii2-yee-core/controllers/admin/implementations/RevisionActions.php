<?php

namespace yeesoft\controllers\admin\implementations;

use common\helpers\Utility;
use Exception;
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

class RevisionActions implements BaseActionInterface
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
        
        $hasMakerPermission = \yeesoft\models\User::hasPermission('maker', false);
        if ($model->load(Yii::$app->request->post())  && $model->validate() ) 
        {
            
            if ($hasMakerPermission) 
            {
                $model->status = 0;
                $model->changed = 1;
                $model->revision = -1;
            }
            if($model->save())
            {
                //var_dump("rr");exit;
            }
            else
            {
                //var_dump($model->errors); var_dump($model);exit;
                Yii::$app->session->setFlash('crudMessage', Yii::t('yee', 'Validation problem'));
                //return $this->redirect($this->getRedirectPage('create', $model)); 
            }
                
                
                
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
        // Changed on parent
        if ($model->revision>0) 
        {
            $parentModel = $this->findModel($model->revision);
            $parentModel->changed = 1;
            $parentModel->save(false);
        }
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()) 
        {
        
            $hasPermission = \yeesoft\models\User::hasPermission('maker', false);


            // Save Revision
            if ($hasPermission) 
            {
                // if model is revision or not
                // if ($model->revision) 
                // {
                //     $model->revision = $model->revision;
                // } 
                // else 
                // {
                //     $model->revision = $model->id;
                // }
                if($model->changed==0 && $model->revision==0) //new change from maker
                {
                    $model->updateAttributes(['changed' => 1]);

                    $child = new $this->parentController->modelClass;
                    $child->load(Yii::$app->request->post());
                    $child->revision = $model->id;
                    if(isset($child->slug)) //branch not has slug
                    {
                        $child->slug = null;
                    }
                    if($child->validate())
                    {
                        $child->save(false);                    
                    }
                    else
                    {
                        var_dump($model->errors);exit;
                        Yii::$app->session->setFlash('crudMessage', Yii::t('yee', 'Validation problem'));
                        //return $this->redirect($this->getRedirectPage('update', $model));  
                    }

                    // $model->revision = $model->id;
                    // $model->id = null;
                    // if(isset($model->slug)) //branch not has slug
                    // {
                    //     $model->slug = null;
                    // }
                    // $model->isNewRecord = true;
                    // $model->status = 0;
                    // if($model->validate())
                    // {
                    //     $model->save(false);                    
                    // }
                    // else
                    // {
                    //     //var_dump($model->errors);exit;
                    //     Yii::$app->session->setFlash('crudMessage', Yii::t('yee', 'Validation problem'));
                    //     //return $this->redirect($this->getRedirectPage('update', $model));  
                    // }


                }
                else if(($model->changed==0 && $model->revision!=0) || ($model->changed==1 && $model->revision==-1) ) //updating at new changed record
                {
                    $model->save();
                }
                else if($model->changed==1 && $model->revision==0 ) //changed before so just update changed record (child) (change on item changed before)
                {
                    $child = $this->parentController->modelClass::find()->joinWith("translations")->where(['revision'=>$model->id])->orderBy(["id"=>SORT_DESC])->one();
                    if(isset($child->slug)) //branch not has slug
                    {
                        $child_slug = $child->slug;
                        $child->load(Yii::$app->request->post());
                        $child->slug = $child_slug;
                    }
                    $child->status = 0;
                    if($child->validate())
                    {
                        //var_dump($child);exit;
                        if(!$child->save())
                        {
                           // var_dump($child->errors);exit;
                            Yii::$app->session->setFlash('crudMessage', Yii::t('yee', 'Validation problem'));
                            //return $this->redirect($this->getRedirectPage('update', $model));                   
                        
                        }
                    }
                    else
                    {
                        var_dump($child->errors);exit;
                        Yii::$app->session->setFlash('crudMessage', Yii::t('yee', 'Validation problem'));
                       // return $this->redirect($this->getRedirectPage('update', $model));                   
                    }
                    
                }
                else if($model->changed==1 && $model->revision!=0 )
                {
                    Yii::$app->session->setFlash('crudMessage', Yii::t('yee', 'Not updated, This item replaced with new item which has id:').$model->revision);
                    //return $this->redirect($this->getRedirectPage('update', $model));
                }

            } 
            else 
            {

                if($model->revision != 0 && $model->changed == 0)
                {
                    $parentModel = $this->findModel($model->revision);
                    $parentModel->status = 0;
                    $parentModel->revision = $model->id;
                    $parentModel->changed = 1;
                    $parentModel->save(false);    
                }

                $model->changed = 0;
                $model->revision= 0;
                $model->reject_note = null;
                $model->save();
            
            }
            
            Yii::$app->session->setFlash('crudMessage', Yii::t('yee', 'Your item has been updated.'));
            //return $this->redirect($this->getRedirectPage('update', $model));
        }

        return compact('model');

        //return $this->renderIsAjax($this->updateView, compact('model'));


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
        
        if($model->changed==1 && $model->revision==0 ) //changed so delete it and its child
        {
            $child = $this->parentController->modelClass::find()->joinWith("translations")->where(['revision'=>$model->id])->orderBy(["id"=>SORT_DESC])->one();
            if($child)
            {
                try
                {
                    $child->delete();//delete its child

                }
                catch (Exception $e)
                {
                    Yii::$app->session->setFlash('crudMessage', "Can't delete because of ". $e->getMessage());
                }
            }

        }

        try
        {
            $model->delete();

            Yii::$app->session->setFlash('crudMessage', Yii::t('yee', 'Your item has been deleted.'));
        }
        catch (Exception $e)
        {
            Yii::$app->session->setFlash('crudMessage', "Can't delete because of ". $e->getMessage());
        }

        return compact("model");
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

        return compact('model','dataProvider','label', 'modelClass');
    }

    public function actionMakeRevisionAction()
    {
        $req = Yii::$app->request;
        $id = $req->get('id');
        $revision_id = $req->get('revision_id', 0);
        //$pending = $req->get('pending', 0);
        $reject_note = $req->get('reject_note', '');
        
        
        // if ($pending) { // change status - superadmin
        //     var_dump("a");exit;
        //     $model = parent::findModel($id);
        //     $model->status = 1;
        //     $model->save(false);
            
        // } elseif (!$pending && $reject_note == '') { // Make revision published - checker
        if ($reject_note == '') 
        {
            
            // Make revision published - checker || superadmin
            $model = $this->parentController->modelClass;
            
            
            if($revision_id != -1) //created from maker
            {
                $model::updateAll(['revision' => $id], ['revision' => $revision_id]);
                $currentModel = $this->findModel($revision_id);
                $currentModel->revision = $id;
                $currentModel->status = 0;
                //$curruntSlug = $currentModel->slug;
            }

            $model = $this->findModel($id);
            $model->revision = 0;
            $model->status = 1;
            $model->changed = 0;
            
            //$modelSlug = $model->slug;

            //$currentModel->slug ="-1"; //temperory value
            //$currentModel->save(false);
            //$currentModel->slug = $modelSlug;
            //$model->slug = $curruntSlug;
            
            $model->save(false);
            if($revision_id != -1)
            {
                $currentModel->save(false);
            }
            
            
        }
        Yii::$app->session->setFlash('success', "Make Published successfully."); 

        
        if ($reject_note != '') 
        { // Reject revision
            $model = $this->findModel($id);
            $model->reject_note = $reject_note;
            $model->save(false);
            Yii::$app->session->setFlash('success', "Rejected successfully."); 
        }
        
        return $this->parentController->redirect('index');
    }

    public function actionRemoveRejection()
    {
        $req = Yii::$app->request;
        $id = $req->get('id');
        $model = $this->findModel($id);
        $model->reject_note = null;
        $model->save();
        Yii::$app->session->setFlash('crudMessage', Yii::t('yee', 'Rejction note removed'));
        $revision = true;
        return compact("model","revision");
        
        //return $this->parentController->redirect($this->parentController->getRedirectPage('update', $modelClass));
    }

    /**
     * @param string $attribute
     * @param int $id
     */
    public function actionToggleAttribute($attribute, $id)
    {
        $makerPermission = \yeesoft\models\User::hasPermission('maker', false);
        if(!$makerPermission)
        {
            //TODO: Restrict owner access
            /* @var $model \yeesoft\db\ActiveRecord */
            $model = $this->findModel($id);
            $model->{$attribute} = ($model->{$attribute} == 1) ? 0 : 1;
            $model->save(false);
        }
    }

    /**
     * Activate all selected grid items
     */
    public function actionBulkActivate()
    {
        $makerPermission = \yeesoft\models\User::hasPermission('maker', false);
        if(!$makerPermission)
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
        
    }

    /**
     * Deactivate all selected grid items
     */
    public function actionBulkDeactivate()
    {
        $makerPermission = \yeesoft\models\User::hasPermission('maker', false);
        if(!$makerPermission)
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

                if ($model)
                {
                    if($model->changed==1 && $model->revision==0 ) //changed so delete it and its child
                    {
                        $child = $this->parentController->modelClass::find()->joinWith("translations")->where(['revision'=>$model->id])->orderBy(["id"=>SORT_DESC])->one();
                        $child->delete();//delete its child
                    }
                    $model->delete();
                } 

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