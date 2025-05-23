<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model yeesoft\page\models\Page */

$this->title = Yii::t('yee', 'Update "{item}"', ['item' => $model->path]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('yee/page', 'Header Images'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->path, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('yee', 'Update');
?>

<div class="page-update">
    <h3 class="lte-hide-title"><?= Html::encode($this->title) ?></h3>
    <?= $this->render('_form', compact('model')) ?>
</div>


