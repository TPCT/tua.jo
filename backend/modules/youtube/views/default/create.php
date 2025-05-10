<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\youtube\models\YoutubeLinks */

$this->title = 'Create Video Gallery';
$this->params['breadcrumbs'][] = ['label' => 'Video Gallery', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="youtube-create">
    <h3 class="lte-hide-title"><?=  Html::encode($this->title) ?></h3>
    <?=  $this->render('_form', compact('model')) ?>
</div>