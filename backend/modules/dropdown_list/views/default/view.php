<?php

use yeesoft\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \backend\modules\dropdown_list\models\DropdownList */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('site', 'Dropdown List'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-view">

    <h3 class="lte-hide-title"><?= Html::encode($this->title) ?></h3>

    <?=
        $this->render('//common/_view-with-revision-panel', ["model"=>$model,"with_preview"=>false,"front_url"=>$this->context->module->id]);
    ?>

    <div class="panel panel-default">
        <div class="panel-body">
            <h2><?= $model->title ?></h2>
        </div>
    </div>

</div>
