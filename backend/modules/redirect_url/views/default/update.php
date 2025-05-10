<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model yeesoft\page\models\Page */

$this->title = Yii::t('site', 'Update "{item}"', ['item' => $model->url_from]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('site', 'Redirect Url'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->url_from, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('site', 'Update');
?>

<div class="page-update">
    <h3 class="lte-hide-title"><?= Html::encode($this->title) ?></h3>
    <?= $this->render('_form', compact('model')) ?>
</div>


