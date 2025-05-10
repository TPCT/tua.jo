<?php

use yii\widgets\DetailView;
use yeesoft\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\webforms\models\ComplaintsWebform */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Sea Allegation Webforms', 'url' => ['index']];
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
                    'volunteer_date',
                    'mobile_number',
                    'gender',
                    'university_name',
                    'email',
                    'specify',
                    'participated_volunteer_type',

                    'nationalities' => [
                        'attribute' => 'nationalities',
                        'value' => function ($model) {
                            return $model->nationalities ? $model->nationalities->en_nationality : "not exists"; 
                        },
                    ],

                    'countries' => [
                        'attribute' => 'countries',
                        'value' => function ($model) {
                            return $model->countries ? $model->countries->en_short_name : "not exists"; 
                        },
                    ],



                    'volunteers' => [
                        'attribute' => 'volunteers',
                        'value' => function ($model) {
                            return $model->volunteers ? $model->volunteers->title : "not exists"; 
                        },
                    ],

                    'occupationType' => [
                        'attribute' => 'occupationType',
                        'value' => function ($model) {
                            return $model->occupationType ? $model->occupationType->title : "not exists"; 
                        },
                    ],

                    'hearAboutVolunteerType' => [
                        'attribute' => 'hearAboutVolunteerType',
                        'value' => function ($model) {
                            return $model->hearAboutVolunteerType ? $model->hearAboutVolunteerType->title : "not exists"; 
                        },
                    ],





                    'created_at:datetime',
                ],
            ])
            ?>

        </div>
    </div>

</div>