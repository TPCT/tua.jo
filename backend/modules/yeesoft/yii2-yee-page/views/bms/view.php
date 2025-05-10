<?php

use yeesoft\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \backend\modules\bms\models\Bms */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' =>Yii::t("site","Page"), 'url' => ["/{$this->context->module->id}"]];
$this->params['breadcrumbs'][] = ['label' => Yii::t('site', 'BMS'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-view">

    <h3 class="lte-hide-title"><?= Html::encode($this->title) ?></h3>

    <div class="panel panel-default">
        <div class="panel-body">
            <?= Html::a(Yii::t('site', 'Edit'), ["/{$this->context->module->id}/bms/update", 'id' => $model->id], ['class' => 'btn btn-sm btn-primary']) ?>
            <?= Html::a(Yii::t('site', 'Delete'), ["/{$this->context->module->id}/bms/delete", 'id' => $model->id], [
                'class' => 'btn btn-sm btn-default',
                'data' => [
                    'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]) ?>
            <?= Html::a(Yii::t('site', 'Add New'), ["/{$this->context->module->id}/bms/create"], ['class' => 'btn btn-sm btn-primary float-end']) ?>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">
            <h2><?= $model->title ?></h2>
        </div>
    </div>

</div>
