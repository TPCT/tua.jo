<?php

namespace backend\modules\donation_programs\controllers;

use backend\modules\bms\models\BmsFeature;
use backend\modules\donation_programs\models\DonationProgramFeature;
use backend\modules\donation_programs\models\DonationProgramItem;
use backend\modules\donation_programs\models\DonationProgramParent;
use backend\modules\donation_programs\models\DonationProgramPromotion;
use backend\modules\donation_programs\models\DonationProgramTab;
use common\components\SaveDynamicFormControllerTrait;
use common\components\SaveInBetweenTableControllerTrait;
use common\components\SaveMorphTableControllerTrait;
use common\helpers\Utility;
use common\models\User;
use yeesoft\controllers\admin\BaseController;
use yeesoft\helpers\YeeHelper;
use yeesoft\models\OwnerAccess;
use yeesoft\seo\models\Seo;
use Yii;
use yii\data\ActiveDataProvider;
use yii\helpers\StringHelper;


/**
 * DefaultController implements the CRUD actions for common\models\donation model.
 */
class DefaultController extends BaseController
{
    use SaveDynamicFormControllerTrait;
    use SaveInBetweenTableControllerTrait;
    use SaveMorphTableControllerTrait;

    public $modelClass = 'backend\modules\donation_programs\models\DonationProgram';
    public $modelSearchClass = 'backend\modules\donation_programs\models\search\DonationProgramSearch';

    public $seoModelClass = 'yeesoft\seo\models\Seo';
    public $frontUrl= "/donation-programs/";
 
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

    public function actionCreate()
    {
        $model = new $this->modelClass;

        $model->TabsList = count($model->tabs) ? $model->tabs : [new DonationProgramTab()];
        $model->ParentsList = count($model->parents) ? $model->parents : [new DonationProgramParent(), new DonationProgramParent()];
        foreach ($model->ParentsList as $parent)
            $parent->ItemsList = count($parent->items) ? $parent->items : [new DonationProgramItem()];
        $model->ItemsList = count($model->items) ? $model->items : [new DonationProgramItem()];
        $model->FeaturesList = count($model->features) ? $model->features : [new DonationProgramFeature(), new DonationProgramFeature(), new DonationProgramFeature()];
        $model->PromotionsList = count($model->promotions) ? $model->promotions : [new DonationProgramPromotion()];

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
                $this->actionBehaviors->actionCreate($model);



                $data = Yii::$app->request->post();
                if(isset($data["DonationProgramTab"]))
                {
                    $tabs = $data["DonationProgramTab"];
                    $this->DynamicFormCreateUpdate($tabs,DonationProgramTab::className(),$model,"donation_program_id");
                }

                if(isset($data["DonationProgramPromotion"]))
                {
                    $tabs = $data["DonationProgramPromotion"];
                    $this->DynamicFormCreateUpdate($tabs,DonationProgramPromotion::className(),$model,"parent_id");
                }

                if(isset($data["DonationProgramParent"]))
                {
                    $tabs = $data["DonationProgramParent"];
                    $this->DynamicFormCreateUpdate($tabs,DonationProgramParent::className(),$model,"donation_program_id");
                }

                if(isset($data["DonationProgramItem"]))
                {
                    $model->refresh();
                    $tabs = $data["DonationProgramItem"];
                    foreach ($tabs as $index => $tab){
                        $tabs[$index]['parent_id'] = $model->parents[$tab['parent_index']]->id;
                        if (empty($tabs[$index]['donation_type_id']))
                            $tabs[$index]['donation_type_id'] = null;
                        if (empty($tabs[$index]['campaign_id']))
                            $tabs[$index]['campaign_id'] = null;
                        unset($tabs[$index]['parent_index']);
                    }
                    $this->DynamicFormCreateUpdate($tabs,DonationProgramItem::className(),$model,"donation_program_id");
                }

                if(isset($data["DonationProgramFeature"]))
                {
                    $tabs = $data["DonationProgramFeature"];
                    $this->DynamicFormCreateUpdate($tabs,DonationProgramFeature::className(),$model,"donation_program_id");
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
        return $this->renderIsAjax($this->createView, compact(['model', 'seoModel']) );

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

        $model->TabsList = count($model->tabs) ? $model->tabs : [new DonationProgramTab()];
        $model->ParentsList = count($model->parents) ? $model->parents : [new DonationProgramParent(), new DonationProgramParent()];
        foreach ($model->ParentsList as $parent)
            $parent->ItemsList = count($parent->items) ? $parent->items : [new DonationProgramItem()];
        $model->ItemsList = count($model->items) ? $model->items : [new DonationProgramItem()];
        $model->FeaturesList = count($model->features) ? $model->features : [new DonationProgramFeature(), new DonationProgramFeature(), new DonationProgramFeature()];
        $model->PromotionsList = count($model->promotions) ? $model->promotions : [new DonationProgramPromotion()];

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

                $data = Yii::$app->request->post();
                $this->deleteOldData($model->tabs,$data["DonationProgramTab"]??null,DonationProgramTab::class);
                if(isset($data["DonationProgramTab"]))
                {
                    $tabs = $data["DonationProgramTab"];
                    $this->DynamicFormCreateUpdate($tabs,DonationProgramTab::className(),$model,"donation_program_id");
                }

                $this->deleteOldData($model->promotions,$data["DonationProgramPromotion"]??null,DonationProgramPromotion::class);
                if(isset($data["DonationProgramPromotion"]))
                {
                    $tabs = $data["DonationProgramPromotion"];
                    $this->DynamicFormCreateUpdate($tabs,DonationProgramPromotion::className(),$model,"parent_id");
                }

                $this->deleteOldData($model->parents,$data["DonationProgramParent"]??null,DonationProgramParent::class);
                if(isset($data["DonationProgramParent"]))
                {
                    $tabs = $data["DonationProgramParent"];
                    $this->DynamicFormCreateUpdate($tabs,DonationProgramParent::className(),$model,"donation_program_id");
                }

                $this->deleteOldData($model->items,$data["DonationProgramItem"]??null,DonationProgramItem::class);
                if(isset($data["DonationProgramItem"]))
                {
                    $model->refresh();
                    $tabs = $data["DonationProgramItem"];
                    foreach ($tabs as $index => $tab){
                        $tabs[$index]['parent_id'] = $model->parents[$tab['parent_index']]->id;
                        if (empty($tabs[$index]['donation_type_id']))
                            $tabs[$index]['donation_type_id'] = null;
                        if (empty($tabs[$index]['campaign_id']))
                            $tabs[$index]['campaign_id'] = null;
                        unset($tabs[$index]['parent_index']);
                    }

                    $this->DynamicFormCreateUpdate($tabs,DonationProgramItem::className(),$model,"donation_program_id");
                }

                $this->deleteOldData($model->features,$data["DonationProgramFeature"]??null,DonationProgramFeature::class);
                if(isset($data["DonationProgramFeature"]))
                {
                    $tabs = $data["DonationProgramFeature"];
                    $this->DynamicFormCreateUpdate($tabs,DonationProgramFeature::className(),$model,"donation_program_id");
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
        return $this->renderIsAjax($this->updateView, compact(['model', 'seoModel']));

    }

}