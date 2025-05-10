<?php

namespace yeesoft\user\controllers;

use common\helpers\Utility;
use ReflectionClass;
use yeesoft\controllers\admin\BaseController;
use yeesoft\helpers\AuthHelper;
use yeesoft\models\AbstractItem;
use yeesoft\helpers\YeeHelper;
use yeesoft\models\OwnerAccess;
use yeesoft\models\User;
use yii\base\InvalidConfigException;
use yii\data\ActiveDataProvider;
use yii\helpers\StringHelper;
use yeesoft\models\Route;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\FileHelper;
use yii\helpers\Inflector;
use yii\helpers\VarDumper;

class RouteController extends BaseController
{
    /**
     * @var Route
     */
    public $modelClass = 'yeesoft\models\Route';

    /**
     * @var RouteSearch
     */
    public $modelSearchClass = 'yeesoft\user\models\search\RouteSearch';

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

        $data["searchModel"] = $searchModel;
        $data["dataProvider"] = $dataProvider;

        return $this->renderIsAjax($this->indexView, $data);
    }
    /**
     * @param string $id
     *
     * @return string
     */
    public function actionView($id)
    {
        $data['model'] = $this->findModel($id);

        return $this->renderIsAjax('view', $data);
    }


    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Route();
        $model->scenario = 'webInputRoute';

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
        $model->scenario = 'webInputRoute';

        if ($model->load(Yii::$app->request->post()) AND $model->save()) {
            return $this->redirect(['view', 'id' => $model->name]);
        }

        return $this->renderIsAjax('update', compact('model'));
    }


}