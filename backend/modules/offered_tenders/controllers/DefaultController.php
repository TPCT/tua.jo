<?php

namespace backend\modules\offered_tenders\controllers;

use Exception;
use Yii;
use yeesoft\media\models\MediaUpload;
use common\components\SaveMulitpleFilesControllerTrait;
use yeesoft\helpers\YeeHelper;
use common\models\User;
use yii\data\ActiveDataProvider;
use common\helpers\Utility;
use yeesoft\models\OwnerAccess;

use yii\helpers\StringHelper;
use yeesoft\controllers\admin\BaseController;
use yii\helpers\ArrayHelper;
use yeesoft\seo\models\Seo;

/**
 * DefaultController implements the CRUD actions for common\models\News model.
 */
class DefaultController extends BaseController 
{
    use SaveMulitpleFilesControllerTrait;

    public $modelClass       = 'backend\modules\offered_tenders\models\OfferedTenders';
    public $modelSearchClass = 'backend\modules\offered_tenders\models\search\OfferedTendersSearch';

    public $seoModelClass = 'yeesoft\seo\models\Seo';
    public $frontUrl= "/offer-tenders/";
    
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


    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new $this->modelClass;

        $seoModel= null;
        if(isset($this->seoModelClass))
        {
            $seoModel = new $this->seoModelClass;
        }


        if($model->load(Yii::$app->request->post())  && $model->validate() )
        {
            $transaction = \Yii::$app->db->beginTransaction();
            try
            {
                $this->actionBehaviors->actionCreate($model);
                $this->saveFiles($model,"multiple_files",false);
                if($seoModel)
                {
                    $seoModel->url = $this->frontUrl. $model->slug;
                    if($seoModel->load(Yii::$app->request->post())  && $seoModel->validate() )
                    {
                        $this->actionBehaviors->actionCreate($seoModel);
                    }
                }

                $transaction->commit();
            }
            catch (Exception $e)
            {
                $transaction->rollBack();
                // var_dump($e->getMessage());exit;
                error_log($e->getMessage());
            }


            return $this->redirect($this->getRedirectPage('create', $model));
        }
        return $this->renderIsAjax($this->updateView, compact(['model', 'seoModel']));

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
            $transaction = \Yii::$app->db->beginTransaction();
            try
            {
                $this->actionBehaviors->actionUpdate($model);
                $this->saveFiles($model,"multiple_files",false);
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

                $transaction->commit();
            }
            catch (Exception $e)
            {
                $transaction->rollBack();
                // var_dump($e->getMessage());exit;
                error_log($e->getMessage());
            }

            return $this->redirect($this->getRedirectPage('update', $model));
        }
        return $this->renderIsAjax($this->updateView, compact(['model', 'seoModel']));

    }


    public function actionDeleteFile($newsId, $imgId,$lng)
    {

        MediaUpload::deleteAll(['owner_class' => $this->modelClass,'owner_id' => $newsId, 'media_id' => $imgId,'language'=>$lng]);


        Yii::$app->session->setFlash('crudMessage', Yii::t('yee', 'Your item has been deleted.'));
        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionSaveAllAttributes()
    {
        $weights = Yii::$app->request->post('weights', []);
        $captionsEn = Yii::$app->request->post('captionsEn', []);
        $captionsAr = Yii::$app->request->post('captionsAr', []);
        $objectFit = Yii::$app->request->post('objectFit', []);
        $objectPosition = Yii::$app->request->post('objectPosition', []);

        foreach ($weights as $mediaId => $weight) {
            $media = MediaUpload::findOne($mediaId);
            if ($media) {
                $media->weight = (int)$weight;
                $media->caption_en = $captionsEn[$mediaId] ?? $media->caption_en;
                $media->caption_ar = $captionsAr[$mediaId] ?? $media->caption_ar;
                $media->object_fit = $objectFit[$mediaId] ?? $media->object_fit;
                $media->object_position = $objectPosition[$mediaId] ?? $media->object_position;
                if(!$media->save()) {
                    return $this->asJson(['error' => $media->getErrors()]);
                }
            }
        }

        return $this->asJson(['success' => true]);
    }


}