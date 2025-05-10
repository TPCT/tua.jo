<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model yeesoft\media\models\Album */

$this->title = Yii::t('yee', 'Update {item}', ['item' => Yii::t('yee/media', 'Album')]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('yee/media', 'Media'), 'url' => ['/media/default/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('yee/media', 'Albums'), 'url' => ['/media/album/index']];
$this->params['breadcrumbs'][] = Yii::t('yee', 'Update');
?>
<div class="album-update">
    <h3 class="lte-hide-title"><?= Html::encode($this->title) ?></h3>
    <?= $this->render('_form', compact('model')) ?>
</div>

<!-- <div class="panel panel-default">
    <div class="panel-body">
        <?php
            // if (Yii::$app->getRequest()->getQueryParam('parent_id')) {
            //     echo $model->getDiffHtml(array_keys($model->attributeLabels()));
            // } else {
            //     echo "<h3>$model->title</h3> ";
            // }
        ?>
    </div>
</div> -->