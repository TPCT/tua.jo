<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \backend\modules\revisions\models\Revision */

$this->title = Yii::t('yee', 'Update "{item}"', ['item' => $model->model]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('site', 'Revision'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->model, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('yee', 'Update');
?>

<div class="page-update">
    <h3 class="lte-hide-title"><?= Html::encode($this->title) ?></h3>
    <?= $this->render('_form', compact('model')) ?>
</div>


