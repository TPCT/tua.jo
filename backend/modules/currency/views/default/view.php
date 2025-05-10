<?php

use yeesoft\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \backend\modules\currency\models\Currency */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('site', 'Currency'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>



<div class="page-view">

    <h3 class="lte-hide-title"><?= Html::encode($this->title) ?></h3>


</div>

