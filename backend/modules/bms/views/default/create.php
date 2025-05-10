<?php

use yii\helpers\Html;

/* @var $this yii\web\View */

$this->title = Yii::t('site', 'Create BMS');
$this->params['breadcrumbs'][] = ['label' => Yii::t('site', 'BMS'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-create">
    <h3 class="lte-hide-title"><?= Html::encode($this->title) ?></h3>
    <?= $this->render('_form', compact('model')) ?>
</div>
