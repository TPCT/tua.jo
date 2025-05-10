<?php

use yii\widgets\Pjax;
use yeesoft\grid\GridQuickLinks;
use kartik\grid\GridView;
use backend\modules\webforms\models\ContactUsWebform;
use kartik\daterange\DateRangePicker;
use yeesoft\grid\GridPageSize;
use kartik\dynagrid\DynaGrid;
use kartik\builder\Form;
use yii\helpers\ArrayHelper;
use kartik\form\ActiveForm;
use kartik\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\webforms\models\search\ComplaintsWebformSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$lng = Yii::$app->language;
$this->title = 'Request Visit';
$this->params['breadcrumbs'][] = $this->title;

$params = array_merge(['/webforms/request-visit/index/'],$_GET, array('Export'=>'1'));
$exportURL = \yii\helpers\Url::to($params);
?>


<div class="request-visit-webform-index">

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
                'action' => ['/webforms/request-visit/index']
            ]);

            try {
                $filterForm = Form::widget([
                    'model' => $searchModel,
                    'form' => $form,
                    'columns' => 5,
                    'attributes' => [
                        'name' => [],
                        'email' => [],
                        'message' => [],

                        'created_at' => [
                            'type' => Form::INPUT_WIDGET,
                            'widgetClass' => DateRangePicker::className(),

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
                        'label' => 'name',
                        'class' => 'yeesoft\grid\columns\TitleActionColumn',
                        'controller' => '/webforms/contact-us',
                        'title' => function ($model) {
                            return Html::a($model->name, ['view', 'id' => $model->id], ['data-pjax' => 0]);
                        },
                        'buttonsTemplate' => '',
                    ],
                    [
                        'attribute' => 'client_id',
                        'label' => 'Client',
                        'value' => function($model){
                            return $model->client->first_name . " " . $model->client->last_name;
                        }
                    ],
                    [
                        'attribute' => 'sponsorship_family_id',
                        'label' => 'Family Name',
                        'value' => function($model){
                            return $model->family->title;
                        }
                    ],
                    'email',
                    'phone',
                    'message',
                    'date' => [
                        'attribute' => 'date',
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
                        GridView::EXCEL => ['label' => 'Save as Excel'],
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


