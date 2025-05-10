<?php

use yii\widgets\DetailView;
use yeesoft\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\webforms\models\ComplaintsWebform */

$this->title = $model->sender_name;
$this->params['breadcrumbs'][] = ['label' => 'Donation Campain Webforms', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contact_us-webform-view">

    <h3 class="lte-hide-title"><?= Html::encode($this->title) ?></h3>

    <div class="panel panel-default">
        <div class="panel-body">

            <p>
                <?= Html::a(
                    'Delete',
                    ['/webforms/donation-campain/delete', 'id' => $model->id],
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
                    'amount',
                    'sender_name',
                    'sender_email',
                    'recipient_name',
                    'recipient_email',
                    'message',
                    'sender_mobile_number',
                    'recipient_mobile_number',
              


                    'eCards' => [
                        'attribute' => 'eCards',
                        'value' => function ($model) {
                            return $model->eCards ? $model->eCards->title : "not exists"; 
                        },
                    ],


                    'client' => [
                        'attribute' => 'client',
                        'value' => function ($model) {
                            return $model->client ? $model->client->first_name : "not exists"; 
                        },
                    ],

                    'send_when_finished' => [
                        'attribute' => 'send_when_finished',
                        'value' => function ($model) {
                            return $model->send_when_finished == 0 ? "false" : "true"; 
                        },
                    ],







                    'created_at:datetime',
                ],
            ])
            ?>

        </div>
    </div>

</div>