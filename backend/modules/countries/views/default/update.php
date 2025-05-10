<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model yeesoft\page\models\Page */

$this->title = Yii::t('site', 'Update "{item}"', ['item' => $model->num_code]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('yee/page', 'COUNTRIES'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' =>$model->num_code, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('site', 'Update');
?>

<div class="page-update">
    <h3 class="lte-hide-title"><?= Html::encode($this->title) ?></h3>
    <?= $this->render('_form', compact('model')) ?>
</div>


