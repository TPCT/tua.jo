<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\youtube\models\YoutubeLinks */

$this->title = 'Update Video Gallery: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Video Gallery', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="youtube-update">
    <h3 class="lte-hide-title"><?= Html::encode($this->title) ?></h3>
    <?= $this->render('_form', compact('model')) ?>
</div>