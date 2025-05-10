<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \backend\modules\merchant\models\Merchant */

$this->title = Yii::t('yee', 'Update "{item}"', ['item' => $model->name]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('yee/page', 'Route'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->name]];
$this->params['breadcrumbs'][] = Yii::t('yee', 'Update');
?>

<div class="page-update">
    <h3 class="lte-hide-title"><?= Html::encode($this->title) ?></h3>
    <?= $this->render('_form', compact('model')) ?>
</div>


