<?php

use yeesoft\grid\GridPageSize;
use yeesoft\grid\GridQuickLinks;
use yeesoft\grid\GridView;
use yeesoft\helpers\Html;
use yeesoft\models\User;
use yii\helpers\Url;
use yii\widgets\Pjax;
use backend\modules\bms\models\Bms;

/* @var $this yii\web\View */
/* @var $searchModel \backend\modules\bms\models\search\BmsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('site', 'BMS');
$this->params['breadcrumbs'][] = ['label' =>Yii::t("site","Page"), 'url' => ["/{$this->context->module->id}"]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-index">

    <div class="row">
        <div class="col-sm-12">
            <h3 class="lte-hide-title page-title"><?= Html::encode($this->title) ?></h3>
            <?= Html::a(Yii::t('site', 'Add New'), ["/{$this->context->module->id}/bms/create", 'module_id' => $module_id], ['class' => 'btn btn-sm btn-primary']) ?>
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
                        Url::to(['bulk-activate']) => Yii::t('site', 'Publish'),
                        Url::to(['bulk-deactivate']) => Yii::t('site', 'Unpublish'),
                        Url::to(['bulk-delete']) => Yii::t('yii', 'Delete'),
                    ]
                ],
                'columns' => [
                    ['class' => 'yeesoft\grid\CheckboxColumn', 'options' => ['style' => 'width:10px']],
                    [
                        'class' => 'yeesoft\grid\columns\TitleActionColumn',
                        'controller' => "/".$this->context->module->id."/bms",
                        'title' => function ($model) {
                            $changed = $model->getLabelChanged();
                            return Html::a($model->title, ["/{$this->context->module->id}/bms/view", 'id' => $model->id], ['data-pjax' => 0]) . $changed;
                        },
                        'buttonsTemplate' => '{view} {update} {delete} {revisions}',
                        'buttons' => [
                            'revisions' => function ($url, $model, $key) {
                                return $model->revisionButton();
                            },
                        ],
                    ],
                    [
                        'attribute' => 'category',
                        'value' => function (Bms $model) {
                            return( $model->category);
                        },

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
                        'value' => function (Bms $model) {
                            return '<span style="font-size:85%;" class="label label-'
                                . ((time() >= $model->published_at) ? 'primary' : 'default') . '">'
                                . $model->publishedDate . '</span>';
                        },
                        'format' => 'raw',
                        'options' => ['style' => 'width:150px'],
                    ],
                    [
                        'attribute' => 'created_by',
                        'filter' => User::getUsersList(),
                        'value' => function (Bms $model) {
                            return Html::a('admin',
                                ['/user/default/update', 'id' => $model->created_by],
                                ['data-pjax' => 0]);
                        },
                        'format' => 'raw',
                        'visible' => User::hasPermission('viewUsers'),
                        'options' => ['style' => 'width:180px'],
                    ],
                ],
            ]);
            ?>

            <?php Pjax::end() ?>
        </div>
    </div>
</div>


