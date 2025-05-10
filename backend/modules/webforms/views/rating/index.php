<?php

use yii\widgets\Pjax;
use yeesoft\grid\GridQuickLinks;
use kartik\grid\GridView;
use backend\modules\webforms\models\RatingWebform;
use kartik\daterange\DateRangePicker;
use yeesoft\grid\GridPageSize;
use kartik\dynagrid\DynaGrid;
use kartik\builder\Form;
use yii\helpers\ArrayHelper;
use kartik\form\ActiveForm;
use kartik\helpers\Html;
use yii\helpers\Url;

use common\components\TuaClient;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\webforms\models\search\ComplaintsWebformSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$lng = Yii::$app->language;
$this->title = 'Rating Webforms';
$this->params['breadcrumbs'][] = $this->title;

$params = array_merge(['/webforms/rating/index/'],$_GET, array('Export'=>'1'));
$exportURL = \yii\helpers\Url::to($params);
?>


<div class="contact-us-webform-index">

    <div class="panel panel-default">
        <div class="panel-body">
            <?php

            $isCollapse = count($_POST) ? '' : 'collapse';

            $containerTemplate = <<< HTML
        <div class="form-control kv-drp-dropdown">
            <i class="glyphicon glyphicon-calendar"></i>&nbsp;            
            <span class="float-end"><b class="caret"></b></span>
        </div>
        {input}
