<?php

use yii\helpers\Url;
use yii\widgets\Pjax;
use yeesoft\grid\GridView;
use yeesoft\grid\GridQuickLinks;
use backend\modules\city\models\City;
use yeesoft\helpers\Html;
use yeesoft\grid\GridPageSize;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\city\models\search\CityModelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cities';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="city-index">

    <div class="row">
        <div class="col-sm-12">
            <h3 class="lte-hide-title page-title"><?=  Html::encode($this->title) ?></h3>
            <?= Html::a(Yii::t('yee', 'Add New'), ['/city/default/create'], ['class' => 'btn btn-sm btn-primary']) ?>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">

            <div class="row">
                <div class="col-sm-6">
                    <?php 
                    /* Uncomment this to activate GridQuickLinks */
                    /* echo GridQuickLinks::widget([
                        'model' => City::className(),
                        'searchModel' => $searchModel,
                    ])*/
                    ?>
                </div>

                <div class="col-sm-6 text-end
                    <?=  GridPageSize::widget(['pjaxId' => 'city-grid-pjax']) ?>
                </div>
            </div>

            <?php 
            Pjax::begin([
                'id' => 'city-grid-pjax',
            ])
            ?>

            <?php
            try {
                echo GridView::widget([
                    'id' => 'city-grid',
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'bulkActionOptions' => [
                        'gridId' => 'city-grid',
                        'actions' => [Url::to(['bulk-delete']) => 'Delete'] //Configure here you bulk actions
                    ],
                    'columns' => [
                        ['class' => 'yeesoft\grid\CheckboxColumn', 'options' => ['style' => 'width:10px']],
                        [
                            'attribute' => 'title',
                            'class' => 'yeesoft\grid\columns\TitleActionColumn',
                            'controller' => '/city/default',
                            'title' => function (City $model) {
                                return Html::a($model->title, ['/city/default/view', 'id' => $model->id], ['data-pjax' => 0]);
                            },
                        ],
                        [
                            'attribute' => 'created_by',
                            'filter' => \common\models\User::getUsersList(),
                            'value' => function (City $model) {
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
            }
            ?>

            <?php Pjax::end() ?>
        </div>
    </div>
</div>


