<?php

use kartik\form\ActiveForm;
use yeesoft\helpers\Html;
use yeesoft\media\models\Media;

/* @var $this yii\web\View */
/* @var $model yeesoft\page\models\Page */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('yee/page', 'Pages'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="page-view">

    <h3 class="lte-hide-title"><?= Html::encode($this->title) ?></h3>

    <?=
        $this->render('//common/_view-with-revision-panel', ["model"=>$model,"with_preview"=>true,"front_url"=>"/site"]);
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