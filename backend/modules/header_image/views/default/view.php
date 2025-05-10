<?php

use yeesoft\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \backend\modules\header_image\models\HeaderImage */

$this->title = $model->path;
$this->params['breadcrumbs'][] = ['label' => Yii::t('site', 'Header Image'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-view">

    <h3 class="lte-hide-title"><?= Html::encode($this->title) ?></h3>

    <div class="panel panel-default">
        <div class="panel-body">
            <?= Html::a(Yii::t('yee', 'Edit'), ['/header_image/default/update', 'id' => $model->id], ['class' => 'btn btn-sm btn-primary']) ?>
            <?= Html::a(Yii::t('yee', 'Delete'), ['/header_image/default/delete', 'id' => $model->id], [
                'class' => 'btn btn-sm btn-default',
                'data' => [
                    'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]) ?>
            <?= Html::a(Yii::t('yee', 'Add New'), ['/header_image/default/create'], ['class' => 'btn btn-sm btn-primary float-end']) ?>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">
            <h2><?= $model->path ?></h2>
        </div>
    </div>

</div>
