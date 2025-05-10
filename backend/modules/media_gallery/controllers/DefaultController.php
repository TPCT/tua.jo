<?php

namespace backend\modules\media_gallery\controllers;

use Yii;
use common\components\SaveMulitpleFilesControllerTrait;
use Exception;
use yeesoft\controllers\admin\BaseController;
use yeesoft\media\models\Media;
use yeesoft\media\models\MediaUpload;
use yeesoft\seo\models\Seo;

/**
 * DefaultController implements the CRUD actions for common\models\MediaGallery model.
 */
class DefaultController extends BaseController 
{
    use SaveMulitpleFilesControllerTrait;

    public $modelClass       = 'backend\modules\media_gallery\models\MediaGallery';
    public $modelSearchClass = 'backend\modules\media_gallery\models\search\MediaGallerySearch';
    public $seoModelClass = 'yeesoft\seo\models\Seo';
    public $frontUrl= "/photo-gallery/";

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

    public function actionUpdateMedia()
    {
        if (Yii::$app->request->isPost) {
            $data = Yii::$app->request->post();

            $mediaId = $data['media_id'];
            $title = $data['title_en'];
            $title_ar = $data['title_ar'];
            $description = $data['description_en'];
            $description_ar = $data['description_ar'];
            $published_date = $data['published_date'];
    
            $media = Media::find()->where(['id'=>$mediaId])->with('translations')->one();
            if ($media) {
                $media->title = $title;
                $media->title_ar = $title_ar;
                $media->description = $description;
                $media->description_ar = $description_ar;
                $media->published_at = $published_date;
   
                if ($media->save()) {
                    return json_encode(['status' => 'success']);
                } else {
                    return json_encode(['status' => 'error', 'message' => 'Failed to save media.']);
                }
            } else {
                return json_encode(['status' => 'error', 'message' => 'Media not found.']);
            }
        }
    
        return json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    }
    


}