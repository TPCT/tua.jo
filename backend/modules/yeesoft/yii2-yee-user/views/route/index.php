<?php

use yeesoft\grid\GridPageSize;
use yeesoft\grid\GridQuickLinks;
use yeesoft\grid\GridView;
use yeesoft\helpers\Html;
use yeesoft\models\Route;
use yeesoft\models\User;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel \backend\modules\merchant\models\search\DiscountProgramSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('site', 'Route');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-index">

    <div class="row">
        <div class="col-sm-12">
            <h3 class="lte-hide-title page-title"><?= Html::encode($this->title) ?></h3>
            <?= Html::a(Yii::t('yee', 'Add New'), ['/user/route/create'], ['class' => 'btn btn-sm btn-primary']) ?>
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
                    'actions' => []
                ],
                'columns' => [
                    ['class' => 'yeesoft\grid\CheckboxColumn', 'options' => ['style' => 'width:10px']],
                    [
                        'attribute' => 'title',
                        'class' => 'yeesoft\grid\columns\TitleActionColumn',
                        'controller' => '/user/route',
                        'title' => function (Route $model) {
                            return Html::a($model->name, ["/user/route/view", 'id' => $model->name], ['data-pjax' => 0]) ;
                        },
                        'buttonsTemplate' => '{view} {update} {delete}',
                        
                    ],

                    [
                        'attribute' => 'module',

                    ],

                    [
                        'attribute' => 'action',

                    ],
                ],
            ]);
            ?>

            <?php Pjax::end() ?>
        </div>
    </div>
</div>


