<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model yeesoft\page\models\Page */

$this->title = Yii::t('site', 'Update "{item}"', ['item' => date("d/m/Y",$model->published_at)]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('yee/page', 'Currency Price'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => date("d/m/Y",$model->published_at), 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('site', 'Update');
?>

<div class="page-update">
    <h3 class="lte-hide-title"><?= Html::encode($this->title) ?></h3>
    <?= $this->render('_form', compact('model')) ?>
</div>


