<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\newsletter\models\NewsletterClientList */

$this->title = 'Create Newsletter Client List';
$this->params['breadcrumbs'][] = ['label' => 'Newsletter Client Lists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="newsletter-create">
    <h3 class="lte-hide-title"><?=  Html::encode($this->title) ?></h3>
    <?=  $this->render('_form', compact('model')) ?>
</div>