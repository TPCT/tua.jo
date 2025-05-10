<?php

namespace backend\modules\header_image\controllers;

use Yii;
use yeesoft\controllers\admin\BaseController;


use backend\modules\header_image\models\HeaderImageFeatures;

use common\components\SaveDynamicFormControllerTrait;

use Exception;

/**
 * DefaultController implements the CRUD actions for common\models\News model.
 */
class DefaultController extends BaseController 
{
    use SaveDynamicFormControllerTrait;


    public $modelClass       = 'backend\modules\header_image\models\HeaderImage';
    public $modelSearchClass = 'backend\modules\header_image\models\search\HeaderImageSearch';

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


    public function actionCreate()
    {
        $model = new $this->modelClass;

        $model->headerImageList = count($model->headerimageFeatures) ? $model->headerimageFeatures : [new HeaderImageFeatures()];


        if($model->load(Yii::$app->request->post())  && $model->validate() )
        {

            $transaction = \Yii::$app->db->beginTransaction();
            try 
            {
                $this->actionBehaviors->actionCreate($model);

                

                $data = Yii::$app->request->post();
                if(isset($data["HeaderImageFeatures"]))
                {
                    $headerImageFeatures = $data["HeaderImageFeatures"];
                    $this->DynamicFormCreateUpdate($headerImageFeatures,HeaderImageFeatures::className(),$model,"header_image_id");
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

        $model->headerImageList = count($model->headerimageFeatures) ? $model->headerimageFeatures : [new HeaderImageFeatures()];

        if($model->load(Yii::$app->request->post())  && $model->validate() )
        {
            $transaction = \Yii::$app->db->beginTransaction();
            try 
            {
                $this->actionBehaviors->actionUpdate($model);
    
                $data = Yii::$app->request->post();
                $this->deleteOldData($model->headerimageFeatures,$data["HeaderImageFeatures"]??null,HeaderImageFeatures::class);
                if(isset($data["HeaderImageFeatures"]))
                {
                    $headerImageFeatures = $data["HeaderImageFeatures"];
                    $this->DynamicFormCreateUpdate($headerImageFeatures,HeaderImageFeatures::className(),$model,"header_image_id");
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