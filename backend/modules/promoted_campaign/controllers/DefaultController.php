<?php

namespace backend\modules\promoted_campaign\controllers;

use backend\modules\promoted_campaign\models\PromotedCampaign;
use Exception;
use yeesoft\seo\models\Seo;
use Yii;
use yeesoft\controllers\admin\BaseController;
use yii\helpers\ArrayHelper;

/**
 * DefaultController implements the CRUD actions for common\models\promoted_campaign model.
 */
class DefaultController extends BaseController 
{

    public $modelClass       = 'backend\modules\promoted_campaign\models\PromotedCampaign';
    public $modelSearchClass = 'backend\modules\promoted_campaign\models\search\PromotedCampaignSearch';

    
    
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

    public function actionUpdate($id)
    {
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
        if($model->load(Yii::$app->request->post())  && $model->validate() ) {
            if ($model->status) {
                Yii::$app->db->createCommand()
                    ->update('promoted_campaigns', ['status' => 0])
                    ->execute();
            }
            $this->actionBehaviors->actionUpdate($model);
            return $this->redirect($this->getRedirectPage('update', $model));
        }
        return $this->renderIsAjax($this->updateView, compact(['model', 'seoModel']));

    }
}