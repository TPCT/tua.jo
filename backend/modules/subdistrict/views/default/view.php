<?php

use yii\widgets\DetailView;
use yeesoft\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\subdistrict\models\Subdistrict */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Subdistricts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subdistrict-view">

    <h3 class="lte-hide-title"><?=  Html::encode($this->title) ?></h3>

    <div class="panel panel-default">
        <div class="panel-body">

            <p>
                <?=                 Html::a('Edit', ['/subdistrict/default/update', 'id' => $model->id],
                    ['class' => 'btn btn-sm btn-primary'])
                ?>
                <?=                 Html::a('Delete', ['/subdistrict/default/delete', 'id' => $model->id],
                    [
                    'class' => 'btn btn-sm btn-default',
                    'data' => [
                        'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                        'method' => 'post',
                    ],
                ])
                ?>
                <?=                 Html::a(Yii::t('yee', 'Add New'), ['/subdistrict/default/create'],
                    ['class' => 'btn btn-sm btn-primary float-end'])
                ?>
            </p>


            <?=             DetailView::widget([
                'model' => $model,
                'attributes' => [
            'id',
            'slug',
            'status',
            'created_at',
            'updated_at',
                ],
            ])
            ?>

        </div>
    </div>

</div>
