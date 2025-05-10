<?php

use dosamigos\google\maps\LatLng;
use dosamigos\google\maps\Map;
use dosamigos\google\maps\overlays\Marker;
use yeesoft\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('site', 'Route'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-view">

    <h3 class="lte-hide-title"><?= Html::encode($this->title) ?></h3>

    <div class="panel panel-default">
        <div class="panel-body">

            <?= Html::a(Yii::t('yee', 'Edit'), Url::to(['/user/route/update', 'id' => $model->name]), ['class' => 'btn btn-sm btn-primary']) ?>
            <?= Html::a(Yii::t('yee', 'Delete'), ['/user/route/delete', 'id' => $model->name], [
                'class' => 'btn btn-sm btn-danger',
                'data' => [
                    'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]) ?>

            <div class="float-end"> 
                
                <?php if (!Yii::$app->getRequest()->getQueryParam('parent_id')): ?>
                    
                    <?= Html::a(Yii::t('yee', 'Add New'), ['/user/route/create'], ['class' => 'btn btn-sm btn-primary']) ?>
                    
                <?php endif?>
                
            </div>

        </div>
    </div>
    
    <div class="panel panel-default">
        <div class="panel-body">
            <?php
                echo "<h3>$model->name</h3> ";
                
            ?>
        </div>
    </div>

</div>
