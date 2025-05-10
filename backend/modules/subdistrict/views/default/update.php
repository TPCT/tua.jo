<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\subdistrict\models\Subdistrict */

$this->title = 'Update Subdistrict: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Subdistricts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="subdistrict-update">
    <h3 class="lte-hide-title"><?= Html::encode($this->title) ?></h3>
    <?= $this->render('_form', compact('model')) ?>
</div>