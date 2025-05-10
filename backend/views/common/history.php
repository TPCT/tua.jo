<?php

use yeesoft\grid\GridPageSize;
use yeesoft\grid\GridQuickLinks;
use yeesoft\grid\GridView;
use yeesoft\helpers\Html;
use yeesoft\models\User;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $model->title?? $model->revisionTitle;
$this->params['breadcrumbs'][] = ['label' => $label, 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-success alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        <i class="icon fa fa-check"></i> <?= Yii::$app->session->getFlash('success') ?>
    </div>
<?php endif; ?>

<div class="page-index">


    <div class="panel panel-default">
        <div class="panel-body">


            <?php Pjax::begin(['id' => 'page-grid-pjax']) ?>

            <?=
            GridView::widget([
                'id' => 'page-grid',
                'dataProvider' => $dataProvider,
                'filterModel' =>  isset($searchModel) ? $searchModel : null,
                'bulkActionOptions' => [
                    'gridId' => 'page-grid',
                ],
                'columns' => [
                    ['class' => 'yeesoft\grid\CheckboxColumn', 'options' => ['style' => 'width:10px']],
                    [
                        'class' => 'yeesoft\grid\columns\TitleActionColumn',
                        'controller' => "/" . $this->context->module->id . "/" .Yii::$app->controller->id,
                        'title' => function ($model) {
                            $changed = $model->getLabelChanged();
                            
                            return Html::a($model->title?? $model->revisionTitle, ["/" . $this->context->module->id . "/" .Yii::$app->controller->id."/view", 'id' => $model->id], ['data-pjax' => 0]) . $changed;
                        },
                        'buttonsTemplate' => '{view} {update} {delete}',
                        
                    ],
                    [
                        'class' => 'yeesoft\grid\columns\StatusColumn',
                        'attribute' => 'status',
                        'optionsArray' => $modelClass::getStatusOptionsList(),
                        'options' => ['style' => 'width:60px'],
                    ],
                    [
                        'class' => 'yeesoft\grid\columns\DateFilterColumn',
                        'attribute' => 'published_at',
                        'value' => function ($model) {
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


