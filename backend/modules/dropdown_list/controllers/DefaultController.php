<?php

namespace backend\modules\dropdown_list\controllers;

use backend\modules\bms\models\Bms;
use backend\modules\dropdown_list\models\DropdownList;
use backend\modules\media_gallery\models\MediaGallery;
use backend\modules\news\models\News;
use backend\modules\youtube\models\YoutubeLinks;
use common\components\SaveMorphTableControllerTrait;
use Exception;
use yeesoft\controllers\admin\BaseController;
use yeesoft\models\Menu;
use Yii;
use yii\helpers\Url;


/**
 * DefaultController implements the CRUD actions for common\models\News model.
 */
class DefaultController extends BaseController
{
    use SaveMorphTableControllerTrait;

    public $disabledActions = [];
    public $modelClass = 'backend\modules\dropdown_list\models\DropdownList';
    public $modelSearchClass = 'backend\modules\dropdown_list\models\search\DropdownListSearch';
    

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
     * Updates an existing model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionLinkedEntities($id)
    {

        /* @var $model \yeesoft\db\ActiveRecord */
        $model = parent::findModel($id);

        if(!$model) $this->goHome();


        $menuItem = [];

        switch ($model->category) 
        {
            case DropdownList::BMS_CATEGORY:
                $menuItem = $this->getLinkedItems(Bms::className(),"category_slug",$model->slug,Yii::t('site', 'Bms'),"/bms/default/update");
            break;

            case DropdownList::MEDIA_CATEGORY:
                $menuItem = $this->getLinkedItems(MediaGallery::className(),"category_id",$model->id,Yii::t('site', 'Media Gallery'),"/media_gallery/default/update");
            break;

            case DropdownList::MEDIA_CATEGORY:
                $menuItem = $this->getLinkedItems(Menu::className(),"category_slug",$model->slug,Yii::t('site', 'Menu'),"/menu/default/update");
            break;
        }

        return $this->render('linked-entities', ['items' => $menuItem, 'model' => $model]);

    }

    private function getLinkedItems($targetModel,$targetModelColumnName,$dropdownValue,$sectionName,$targeModelUrl)
    {

        $items = [];
        $objs = $targetModel::find()->andWhere([$targetModelColumnName => $dropdownValue])->all();
        foreach ($objs as $obj) 
        {
            $items[] = [
                'section' => $sectionName,
                'label' => $obj->title,
                'url' => Url::to([$targeModelUrl, 'id' => $obj->id]),
            ];
        }

        //$menuItem[] = ['label' => 'News', 'items' => $items];
        return $items;

    }
    
    public function actionSubCategory($category)
    {
        $subCategories = DropdownList::find()->active()->andWhere(['category' => DropdownList::getParentCategory($category) ])->all();
        // var_dump($category);exit;
        $data['subCategories']= "<option value>Select Sub Category</option>";

        foreach($subCategories as $item){
            
            $data['subCategories'].= "<option value='".$item->id."'>".$item->title."</option>";
        }
        return json_encode($data,JSON_UNESCAPED_SLASHES);
    }



}