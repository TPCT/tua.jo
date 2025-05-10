<?php

use yii\widgets\DetailView;
use yeesoft\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\webforms\models\ComplaintsWebform */

$this->title = $model->first_name . " " . $model->last_name;
$this->params['breadcrumbs'][] = ['label' => 'Transaction', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contact_us-webform-view">

    <h3 class="lte-hide-title"><?= Html::encode($this->title) ?></h3>

    <div class="panel panel-default">
        <div class="panel-body">

            <p>
                <?= Html::a(
                    'Delete',
                    ['/transaction/delete', 'id' => $model->id],
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
                    'first_name',
                    'last_name',
                    'email:email',
                    'payment_id',
                    'phone',
                    'amount',
                    'type',
                    'status',
                    'country',
                    'city',
                    'street',
                    'donor_id',

                    'items' => [
                            'attribute' => 'items',
                            'format' => 'raw',
                            'value' => function ($model) {
                                $html = "";
                                foreach ($model->items as $item) {
                                    $html .= $item->donation_id . "<br/>";
                                }
                                return $html;
                            }
                    ],

                    'error_message' => [
                        'attribute' => 'payment_message',
                        'value' => function($model) {
                            return $model->error_message;
                        }
                    ],
           
                    'client' => [
                        'attribute' => 'client',
                        'value' => function ($model) {
                            return $model->client ? $model->client->name : "not exists";
                        },
                    ],


                    'created_at:datetime',
                ],
            ])
            ?>


        </div>
    </div>

</div>