<?php

namespace yeesoft\controllers\admin;

use backend\modules\revisions\models\Revision;
use yeesoft\controllers\admin\implementations\BaseActions;
use yeesoft\controllers\admin\implementations\RevisionActions;
use yeesoft\controllers\admin\interfaces\BaseActionInterface;
use yeesoft\helpers\YeeHelper;
use yeesoft\models\OwnerAccess;
use yeesoft\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yeesoft\db\ActiveRecord;
use yeesoft\seo\models\Seo;
use yii\base\InvalidCallException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;
use yii\web\Cookie;
use yii\web\NotFoundHttpException;

abstract class BaseController extends \yeesoft\controllers\BaseController
{
    /**
     * @var ActiveRecord
     */
    public $modelClass;

    /**
     * @var ActiveRecord
     */
    public $modelSearchClass;

    /**
     * Actions that will be disabled
     *
     * List of available actions:
     *
     * ['index', 'view', 'create', 'update', 'delete', 'toggle-attribute',
     * 'bulk-activate', 'bulk-deactivate', 'bulk-delete', 'grid-sort', 'grid-page-size']
     *
     * @var array
     */
    public $disabledActions = [];

    /**
     * Opposite to $disabledActions. Every action from AdminDefaultController except those will be disabled
     *
     * But if action listed both in $disabledActions and $enableOnlyActions
     * then it will be disabled
     *
     * @var array
     */
    public $enableOnlyActions = [];

    /**
     * List of actions in this controller. Needed fo $enableOnlyActions
     *
     * @var array
     */
    protected $_implementedActions = ['index', 'view', 'create', 'update', 'delete',
        'toggle-attribute', 'bulk-activate', 'bulk-deactivate', 'bulk-delete', 'grid-sort', 'grid-page-size'];

    /**
     * Layout file for admin panel
     *
     * @var string
     */
    public $layout = '@backend/views/layouts/admin/main.php';
    
    /**
     * Index page view
     *
     * @var string
     */
    public $indexView = 'index';
    
    /**
     * View page view
     *
     * @var string
     */
    public $viewView = 'view';
    
    /**
     * Create page view
     *
     * @var string
     */
    public $createView = 'create';
    
    /**
     * Update page view
     *
     * @var string
     */
    public $updateView = 'update';

