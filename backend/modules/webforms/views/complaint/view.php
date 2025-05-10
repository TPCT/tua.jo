<?php

use yii\widgets\DetailView;
use yeesoft\helpers\Html;
use common\components\TuaClient;

/* @var $this yii\web\View */
/* @var $model backend\modules\webforms\models\ComplaintsWebform */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Complaint  Webforms', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contact_us-webform-view">

    <h3 class="lte-hide-title"><?= Html::encode($this->title) ?></h3>

    <div class="panel panel-default">
        <div class="panel-body">

            <p>
                <?= Html::a(
                    'Delete',
                    ['/webforms/complaint/delete', 'id' => $model->id],
                    [
                        'class' => 'btn btn-sm btn-default',
                        'data' => [
                            'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                            'method' => 'post',
                        ],
                    ]
                )
                ?>
            </p>


            <?=
            DetailView::widget([
                'model' => $model,
                'formatter' => [

                    'class' => '\yii\i18n\Formatter',

                    'dateFormat' => 'MM/dd/yyyy',

                    'datetimeFormat' => 'MM/dd/yyyy HH:mm:ss',

                ],
                'attributes' => [
                    //'id',
                    'name',
                    'email:email',
                    'mobile_number',
                    'message',

                    'by_phone' => [
                        'attribute' => 'By Phone',
                        'value' => function ($model) {
                            return  $model->by_phone === 1 ? 'prefer Phone' : '' ; 
                        },
                    ],

                    'by_email' => [
                        'attribute' => 'By Email',
                        'value' => function ($model) {
                            return  $model->by_phone === 1 ? 'prefer Email' : '' ; 
                        },
                    ],

                    'prefer_not_to_communicate' => [
                        'attribute' => 'Prefer Not To Communicate',
                        'value' => function ($model) {
                            return  $model->prefer_not_to_communicate === 1 ? 'prefer not to communicate' : '' ; 
                        },
                    ],
 

                    'created_at:datetime',
                ],
            ])
            ?>

        </div>
    </div>

</div>