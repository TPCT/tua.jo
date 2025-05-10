<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\subdistrict\models\Subdistrict */

$this->title = 'Create Subdistrict';
$this->params['breadcrumbs'][] = ['label' => 'Subdistricts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="subdistrict-create">
    <h3 class="lte-hide-title"><?=  Html::encode($this->title) ?></h3>
    <?=  $this->render('_form', compact('model')) ?>
</div>