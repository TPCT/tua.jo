<?php

use yeesoft\grid\GridPageSize;
use yeesoft\grid\GridQuickLinks;
use yeesoft\grid\GridView;
use yeesoft\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use backend\modules\dropdown_list\models\DropdownList;
use common\helpers\Utility;

/* @var $this yii\web\View */
/* @var $searchModel \backend\modules\dropdown_list\models\search\DropdownListSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */



$this->title = Yii::t('site', 'Dropdown List');
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="page-index">

    <div class="row">
        <div class="col-sm-12">
            <h3 class="lte-hide-title page-title"><?= Html::encode($this->title) ?></h3>
            <?= Html::a(Yii::t('site', 'Add New'), ["/{$this->context->module->id}/default/create"], ['class' => 'btn btn-sm btn-primary']) ?>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">

            <div class="row">
                <div class="col-sm-6">

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
                        'buttonsTemplate' => '{view} {update} {delete} {revisions} {linked-entities}',
                        'buttons' => [
                            'revisions' => function ($url, $model, $key) {
                                return $model->revisionButton();
                            },
                            'linked-entities' => function ($url, $model, $key) {
                                return Html::a(Yii::t('site', 'Linked Entities'),
                                    Url::to(['linked-entities', 'id' => $model->id]), [
                                        'title' => Yii::t('site', 'Linked Entities'),
                                        'data-pjax' => '0'
                                    ]
                                );
                            },
                        ],

                        'controller' => "/{$this->context->module->id}/default",
                        'title' => function (DropdownList $model) {
                            $changed = $model->getLabelChanged();
                            
                            return Html::a($model->title, ["/" . $this->context->module->id . "/default/view", 'id' => $model->id], ['data-pjax' => 0]) . $changed;
                        },
                    ],
                    [
                        'attribute' => 'category',
                        'filter' => DropdownList::getCategoryList(),
//                        'options' => ['style' => 'width:60px'],
                    ],
                    
                    [
                        'class' => 'yeesoft\grid\columns\StatusColumn',
                        'attribute' => 'status',
                        'optionsArray' => \common\helpers\Utility::getStatusOptionsList(),
                        'options' => ['style' => 'width:60px'],
                    ],
                    [
                        'class' => 'yeesoft\grid\columns\DateFilterColumn',
                        'attribute' => 'published_at',
                        'value' => function (DropdownList $model) {
                            return '<span style="font-size:85%;" class="label label-'
                                . ((time() >= $model->published_at) ? 'primary' : 'default') . '">'
                                . $model->publishedDate . '</span>';
                        },
                        'format' => 'raw',
                        'options' => ['style' => 'width:150px'],
                    ],
                ],
            ]);
            ?>

            <?php Pjax::end() ?>
        </div>
    </div>
</div>


