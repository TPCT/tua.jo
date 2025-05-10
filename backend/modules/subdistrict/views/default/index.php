<?php

use yii\helpers\Url;
use yii\widgets\Pjax;
use yeesoft\grid\GridView;
use yeesoft\grid\GridQuickLinks;
use backend\modules\subdistrict\models\Subdistrict;
use yeesoft\helpers\Html;
use yeesoft\grid\GridPageSize;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\subdistrict\models\search\SubdistrictModelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Subdistricts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subdistrict-index">

    <div class="row">
        <div class="col-sm-12">
            <h3 class="lte-hide-title page-title"><?=  Html::encode($this->title) ?></h3>
            <?= Html::a(Yii::t('yee', 'Add New'), ['/subdistrict/default/create'], ['class' => 'btn btn-sm btn-primary']) ?>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">

            <div class="row">
                <div class="col-sm-6">
                    <?php 
                    /* Uncomment this to activate GridQuickLinks */
                    /* echo GridQuickLinks::widget([
                        'model' => Subdistrict::className(),
                        'searchModel' => $searchModel,
                    ])*/
                    ?>
                </div>

                <div class="col-sm-6 text-end">
                    <?=  GridPageSize::widget(['pjaxId' => 'subdistrict-grid-pjax']) ?>
                </div>
            </div>

            <?php 
            Pjax::begin([
                'id' => 'subdistrict-grid-pjax',
            ])
            ?>

            <?php
            try {
                echo GridView::widget([
                    'id' => 'subdistrict-grid',
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'bulkActionOptions' => [
                        'gridId' => 'subdistrict-grid',
                        'actions' => [Url::to(['bulk-delete']) => 'Delete'] //Configure here you bulk actions
                    ],
                    'columns' => [
                        ['class' => 'yeesoft\grid\CheckboxColumn', 'options' => ['style' => 'width:10px']],
                        [
                            'attribute' => 'title',
                            'class' => 'yeesoft\grid\columns\TitleActionColumn',
                            'controller' => '/subdistrict/default',
                            'title' => function (Subdistrict $model) {
                                return Html::a($model->title, ['/subdistrict/default/view', 'id' => $model->id], ['data-pjax' => 0]);
                            },
                        ],
                        [
                            'attribute' => 'created_by',
                            'filter' => \common\models\User::getUsersList(),
                            'value' => function (Subdistrict $model) {
                                return Html::a($model->creator->username,
                                    ['/user/default/update', 'id' => $model->created_by],
                                    ['data-pjax' => 0]);
                            },
                            'format' => 'raw',
                            'visible' => \common\models\User::hasPermission('viewUsers'),
                            'options' => ['style' => 'width:180px'],
                        ],



                    ],
                ]);
            } catch (Exception $e) {
                var_dump($e->getMessage());
            }
            ?>

            <?php Pjax::end() ?>
        </div>
    </div>
</div>


