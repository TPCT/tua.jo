<?php

use yii\helpers\Url;
use yii\widgets\Pjax;
use yeesoft\grid\GridView;
use yeesoft\grid\GridQuickLinks;
use backend\modules\youtube\models\YoutubeLinks;
use common\helpers\Utility;
use yeesoft\helpers\Html;
use yeesoft\grid\GridPageSize;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Video Gallery';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="youtube-index">

    <div class="row">
        <div class="col-sm-12">
            <h3 class="lte-hide-title page-title"><?=  Html::encode($this->title) ?></h3>
            <?= Html::a(Yii::t('yee', 'Add New'), ["/{$this->context->module->id}/default/create"], ['class' => 'btn btn-sm btn-primary']) ?>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">

            <div class="row">
                <div class="col-sm-6">
                    <?php 
                    /* Uncomment this to activate GridQuickLinks */
                    /* echo GridQuickLinks::widget([
                        'model' => YoutubeLinks::className(),
                        'searchModel' => $searchModel,
                    ])*/
                    ?>
                </div>

                <div class="col-sm-6 text-end">
                    <?=  GridPageSize::widget(['pjaxId' => 'youtube-grid-pjax']) ?>
                </div>
            </div>

            <?php 
            Pjax::begin([
                'id' => 'youtube-grid-pjax',
            ])
            ?>

            <?= 
            GridView::widget([
                'id' => 'youtube-grid',
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                                'bulkActionOptions' => [
                    'gridId' => 'youtube-grid',
                    'actions' => [ Url::to(['bulk-delete']) => 'Delete'] //Configure here you bulk actions
                ],
                'columns' => [
                    ['class' => 'yeesoft\grid\CheckboxColumn', 'options' => ['style' => 'width:10px']],
                    [
                        'class' => 'yeesoft\grid\columns\TitleActionColumn',
                        'controller' => "/{$this->context->module->id}/default",
                        'title' => function(YoutubeLinks $model) {
                            $changed = $model->getLabelChanged();
                            
                            return Html::a($model->title, ["/" . $this->context->module->id . "/default/view", 'id' => $model->id], ['data-pjax' => 0]) . $changed;
                        },
                    ],

                    [
                        'attribute' => 'album_id',
                        'filter' => YoutubeLinks::getAlbumList(),
                        'value' => function (YoutubeLinks $model) {
                            return $model->album;
                        },

                    ],

                    [
                        'class' => 'yeesoft\grid\columns\StatusColumn',
                        'attribute' => 'status',
                        'optionsArray' => Utility::getStatusOptionsList(),
                        'options' => ['style' => 'width:60px'],
                    ],
                    [
                        'class' => 'yeesoft\grid\columns\DateFilterColumn',
                        'attribute' => 'published_at',
                        'value' => function (YoutubeLinks $model) {
                            return '<span style="font-size:85%;" class="label label-'
                                . ((time() >= $model->published_at) ? 'primary' : 'default') . '">'
                                . $model->publishedDate . '</span>';
                        },
                        'format' => 'raw',
                        'options' => ['style' => 'width:150px'],
                    ],

                    // 'created_at',
                    // 'updated_at',
                    // 'created_by',
                    // 'updated_by',

                ],
            ]);
            ?>

            <?php Pjax::end() ?>
        </div>
    </div>
</div>


