<?php

use yeesoft\grid\GridPageSize;
use yeesoft\grid\GridView;
use yeesoft\helpers\Html;
use yeesoft\models\User;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */


$this->title = Yii::t('site', 'Revision');
$this->params['breadcrumbs'][] = $this->title;
$this->params['type'] = $type;


?>

<?php if ($type == 'menu'): ?>
    


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
                    </div>

                    <div class="col-sm-6 text-end">
                        <?= GridPageSize::widget(['pjaxId' => 'page-grid-pjax']) ?>
                    </div>
                </div>
                <?php Pjax::begin(['id' => 'page-grid-pjax']) ?>    
                <?=
                GridView::widget([
                    'id' => 'page-grid',
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'bulkActionOptions' => [
                        'gridId' => 'page-grid',
                        'actions' => [
                            Url::to(['bulk-activate']) => Yii::t('yee', 'Publish'),
                            Url::to(['bulk-deactivate']) => Yii::t('yee', 'Unpublish'),
                            Url::to(['bulk-delete']) => Yii::t('yii', 'Delete'),
                        ]
                    ],
                    'columns' => [
                        [
                            'class' => 'yeesoft\grid\columns\TitleActionColumn',
                            'controller' => '/revisions/default',
                            'title' => function ($model) {
                                return Html::a($model->label, ["/menu/link/update", 'id' => $model->id, 'parent_id' => $model->revision, 'type' => $this->params['type']], ['data-pjax' => 0]);
                            },
                            'buttonsTemplate' => '{viewCurrent} {Approved}',
                            // 'buttonsTemplate' => '',
                            'buttons' => [
                                'viewCurrent' => function ($url, $model, $key) {
                                    return Html::a(Yii::t('site', 'View Current'),
                                        Url::to(["/menu/link/update", 'id' => $model->revision]), [
                                            'title' => Yii::t('site', 'View Current'),
                                            'data-pjax' => '0'
                                        ]
                                    );
                                },
                                'Approved' => function ($url, $model, $key) {
                                    return Html::a(Yii::t('site', 'Approved'),
                                        Url::to(["/menu/link/make-revision-action", 'revision' => $model->revision, 'id' => $model->id]), [
                                            'title' => Yii::t('site', 'Approved'),
                                            'data-pjax' => '0'
                                        ]
                                    );
                                },
                            ],
                        ],
                        // [
                        //     'attribute' => 'created_by',
                        //     'filter' => User::getUsersList(),
                        //     'value' => function ($model) {
                        //         return Html::a($model->creator->username, ["/user"], ['data-pjax' => 0]);

                        //     },
                        //     'format' => 'raw',
                        //     'visible' => User::hasPermission('viewUsers'),
                        //     'options' => ['style' => 'width:180px'],
                        // ],

                        // [
                        //     'class' => 'yeesoft\grid\columns\StatusColumn',
                        //     'attribute' => 'status',
                        //     'optionsArray' => Revision::getStatusOptionsList(),
                        //     'options' => ['style' => 'width:60px'],
                        // ],
                    ],
                ]);
                ?>

                <?php Pjax::end() ?>
            </div>
        </div>
    </div>

<?php else: ?>


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
                </div>

                <div class="col-sm-6 text-end">
                    <?= GridPageSize::widget(['pjaxId' => 'page-grid-pjax']) ?>
                </div>
            </div>
            <?php Pjax::begin(['id' => 'page-grid-pjax']) ?>    
            <?=
            GridView::widget([
                'id' => 'page-grid',
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'bulkActionOptions' => [
                    'gridId' => 'page-grid',
                    'actions' => [''=>''
                    ]
                ],
                'columns' => [
                    [
                        'class' => 'yeesoft\grid\columns\TitleActionColumn',
                        'controller' => '/revisions/default',
                        'title' => function ($model) {
                            return Html::a($model->title, ["/{$this->params['type']}/default/view", 'id' => $model->id, 'parent_id' => $model->revision, 'type' => $this->params['type']], ['data-pjax' => 0]);
                        },
                        // 'buttonsTemplate' => '{viewCurrent}',
                        'buttonsTemplate' => '',
                        'buttons' => [
                            'viewCurrent' => function ($url, $model, $key) {
                                return Html::a(Yii::t('site', 'View Current'),
                                    Url::to(["/{$this->params['type']}/default/view", 'id' => $model->revision]), [
                                        'title' => Yii::t('site', 'View Current'),
                                        'data-pjax' => '0'
                                    ]
                                );
                            },
                        ],
                    ],
                    [
                        'attribute' => 'created_by',
                        'filter' => User::getUsersList(),
                        'value' => function ($model) {
                            return Html::a($model->creator->username, ["/user"], ['data-pjax' => 0]);

                        },
                        'format' => 'raw',
                        'visible' => User::hasPermission('viewUsers'),
                        'options' => ['style' => 'width:180px'],
                    ],

                    [
                        'attribute' => 'updated_at',
                        'value' => function ($model) {
                            return '<span style="font-size:85%;" class="label label-'
                            . ((time() >= $model->updated_at) ? 'primary' : 'default') . '">'
                            . $model->updatedDate . ' - ' . $model->updatedTime . '</span>';
                        },
                        'format' => 'raw',
                        'options' => ['style' => 'width:150px'],
                    ],

                    [
                        'attribute' => 'reject_note',
                        'options' => ['style' => 'width:150px'],
                    ],
                    // [
                    //     'class' => 'yeesoft\grid\columns\StatusColumn',
                    //     'attribute' => 'status',
                    //     'optionsArray' => Revision::getStatusOptionsList(),
                    //     'options' => ['style' => 'width:60px'],
                    // ],
                ],
            ]);
            ?>

            <?php Pjax::end() ?>
        </div>
    </div>
</div>


<?php endif ?>
