<?php

namespace yeesoft\user\controllers;

use ReflectionClass;
use yeesoft\controllers\admin\BaseController;
use yeesoft\helpers\AuthHelper;
use yeesoft\models\AbstractItem;
use yeesoft\models\Permission;
use yeesoft\models\Route;
use yeesoft\user\models\search\PermissionSearch;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\helpers\Inflector;
use yii\helpers\VarDumper;

class PermissionController extends BaseController
{
    /**
     * @var Permission
     */
    public $modelClass = 'yeesoft\models\Permission';

    /**
     * @var PermissionSearch
     */
    public $modelSearchClass = 'yeesoft\user\models\search\PermissionSearch';

    /**
     * @param string $id
     *
     * @return string
     */
    public function actionView($id)
    {
        $data['item'] = $this->findModel($id);

        $childRoutes = AuthHelper::getChildrenByType($data['item']->name, AbstractItem::TYPE_ROUTE);
        $data['values'] =  ArrayHelper::getColumn($childRoutes, 'name');

        $data['modules'] = Permission::find()
            ->select(['module', 'COUNT(*) as count']) // Select the grouped column and an aggregate function
            ->where(["type" => AbstractItem::TYPE_ROUTE])
            ->andWhere(["!=", "module", "MainControllers"])
            ->groupBy("module")
            ->all();

        $data['mainModule'] = Permission::find()
            ->select(['module', 'COUNT(*) as count']) // Select the grouped column and an aggregate function
            ->where(["type" => AbstractItem::TYPE_ROUTE])
            ->andWhere(["module" => "MainControllers"])
            ->groupBy("module")
            ->all();

        return $this->renderIsAjax('view', $data);
        
    }

    /**
     * Add or remove child permissions (including routes) and return back to view
     *
     * @param string $id
     *
     * @return string|\yii\web\Response
     */
    public function actionSetChildPermissions($id)
    {
        $item = $this->findModel($id);

        $newChildPermissions = Yii::$app->request->post('child_permissions', []);

        $oldChildPermissions = array_keys(AuthHelper::getChildrenByType($item->name,
            AbstractItem::TYPE_PERMISSION));

        $toRemove = array_diff($oldChildPermissions, $newChildPermissions);
        $toAdd = array_diff($newChildPermissions, $oldChildPermissions);

        Permission::addChildren($item->name, $toAdd);
        Permission::removeChildren($item->name, $toRemove);

        Yii::$app->session->setFlash('crudMessage', Yii::t('yee', 'Saved'));

        return $this->redirect(['view', 'id' => $id]);
    }

