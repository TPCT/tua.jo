<?php

use yii\helpers\Url;
use yii\widgets\Pjax;
use yeesoft\grid\GridView;
use yeesoft\grid\GridQuickLinks;
use backend\modules\newsletter\models\NewsletterClientList;
use yeesoft\helpers\Html;
use yeesoft\grid\GridPageSize;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\newsletter\models\search\NewsletterClientListSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Newsletter Client Lists';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="newsletter-index">

    <div class="row">
        <div class="col-sm-12">
            <h3 class="lte-hide-title page-title"><?=  Html::encode($this->title) ?></h3>
            <?= Html::a(Yii::t('yee', 'Add New Email'), ['/newsletter/default/create'], ['class' => 'btn btn-sm btn-primary']) ?>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">

            <div class="row">
                <div class="col-sm-6">
                    <?php 
                    /* Uncomment this to activate GridQuickLinks */
                    /* echo GridQuickLinks::widget([
                        'model' => NewsletterClientList::className(),
                        'searchModel' => $searchModel,
                    ])*/
                    ?>
                </div>

                <div class="col-sm-6 text-end">
                    <?=  GridPageSize::widget(['pjaxId' => 'newsletter-grid-pjax']) ?>
                </div>
            </div>

            <?php 
            Pjax::begin([
                'id' => 'newsletter-grid-pjax',
            ])
            ?>

            <?= 
            GridView::widget([
                'id' => 'newsletter-grid',
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'bulkActionOptions' => [
                    'gridId' => 'newsletter-grid',
                    'actions' => [ Url::to(['bulk-delete']) => 'Delete'] //Configure here you bulk actions
                ],
                'columns' => [
                    ['class' => 'yeesoft\grid\CheckboxColumn', 'options' => ['style' => 'width:10px']],
                    [
                        'class' => 'yeesoft\grid\columns\TitleActionColumn',
                        'controller' => '/newsletter/default',
                        'title' => function(NewsletterClientList $model) {
                            return Html::a($model->email, ['view', 'id' => $model->id], ['data-pjax' => 0]);
                        },
                    ],

            'email:email',
           'phone',
//            'city_id',

                ],
            ]);
            ?>

            <?php Pjax::end() ?>
        </div>
    </div>
</div>


