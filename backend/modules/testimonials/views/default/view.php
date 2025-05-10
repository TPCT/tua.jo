<?php

use yeesoft\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \backend\modules\news\models\News */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('site', 'News'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>



<div class="page-view">

    <h3 class="lte-hide-title"><?= Html::encode($this->title) ?></h3>

    <?=
        $this->render('//common/_view-with-revision-panel', ["model"=>$model,"with_preview"=>false,"front_url"=>$this->context->module->id]);
    ?>

    <div class="panel panel-default">
        <div class="panel-body">
            <?php
                if (Yii::$app->getRequest()->getQueryParam('parent_id')) {
                    echo $model->getDiffHtml();
                } else {
                    echo "<h3>$model->title</h3> <br> $model->brief";
                }
            ?>
        </div>
    </div>

</div>

