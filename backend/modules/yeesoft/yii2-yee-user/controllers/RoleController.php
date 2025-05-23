<?php

namespace yeesoft\user\controllers;

use yeesoft\controllers\admin\BaseController;
use yeesoft\helpers\AuthHelper;
use yeesoft\models\Permission;
use yeesoft\models\Role;
use yeesoft\user\models\search\RoleSearch;
use Yii;
use yii\helpers\ArrayHelper;
use yii\rbac\DbManager;

class RoleController extends BaseController
{
    /**
     * @var Role
     */
    public $modelClass = 'yeesoft\models\Role';

    /**
     * @var RoleSearch
     */
    public $modelSearchClass = 'yeesoft\user\models\search\RoleSearch';

    /**
     * @param string $id
     *
     * @return string
     */
    public function actionView($id)
    {
        $data['role'] = $this->findModel($id);

        $authManager = new DbManager();
 
        $data['permissions'] = Permission::find()
            ->andWhere(Yii::$app->yee->auth_item_table . '.name != :commonPermissionName',
                [':commonPermissionName' => Yii::$app->yee->commonPermissionName])
            ->joinWith('group')
            ->orderBy(['group_code' => SORT_DESC])
            ->all();


        $currentRoutesAndPermissions = AuthHelper::separateRoutesAndPermissions($authManager->getPermissionsByRole($data['role']->name));

        $data['currentPermissions'] = ArrayHelper::getColumn($currentRoutesAndPermissions->permissions,"name");

        return $this->renderIsAjax('view', $data );
    }

    /**
     * Add or remove child roles and return back to view
     *
     * @param string $id
     *
     * @return \yii\web\Response
     */
    public function actionSetChildRoles($id)
    {
        $role = $this->findModel($id);

        $newChildRoles = Yii::$app->request->post('child_roles', []);

        $children = (new DbManager())->getChildren($role->name);

        $oldChildRoles = [];

        foreach ($children as $child) {
            if ($child->type == Role::TYPE_ROLE) {
                $oldChildRoles[$child->name] = $child->name;
            }
        }

        $toRemove = array_diff($oldChildRoles, $newChildRoles);
        $toAdd = array_diff($newChildRoles, $oldChildRoles);

        Role::addChildren($role->name, $toAdd);
        Role::removeChildren($role->name, $toRemove);

        Yii::$app->session->setFlash('crudMessage', Yii::t('yee', 'Saved'));

        return $this->redirect(['view', 'id' => $id]);
    }

    /**
     * Add or remove child permissions (including routes) and return back to view
     *
     * @param string $id
     *
     * @return \yii\web\Response
     */
    public function actionSetChildPermissions($id)
    {
        $role = $this->findModel($id);

        $newChildPermissions = Yii::$app->request->post('child_permissions', []);

        $oldChildPermissions = array_keys((new DbManager())->getPermissionsByRole($role->name));

        $toRemove = array_diff($oldChildPermissions, $newChildPermissions);
        $toAdd = array_diff($newChildPermissions, $oldChildPermissions);

        Role::addChildren($role->name, $toAdd);
        Role::removeChildren($role->name, $toRemove);

        Yii::$app->session->setFlash('crudMessage', Yii::t('yii', 'Saved'));

        return $this->redirect(['view', 'id' => $id]);
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Role;
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
}