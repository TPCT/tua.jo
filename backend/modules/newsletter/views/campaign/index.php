<?php

use yii\helpers\Url;
use yii\widgets\Pjax;
use yeesoft\grid\GridView;
use yeesoft\grid\GridQuickLinks;
use backend\modules\newsletter\models\NewsletterCampaign;
use yeesoft\helpers\Html;
use yeesoft\grid\GridPageSize;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\newsletter\models\search\NewsletterCampaignSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Newsletter Campaigns';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="newsletter-campaign-index">

    <div class="row">
        <div class="col-sm-12">
            <h3 class="lte-hide-title page-title"><?= Html::encode($this->title) ?></h3>
            <?= Html::a(Yii::t('yee', 'Add New'), ['/newsletter/campaign/create'], ['class' => 'btn btn-sm btn-primary']) ?>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">

            <div class="row">
                <div class="col-sm-6">
                    <?php
                    /* Uncomment this to activate GridQuickLinks */
                    /* echo GridQuickLinks::widget([
                        'model' => NewsletterCampaign::className(),
                        'searchModel' => $searchModel,
                    ])*/
                    ?>
                </div>

                <div class="col-sm-6 text-end">
                    <?= GridPageSize::widget(['pjaxId' => 'newsletter-campaign-grid-pjax']) ?>
                </div>
            </div>

            <?php
            Pjax::begin([
                'id' => 'newsletter-campaign-grid-pjax',
            ])
            ?>

            <?=
            GridView::widget([
                'id' => 'newsletter-campaign-grid',
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'bulkActionOptions' => [
                    'gridId' => 'newsletter-campaign-grid',
                    'actions' => [Url::to(['bulk-delete']) => 'Delete'] //Configure here you bulk actions
                ],
                'columns' => [
                    ['class' => 'yeesoft\grid\CheckboxColumn', 'options' => ['style' => 'width:10px']],
                    [
                        'class' => 'yeesoft\grid\columns\TitleActionColumn',
                        'attribute' => 'subject',
                        'controller' => '/newsletter/campaign',
                        'title' => function (NewsletterCampaign $model) {
                            return Html::a($model->subject, ['view', 'id' => $model->id], ['data-pjax' => 0]);
                        },
                    ],
                    [
                        'attribute' => 'start_date',
                        'filter' => false,
                    ]

                ],
            ]);
            ?>

            <?php Pjax::end() ?>
        </div>
    </div>
</div>


