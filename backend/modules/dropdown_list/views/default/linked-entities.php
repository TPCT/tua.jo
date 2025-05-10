<?php

/**
 * Created by PhpStorm.
 * User: ajoudeh
 * Date: 20/06/2021
 * Time: 11:31 PM
 */

/* @var $this \yii\web\View */
?>




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

    <div class="panel panel-default">
        <div class="panel-body">
            <?= Html::a(Yii::t('site', 'Edit'), ["/{$this->context->module->id}/default/update", 'id' => $model->id], ['class' => 'btn btn-sm btn-primary']) ?>
            <?= Html::a(Yii::t('site', 'Delete'), ["/{$this->context->module->id}/default/delete", 'id' => $model->id], [
                'class' => 'btn btn-sm btn-default',
                'data' => [
                    'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]) ?>
            <?= Html::a(Yii::t('site', 'Add New'), ["/{$this->context->module->id}/default/create"], ['class' => 'btn btn-sm btn-primary float-end']) ?>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">

            <?php

            try {
                echo \yii\bootstrap5\Nav::widget([
                    'items' => $items,
                ]);

            } 
            catch (Exception $e) 
            {
                error_log($e->getMessage());
            }

            ?>
        </div>
    </div>

</div>






