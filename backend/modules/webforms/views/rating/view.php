<?php

use yii\widgets\DetailView;
use yeesoft\helpers\Html;
use common\components\TuaClient;

/* @var $this yii\web\View */
/* @var $model backend\modules\webforms\models\ComplaintsWebform */

$this->title = $model->question_2_text;
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
                    'question_2_text',
                    'question_4_text',
                    'question_8_text',

                    'questionOne' => [
                        'attribute' => 'questionOne',
                        'value' => function ($model) {
                            return TuaClient::QOption1[$model->question_1_id]; 
                        },
                    ],

                    'questionTwo' => [
                        'attribute' => 'questionTwo',
                        'value' => function ($model) {
                            return TuaClient::QOption2[$model->question_2_id]; 
                        },
                    ],

                    'questionThree' => [
                        'attribute' => 'questionThree',
                        'value' => function ($model) {
                            return TuaClient::QOption3[$model->question_3_id]; 
                        },
                    ],

                    'questionFive' => [
                        'attribute' => 'questionFive',
                        'value' => function ($model) {
                            return TuaClient::QOption5_7[$model->question_5_id]; 
                        },
                    ],
                    'questionSix' => [
                        'attribute' => 'questionSix',
                        'value' => function ($model) {
                            return TuaClient::QOption5_7[$model->question_6_id]; 
                        },
                    ],
                    'questionSeven' => [
                        'attribute' => 'questionSeven',
                        'value' => function ($model) {
                            return TuaClient::QOption5_7[$model->question_7_id]; 
                        },
                    ],


        
                    'created_at:datetime',
                ],
            ])
            ?>

        </div>
    </div>

</div>