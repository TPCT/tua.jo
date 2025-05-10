<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\newsletter\models\NewsletterCampaign */

$this->title = 'Create Newsletter Campaign';
$this->params['breadcrumbs'][] = ['label' => 'Newsletter Campaigns', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="newsletter-campaign-create">
    <h3 class="lte-hide-title"><?=  Html::encode($this->title) ?></h3>
    <?=  $this->render('_form', compact('model')) ?>
</div>