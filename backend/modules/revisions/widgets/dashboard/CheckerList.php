<?php

namespace backend\modules\revisions\widgets\dashboard;


use yeesoft\widgets\DashboardWidget;
use Yii;
use yii\data\ArrayDataProvider;
use yii\helpers\Url;
use backend\modules\revisions\models\Revision;

class CheckerList extends DashboardWidget
{
    /**
     * Most recent post limit
     */
    public $recentLimit = 5;

    /**
     * Post index action
     */
    public $indexAction = 'user/default/index';

    /**
     * Total count options
     *
     * @var array
     */
    public $options;

    public $viewName;

    public function run()
    {
        if (!$this->options) {
            //$this->options = $this->getDefaultOptions();
        }

        $items = [];

        
        //$items = $this->reviewAll(Revision::getRevisionModelList());
        $model = new Revision();
        $params = Yii::$app->request->post();
        if($params)
        {
            $revisions = Revision::find()->andWhere(["model"=>$params["Revision"]["model"]])->all();
        }
        else
        {
            $revisions = Revision::find()->all();
        }
        $items = $this->reviewAll($revisions);


        $dataProvider = new ArrayDataProvider([
            'allModels' => $items,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('checker-list', [
            'dataProvider' => $dataProvider,
            'width' => $this->width,
            'position' => $this->position,
            'height' => $this->height,
            'model'=>$model]);


    }

    private function reviewAll($revision_models)
    {
        $items = [];
        // foreach($revision_models as $key => $item)
        // {
            
        //     $names = explode("\\",$item);
        //     // if($names[0] == "yeesoft")
        //     // {
        //     //     $moduleName = $names[1];
        //     // }
        //     // else
        //     // {
        //     //     $moduleName = $names[2];
        //     // }
        //     $model_name = end($names);
        //     $models = $item::find()->getChanged()->all();
        //     foreach ($models as $model) 
        //     {
        //         $url = Url::to(["/revisions", 'parent_id' => $model->id, 'type' => $key,'revision'=>$model->revision ]);
        //         $items[] = [
        //             'section' => Yii::t('site', $model_name),
        //             'title' => $model->title,
        //             'url' => $url,
        //         ];
        //     }
        // }

        foreach($revision_models as $item)
        {
            $names = explode("\\",$item->model);
            // if($names[0] == "yeesoft")
            // {
            //     $moduleName = $names[1];
            // }
            // else
            // {
            //     $moduleName = $names[2];
            // }
            $model_name = end($names);
            $models = $item->model::find()->getChanged()->all();
            foreach ($models as $model) 
            {
                $url = Url::to(["/revisions/default/index-old", 'parent_id' => $model->id, 'type' => Revision::getAllActiveModlesandModuleKey()[$item->model],'revision'=>$model->revision,'revision_id'=>$item->id ]);
                $items[] = [
                    'section' => Yii::t('site', $model_name),
                    'title' => $model->title,
                    'url' => $url,
                ];
            }
        }
        
        return $items;
    }


}