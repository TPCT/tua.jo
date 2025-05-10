<?php

use yeesoft\grid\GridPageSize;
use yeesoft\grid\GridQuickLinks;
use yeesoft\grid\GridView;
use yeesoft\helpers\Html;
use yeesoft\models\User;
use yii\helpers\Url;
use yii\widgets\Pjax;
use backend\modules\recurring_items\models\RecurringItems;

/* @var $this yii\web\View */
/* @var $searchModel \backend\modules\news\models\search\BmsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('site', 'RecurringItems');
$this->params['breadcrumbs'][] = $this->title;
?>

<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-success alert-dismissable">
         <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
         <i class="icon fa fa-check"></i> <?= Yii::$app->session->getFlash('success') ?>
    </div>
<?php endif; ?>
<div class="page-index">
    <div class="row">
        <div class="col-sm-12">
            <h3 class="lte-hide-title page-title"><?= Html::encode($this->title) ?></h3>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">

            <div class="row">
                <div class="col-sm-6">
                    <?= GridQuickLinks::widget([
                        'model' => RecurringItems::className(),
                        'searchModel' => $searchModel,
                        'labels' => [
                            'all' => Yii::t('yee', 'All'),
                            'active' => Yii::t('yee', 'Published'),
                            'inactive' => Yii::t('yee', 'Pending'),
                        ],
                    ]) ?>
                </div>

                <div class="col-sm-6 text-end">
                    <?= GridPageSize::widget(['pjaxId' => 'page-grid-pjax']) ?>
                </div>
            </div>

            <?php Pjax::begin(['id' => 'page-grid-pjax']) ?>
            <?php
                $actions = [];
                $actions[Url::to(['bulk-activate'])] =  Yii::t('yee', 'Publish');
                $actions[Url::to(['bulk-deactivate'])] =  Yii::t('yee', 'Unpublish');
                $actions[Url::to(['bulk-delete'])] =  Yii::t('yee', 'Delete');
                
            ?>

            <?=
            GridView::widget([
                'id' => 'page-grid',
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'bulkActionOptions' => [
                    'gridId' => 'page-grid',
                    'actions' => $actions,
                ],
                'columns' => [
                    ['class' => 'yeesoft\grid\CheckboxColumn', 'options' => ['style' => 'width:10px']],
                    [
                        'class' => 'yeesoft\grid\columns\TitleActionColumn',
                        'controller' => "/".$this->context->module->id."/default",
                        'title' => function ($model) {
       
                            
                            return Html::a($model->name, ["/" . $this->context->module->id . "/default/view", 'id' => $model->id], ['data-pjax' => 0]) ;
                        },
                        'buttonsTemplate' => '{view}  {delete}',
          
                    ],
                    'email',
                    'phone',
                    'amount',
                    'frequency',
         
                    [
                        'class' => 'yeesoft\grid\columns\StatusColumn',
                        'attribute' => 'status',
                        'optionsArray' => \common\helpers\Utility::getStatusOptionsList(),
                        'options' => ['style' => 'width:60px'],
                    ],
            


             
                ],
            ]);
            ?>

            <?php Pjax::end() ?>
        </div>
    </div>
</div>