HTML;

            $form = ActiveForm::begin([
                'enableClientValidation' => false,
                'method' => 'GET',
                'action' => ['/webforms/rating/index']
            ]);

            try {
                $filterForm = Form::widget([
                    'model' => $searchModel,
                    'form' => $form,
                    'columns' => 5,
                    'attributes' => [
         

                        // 'category' => [
                        //     'type' => Form::INPUT_WIDGET,
                        //     'widgetClass' => '\kartik\widgets\Select2',
                        //     'options' => [
                        //         'data' => $searchModel->getCategoryList(),
                        //         'options' => ['placeholder' => Yii::t('app', 'Select category...')],
                        //         'pluginOptions' => ['allowClear' => true],
                        //     ]
                        // ],
                        'created_at' => [
                            'type' => Form::INPUT_WIDGET,
                            'widgetClass' => DateRangePicker::className(),
//                            'columnOptions' => [
//                                'colspan' => 2
//                            ],
                            'options' => [
                                //'containerTemplate' => $containerTemplate,
                                'attribute' => 'date_of_birth',
                                'hideInput' => false,
                                'presetDropdown' => true,
                                'convertFormat' => true,
                                'language' => 'en',
                                'pluginOptions' => [
//                                    'language' => 'en',
                                    'locale' => [
                                        'format' => 'Y-m-d',
                                        'cancelLabel' => Yii::t('app', 'Clear'),
                                    ],
                                    'format' => 'Y-m-d',
                                    'linkedCalendars' => false,
                                    'opens' => 'left',
                                    //'separator'=>' to '
                                    'allowClear' => true,
                                    //To Custom Ranges, should set presetDropdown=false
                                    //'ranges' => [Yii::t('app', "Today") => ["moment().startOf('day')", "moment()"],]
                                ],
                            ]
                        ],


                    ]
                ]);
            } 
            catch (Exception $e) 
            {
                var_dump($e->getMessage());
                die();
            }

            try 
            {
                echo Html::panel(
                    [
                        'heading' => 'Filter',
                        'body' => '<div class="panel-body bg-white text-dark">' . $filterForm . '</div>',
                        'footer' => '<div class="float-end">' /*. Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-success'])*/ . Html::submitButton(Yii::t('app', 'Filter'), ['class' => 'btn btn-primary']) . '</div>',

                        //        'heading' => '<a data-bs-toggle="collapse" href=".collapse1">' .  Yii::t('app', 'Filter') .'</a>',
                        //        'body' => "<div class='panel-body panel-collapse {$isCollapse} collapse1'>" . $filterForm . '</div>',
                        //        'footer'=> "<div class='float-end panel-collapse {$isCollapse} collapse1'>" /*. Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-success'])*/ . Html::submitButton(Yii::t('app', 'Filter'), ['class' => 'btn btn-primary']) . '</div>',
                    ],
                    Html::TYPE_SUCCESS,
                    ['class' => 'extra_filters clearfix d-block  bg-white webform text-dark mb-3']
                );
            } catch (\yii\base\InvalidConfigException $e) {
            }
            ?>
            <?php ActiveForm::end(); ?>





            <?php


            $columns =
                [
                    ['class' => 'yeesoft\grid\CheckboxColumn', 'options' => ['style' => 'width:10px']],

                    [
                        'label' => 'question 2 text',
                        'class' => 'yeesoft\grid\columns\TitleActionColumn',
                        'controller' => '/webforms/rating',
                        'title' => function (RatingWebform $model) {
                            return Html::a($model->question_2_text, Url::to(['view', 'id' => $model->id],true) , ['data-pjax' => 0]);
                        },
                        'buttonsTemplate' => '',
                    ],
                    [
                        'attribute' => 'question_4_text',
                        'label'=>'question text 4',
                        'value' => function ($model) {
                            return $model->question_4_text;
                        },
                        'format' => 'raw', 
                    ],
                    [
                        'attribute' => 'question_8_text',
                        'label'=>'question text 8',
                        'value' => function ($model) {
                            return $model->question_8_text;
                        },
                        'format' => 'raw', 
                    ],
                    [
                        'attribute' => 'question_1_id',
                        'label'=>'question one',
                        'value' => function ($model) {
                            return TuaClient::QOption2[$model->question_1_id];
                        },
                        'format' => 'raw', 
                    ],
                    [
                        'attribute' => 'question_2_id',
                        'label'=>'question Two',
                        'value' => function ($model) {
                            return TuaClient::QOption2[$model->question_2_id];
                        },
                        'format' => 'raw', 
                    ],
                    [
                        'attribute' => 'question_3_id',
                        'label'=>'question Three',
                        'value' => function ($model) {
                            return TuaClient::QOption3[$model->question_3_id];
                        },
                        'format' => 'raw', 
                    ],
                    [
                        'attribute' => 'question_5_id',
                        'label'=>'question Five',
                        'value' => function ($model) {
                            return TuaClient::QOption5_7[$model->question_5_id];
                        },
                        'format' => 'raw', 
                    ],


                    'created_at' => [
                        'attribute' => 'created_at',
                        'format' => ['date', 'php:d/m/Y h:m:s']
                    ],
                    

            ];
            $dynagrid = DynaGrid::begin([
                'columns' => $columns,
                //'theme' => 'panel-info',
                'showPersonalize' => true,
                'allowThemeSetting' => false,
                'allowSortSetting' => true,
                'allowFilterSetting' => false,
                'enableMultiSort' => true,
                //'storage'=>'cookie',
                'storage' => 'db',
                'gridOptions' => [
                    'dataProvider' => $dataProvider,
                    'filterModel' => null,
                    'resizableColumns' => false,
                    'responsive' => true,
                    'striped' => false,
                    'bordered' => false,
                    'condensed' => true,
                    'showPageSummary' => true,
                    'floatHeader' => false,
                    'export' => [
                        'fontAwesome' => true,
                        'showConfirmAlert' => false,
                        'target' => GridView::TARGET_SELF
                    ],
                    'exportConfig' => [
                        GridView::EXCEL => [
                            'label' => 'Save as Excel',
                            'filename' => 'Apply_Now',
                            'options' => ['title' => 'Export Excel'],
                            'config' => [
                                'worksheet' => 'ExportWorksheet',
                                'cssFile' => '',
                            ],
                        ],
//                        GridView::PDF => $pdfConfig
                    ],
                    // 'pjax' => true,
                    'panel' => [
                        'type' => 'info report-list',
                        'heading' => false,
                        'after' => '{pager}{summary}',
                        'before' => '<div class="float-end"><div class="btn-toolbar kv-grid-toolbar" role="toolbar"></div></div>' . '{pager}',
                        'footer' => false
                    ],
                    'toolbar' => [
                        ['content' =>
                            Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''], [
                                'class' => 'btn btn-default',
                                'title' => Yii::t('app', 'Reset Grid')
                            ])
                        ],
                        ['content' => '{dynagrid}'],
                        //['content' => ''{dynagridFilter}{dynagridSort}{dynagrid}'],
                        '{toggleData}',
                        ['content' =>
                            Html::a('<i class="glyphicon glyphicon-export"></i>', $exportURL, [
                                'class' => 'btn btn-default',
                                'title' => Yii::t('app', 'Export To Excel')
                            ])
                        ],
                       '{export}',
                        //'{toggleData}'
                    ]
                ],
                'options' => ['id' => 'contact-us-report'] // a unique identifier is important
            ]);
            DynaGrid::end();
            ?>
        </div>

    </div>
</div>


