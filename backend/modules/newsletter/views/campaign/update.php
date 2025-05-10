<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\newsletter\models\NewsletterCampaign */

$this->title = 'Update Newsletter Campaign: ' . ' ' . $model->subject;
$this->params['breadcrumbs'][] = ['label' => 'Newsletter Campaigns', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->subject, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="newsletter-campaign-update">
    <h3 class="lte-hide-title"><?= Html::encode($this->title) ?></h3>
    <?= $this->render('_form', compact('model')) ?>
</div>