    /**
     * Add or remove routes for this permission
     *
     * @param string $id
     *
     * @return \yii\web\Response
     */
    public function actionSetChildRoutes($id)
    {
        $item = $this->findModel($id);

        $newRoutes = Yii::$app->request->post('child_routes', []);

        $oldRoutes = array_keys(AuthHelper::getChildrenByType($item->name,
            AbstractItem::TYPE_ROUTE));

        $toAdd = array_diff($newRoutes, $oldRoutes);
        $toRemove = array_diff($oldRoutes, $newRoutes);

        Permission::addChildren($id, $toAdd);
        Permission::removeChildren($id, $toRemove);

        if (($toAdd OR $toRemove) AND ($id == Yii::$app->yee->commonPermissionName)) {
            Yii::$app->cache->delete('__commonRoutes');
        }

        AuthHelper::invalidatePermissions();

        Yii::$app->session->setFlash('crudMessage', Yii::t('yee', 'Saved'));

        return $this->redirect(['view', 'id' => $id]);
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Permission();
        $model->scenario = 'webInputPermission';

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->name]);
        }

        return $this->renderIsAjax('create', compact('model'));
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
        $model = $this->findModel($id);
        $model->scenario = 'webInputPermission';

        if ($model->load(Yii::$app->request->post()) AND $model->save()) {
            return $this->redirect(['view', 'id' => $model->name]);
        }

        return $this->renderIsAjax('update', compact('model'));
    }


    public function actionAddNewRoute()
    {
        $model = new Permission();

        if($model->load(Yii::$app->request->post())  && $model->validate() )
        {
            $model->type = AbstractItem::TYPE_ROUTE;
            Yii::$app->db->createCommand()->insert(Permission::tableName(), $model)->execute();
            Yii::$app->session->setFlash('crudMessage', Yii::t('yee', 'Added'));
            return $this->redirect(['index']);
        }
        return $this->renderIsAjax('new_route', compact('model'));
    }

    public function actionAutoAddPermissions()
    {
        $this->getMainControllerActions();
        $this->getModulesActions();

        return $this->redirect(Yii::$app->request->referrer);
        
    }

    private function getMainControllerActions()
    {
        $moduleName = "MainControllers";
        foreach ($this->getMainControllerFiles() as $file) 
        {

            $className = "backend\controllers\\". basename($file, '.php');

            if (class_exists($className)) 
            {
                $controllerClass = new ReflectionClass($className);
                $methods = $controllerClass->getMethods(\ReflectionMethod::IS_PUBLIC);
    
                        
                $controllerName = lcfirst(str_replace('Controller', '', $controllerClass->getShortName()));
                $allAtControllerUrl = '/'.Inflector::camel2id($controllerName, '-').'/*';
                $moduleUrls[] = $this->createPermisionElement($allAtControllerUrl, $moduleName, "All ".$controllerName." Actions");

                foreach ($methods as $method) 
                {
                    if ( $this->isBeginWithAction($method->getName()) && $method->getName()  !== 'actions') 
                    {
                        $actionName =  substr($method->getName(),6);
                        $actionControllerUrl = '/'.Inflector::camel2id($controllerName, '-').'/'.Inflector::camel2id($actionName, '-');
                        $moduleUrls[] = $this->createPermisionElement($actionControllerUrl, $moduleName, $actionName);
                    }
                }

            }
            
        }

        // VarDumper::dump($moduleUrls,100,true); exit;
        $this->bulkCheckAndInsertPermissions($moduleName,$moduleUrls);
        

    }

    private function getMainControllerFiles()
    {
        return FileHelper::findFiles(Yii::$aliases['@backend'] . '/controllers' , [
            'only' => ['*.php'],
        ]);
        
    }

    private function getModulesActions()
    {
        $config = require(Yii::$aliases['@backend'] . '/config/main.php');

        //$moduleUrls=[];
        
        foreach($config["modules"] as $key => $item)
        {
            if( $this->isIgnore($item))
            {
                continue;
            }
            
            $module = new $item["class"]($key);
            
            $moduleUrls=[];

            $moduleName = $module->id;
            $allUrl = '/'.$moduleName.'/*';
            $moduleUrls[] = $this->createPermisionElement($allUrl,$moduleName,"All ". $moduleName ." Actions");
            
            foreach ($this->getControllerFiles($module,$item) as $file) 
            {
                $className = $module->controllerNamespace ."\\". basename($file, '.php');
                if (class_exists($className)) 
                {
                    $controllerClass = new ReflectionClass($className);
                    $methods = $controllerClass->getMethods(\ReflectionMethod::IS_PUBLIC);

                    
                    $controllerName = lcfirst(str_replace('Controller', '', $controllerClass->getShortName()));
                    $allAtControllerUrl = '/'.$moduleName.'/'.Inflector::camel2id($controllerName, '-').'/*';
                    $moduleUrls[] = $this->createPermisionElement($allAtControllerUrl,$moduleName,"All ".$controllerName." Actions");

                    foreach ($methods as $method) 
                    {
                        if ( $this->isBeginWithAction($method->getName()) && $method->getName()  !== 'actions') 
                        {
                            $actionName =  substr($method->getName(),6);
                            $actionControllerUrl =  '/'.$moduleName.'/'.Inflector::camel2id($controllerName, '-').'/'.Inflector::camel2id($actionName, '-');
                            $moduleUrls[] = $this->createPermisionElement($actionControllerUrl,$moduleName,$actionName);
                        }
                    }                    
                }
            }

            // VarDumper::dump($moduleUrls,100,true); exit;
            $this->bulkCheckAndInsertPermissions($moduleName,$moduleUrls);
            
            
        }


    }

    private function isIgnore($item)
    {
        if($this->isAuditModule($item) || $this->isKartikGrid($item))
        {
            return true;
        }
    }
    
    private function isAuditModule($item)
    {
        return substr($item["class"],0,8) == "bedezign";
    }

    private function isKartikGrid($item)
    {
        return substr($item["class"],0,7) == "\kartik";
    }

    private function createPermisionElement($name,$moduleName,$action)
    {
        return
        [
            'name' => $name,
            'type' => 3,
            'module' => $moduleName,
            'action' => $action,
            'created_at' => time(),
            'updated_at' => time(),
        ];
    }

    private function isBeginWithAction($methodName)
    {
        return substr( $methodName, 0, 6 ) =="action";
    }

    private function getControllerFiles($module,$item)
    {
        if( $this->isYeeSoftModule($item))
        {
            return $this->getYeeSoftController($module);
        }

        $controllerNamespace = str_replace("\\","/",$module->controllerNamespace);
        
        return FileHelper::findFiles(Yii::$aliases['@backend'] .substr($controllerNamespace,7) , [
            'only' => ['*.php'],
        ]);
    }

    
    private function isYeeSoftModule($item)
    {
        return substr($item["class"],0,7) == "yeesoft";
    }

    
    private function getYeeSoftController($module)
    {
        $yeesoft = substr($module->controllerNamespace,0,8);
        $remaining = substr($module->controllerNamespace,8);
        $newYii2String = 'yii2-yee-';
        $ControllerNamespace = '/modules/'. $yeesoft . $newYii2String . $remaining;
        $ControllerNamespace = str_replace("\\","/",$ControllerNamespace);
        
        return FileHelper::findFiles(Yii::$aliases['@backend'] . $ControllerNamespace , [
            'only' => ['*.php'],
        ]);
    }

    private function bulkCheckAndInsertPermissions($moduleName, $moduleUrls)
    {
        $existsPermissions =  Permission::find()->where(['module'=>$moduleName])->all();
        $existingUrls = ArrayHelper::getColumn($existsPermissions,"name");
        $insertUrls = [];
        foreach ($moduleUrls as $newUrl) 
        {
            if (!in_array($newUrl['name'], $existingUrls)) 
            {
                $insertUrls[] = $newUrl;
            }
        }
        
        if (!empty($insertUrls)) 
        {
            //VarDumper::dump($insertUrls,100,true); exit;
            Yii::$app->db->createCommand()->batchInsert(
                                                            Permission::tableName(), 
                                                            [
                                                                'name','type','module','action',
                                                                'created_at','updated_at'
                                                            ], 
                                                            $insertUrls
                                                        )->execute();
        }
        
    }



}