    public BaseActionInterface $actionBehaviors;

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ]);
    }

    /**
     * Lists all models.
     * @return mixed
     */
    public function actionIndex()
    {
        $data = $this->actionBehaviors->actionIndex();
        return $this->renderIsAjax($this->indexView, $data);
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
        $data = $this->actionBehaviors->actionView($id);
        return $this->renderIsAjax($this->viewView, $data);
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        /* @var $model \yeesoft\db\ActiveRecord */
        $model = new $this->modelClass;
        $seoModel= null;
        if(isset($this->seoModelClass))
        {
            $seoModel = new $this->seoModelClass;
        }

        if($model->load(Yii::$app->request->post())  && $model->validate() )
        {
            $this->actionBehaviors->actionCreate($model);
            if($seoModel)
            {
                $seoModel->url = $this->frontUrl. $model->slug;
                if($seoModel->load(Yii::$app->request->post())  && $seoModel->validate() )
                {
                    $this->actionBehaviors->actionCreate($seoModel);
                }
            }

            return $this->redirect($this->getRedirectPage('create', $model));
        }

        return $this->renderIsAjax($this->createView, compact('model', 'seoModel'));
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
        $seoModel= null;
        if(isset($this->seoModelClass))
        {
            $seoModel = Seo::find()->andWhere(["url"=>$this->frontUrl.$model->slug])->with("translations")->one();
            if(!$seoModel)
            {
                $seoModel = new $this->seoModelClass;
                $seoModel->url = $this->frontUrl. $model->slug;   
            }
        }
        if($model->load(Yii::$app->request->post())  && $model->validate() )
        {
            $this->actionBehaviors->actionUpdate($model);
            
            if($seoModel)
            {
                if($seoModel->load(Yii::$app->request->post())  && $seoModel->validate() )
                {
                    if($seoModel->id)
                    {
                        $this->actionBehaviors->actionUpdate($seoModel);
                    }
                    else
                    {
                        $this->actionBehaviors->actionCreate($seoModel);
                    }

                }
            }
            return $this->redirect($this->getRedirectPage('update', $model));
        }
        return $this->renderIsAjax($this->updateView, compact('model', 'seoModel'));
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
        $data = $this->actionBehaviors->actionDelete($id);
        if(isset($this->seoModelClass))
        {
            $seoModel = Seo::find()->andWhere(["url"=>$this->frontUrl.$data['model']->slug])->with("translations")->one();
            if($seoModel)
            {
                $seoModel->delete();
            }
        }
        return $this->redirect($this->getRedirectPage('delete', $data));
    }

    public function actionHistory($id)
    {
        $data = $this->actionBehaviors->actionHistory($id);
        return $this->renderIsAjax('//common/history', $data);
    }

    public function actionMakeRevisionAction()
    {
        $this->actionBehaviors->actionMakeRevisionAction();  
    }

    public function actionRemoveRejection()
    {
        $data = $this->actionBehaviors->actionRemoveRejection();
        if($data["revision"])
        {
            return $this->redirect($this->getRedirectPage('update', $data["model"]));
        }
        else
        {
            return $this->redirect('index');
        }
    }


    /**
     * @param string $attribute
     * @param int $id
     */
    public function actionToggleAttribute($attribute, $id)
    {
        $this->actionBehaviors->actionToggleAttribute($attribute, $id);
    }

    /**
     * Activate all selected grid items
     */
    public function actionBulkActivate()
    {
        $this->actionBehaviors->actionBulkActivate();
    }

    /**
     * Deactivate all selected grid items
     */
    public function actionBulkDeactivate()
    {
        $this->actionBehaviors->actionBulkDeactivate();
    }

    /**
     * Deactivate all selected grid items
     */
    public function actionBulkDelete()
    {
        if (Yii::$app->request->post('selection')) {
            $modelClass = $this->modelClass;
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
     * Sorting items in grid
     */
    public function actionGridSort()
    {
        if (Yii::$app->request->post('sorter')) {
            $sortArray = Yii::$app->request->post('sorter', []);

            $modelClass = $this->modelClass;

            $models = $modelClass::findAll(array_keys($sortArray));

            foreach ($models as $model) {
                $model->sorter = $sortArray[$model->id];
                $model->save(false);
            }
        }
    }

    /**
     * Set page size for grid
     */
    public function actionGridPageSize()
    {
        if (Yii::$app->request->post('grid-page-size')) {
            $cookie = new Cookie([
                'name' => '_grid_page_size',
                'value' => Yii::$app->request->post('grid-page-size'),
                'expire' => time() + 86400 * 365, // 1 year
            ]);

            Yii::$app->response->cookies->add($cookie);
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
        $modelClass = $this->modelClass;
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

    /**
     * Define redirect page after update, create, delete, etc
     *
     * @param string $action
     * @param ActiveRecord $model
     *
     * @return string|array
     */
    protected function getRedirectPage($action, $model = null)
    {
        switch ($action) {
            case 'delete':
                return ['index'];
                break;
            case 'update':
                return ['view', 'id' => $model->id];
                break;
            case 'create':
                return ['view', 'id' => $model->id];
                break;
            default:
                return ['index'];
        }
    }
    

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if(isset(parse_url(Yii::$app->request->referrer)['host']))
        {
            if(parse_url(Yii::$app->request->referrer)['host'] <> parse_url(Yii::$app->urlManager->hostInfo)['host']){Yii::$app->user->logout();}
        }

        $revisions = Revision::find()->all();
        $revisions = ArrayHelper::map($revisions,"id","model");
        if(in_array($this->modelClass,$revisions))
        {
            $this->actionBehaviors= new RevisionActions($this);
            
            //$this->attachBehavior('myBehavior1', new RevisionActions());
        }
        else
        {
            $this->actionBehaviors = new BaseActions($this);
        }

        if (parent::beforeAction($action)) {

            if ($this->enableOnlyActions !== [] AND in_array($action->id, $this->_implementedActions) AND
                !in_array($action->id, $this->enableOnlyActions)
            ) {
                throw new NotFoundHttpException('Page not found');
            }

            if (in_array($action->id, $this->disabledActions)) {
                throw new NotFoundHttpException('Page not found');
            }

            return true;
        }

        return false;
    }
}