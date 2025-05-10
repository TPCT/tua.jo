<?php

use yii\widgets\DetailView;
use yeesoft\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\webforms\models\ComplaintsWebform */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Apply Now Webforms', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contact_us-webform-view">

    <h3 class="lte-hide-title"><?= Html::encode($this->title) ?></h3>

    <div class="panel panel-default">
        <div class="panel-body">

            <p>
                <?= Html::a(
                    'Delete',
                    ['/webforms/join-us/delete', 'id' => $model->id],
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

                    'inciden_date',

                    
                    'protectionContactMethod' => [
                        'attribute' => 'protectionContactMethod',
                        'value' => function ($model) {
                            return $model->protectionContactMethod ? $model->protectionContactMethod->title : "not exists"; 
                        },
                    ],

                    'location',
                    'description',
                    'survivor_name',
                    'survivor_position',
                    'alleged_name',
                    'alleged_position',
                    'witness_name',
                    'additional_information',
                    



                    'created_at:datetime',
                ],
            ])
            ?>

        </div>
    </div>

</div>