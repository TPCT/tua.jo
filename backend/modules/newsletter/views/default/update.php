<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\newsletter\models\NewsletterClientList */

$this->title = 'Update Newsletter Client List: ' . ' ' . $model->email;
$this->params['breadcrumbs'][] = ['label' => 'Newsletter Client Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->email, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="newsletter-update">
    <h3 class="lte-hide-title"><?= Html::encode($this->title) ?></h3>
    <?= $this->render('_form', compact('model')) ?>
</div>