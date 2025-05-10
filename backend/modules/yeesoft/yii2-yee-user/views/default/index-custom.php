<?php

use backend\modules\dropdown_list\models\DropdownList;
use common\helpers\Utility;
use common\models\Countries;
use kartik\builder\Form;
use kartik\daterange\DateRangePicker;
use kartik\dynagrid\DynaGrid;
use kartik\grid\GridView;
use kartik\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use yeesoft\grid\GridPageSize;
use yeesoft\grid\GridQuickLinks;
use yeesoft\models\Role;
use common\models\User;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\Pjax;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var yeesoft\user\models\search\UserSearch $searchModel
 */
$this->title = Yii::t('yee/user', 'Users');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-index">

    <div class="row">
        <div class="col-sm-12">
            <h3 class="lte-hide-title page-title"><?= Html::encode($this->title) ?></h3>
            <?= Html::a(Yii::t('yee', 'Add New'), ['/user/default/create'], ['class' => 'btn btn-sm btn-primary']) ?>
        </div>
    </div>

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
            ]);

            try {
                $filterForm = Form::widget([
                    'model' => $searchModel,
                    'form' => $form,
                    'columns' => 6,
                    'attributes' => [
                        'fullName' => [
                        ],
                        'email' => [

                        ],
                        'mobile' => [

                        ],
                        'home_phone' => [

                        ],
                        'work_phone' => [

                        ],
                        'gender' => [
                            'type' => Form::INPUT_WIDGET,
                            'widgetClass' => Select2::className(),
                            'options' => [
                                'options' => ['placeholder' => Yii::t('app', '')],
                                'pluginOptions' => ['allowClear' => true, 'multiple' => false],
                                'data' => Utility::getGenderList()
                            ],
                        ],
                        'nationality' => [
                            'type' => Form::INPUT_WIDGET,
                            'widgetClass' => Select2::className(),
                            'options' => [
                                'options' => ['placeholder' => Yii::t('app', '')],
                                'pluginOptions' => ['allowClear' => true, 'multiple' => false],
                                'data' => ArrayHelper::map(Countries::find()->all(), 'num_code', 'nationality')
                            ],
                        ],
                        'place_of_residence' => [
                            'type' => Form::INPUT_WIDGET,
                            'widgetClass' => Select2::className(),
                            'options' => [
                                'options' => ['placeholder' => Yii::t('app', '')],
                                'pluginOptions' => ['allowClear' => true, 'multiple' => false],
                                'data' => ArrayHelper::map(Countries::find()->all(), 'num_code', 'en_short_name')
                            ],
                        ],
                        'city' => [

                        ],
                        'number_of_dependent' => [

                        ],
                        'marital_status' => [
                            'type' => Form::INPUT_WIDGET,
                            'widgetClass' => Select2::className(),
                            'options' => [
                                'options' => ['placeholder' => Yii::t('app', '')],
                                'pluginOptions' => ['allowClear' => true, 'multiple' => false],
                                'data' => Utility::getMaritalStatus()
                            ],
                        ],
                        'date_of_birth' => [
                            'type' => Form::INPUT_WIDGET,
                            'widgetClass' => DateRangePicker::className(),
                            'columnOptions' => [
                                'colspan' => 2
                            ],
                            'options' => [
                                //'containerTemplate' => $containerTemplate,
                                'attribute' => 'date_of_birth',
                                'hideInput' => false,
                                'presetDropdown' => true,
                                'convertFormat' => true,
                                'pluginOptions' => [
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
            } catch (Exception $e) {
                // var_dump($e->getMessage());die();
                error_log($e->getMessage());
            }
            try {
                echo Html::panel(
                    [
                        'heading' => 'Filter',
                        'body' => '<div class="panel-body">' . $filterForm . '</div>',
                        'footer' => '<div class="float-end">' /*. Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-success'])*/ . Html::submitButton(Yii::t('app', 'Filter'), ['class' => 'btn btn-primary']) . '</div>',

                        //        'heading' => '<a data-bs-toggle="collapse" href=".collapse1">' .  Yii::t('app', 'Filter') .'</a>',
                        //        'body' => "<div class='panel-body panel-collapse {$isCollapse} collapse1'>" . $filterForm . '</div>',
                        //        'footer'=> "<div class='float-end panel-collapse {$isCollapse} collapse1'>" /*. Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-success'])*/ . Html::submitButton(Yii::t('app', 'Filter'), ['class' => 'btn btn-primary']) . '</div>',
                    ],
                    Html::TYPE_SUCCESS,
                    ['class' => 'extra_filters clearfix']
                );
            } catch (\yii\base\InvalidConfigException $e) {
                error_log($e->getMessage());
            }
            ?>
            <?php ActiveForm::end(); ?>


            <?php

            $columns =
                [
                    ['class' => 'kartik\grid\SerialColumn', 'order' => DynaGrid::ORDER_FIX_LEFT, 'mergeHeader' => false,],
//                    ['class' => \kartik\grid\CheckboxColumn::className(), 'order' => DynaGrid::ORDER_FIX_LEFT, 'options' => ['style' => 'width:10px']],

                [
                    'attribute' => 'username',
                    'controller' => '/user/default',
                    'class' => 'yeesoft\grid\columns\TitleActionColumn',
                    'title' => function (User $model) {
                        if (User::hasPermission('editUsers')) {
                            return Html::a($model->username, ['/user/default/view', 'id' => $model->id], ['data-pjax' => 0]);
                        } else {
                            return $model->username;
                        }
                    },
                    'buttonsTemplate' => '{view} {update} {delete} {password}',
                    'buttons' => [
                        'permissions' => function ($url, $model, $key) {
                            return Html::a(Yii::t('yee/user', 'Permissions'),
                                Url::to(['user-permission/set', 'id' => $model->id]), [
                                    'title' => Yii::t('yee/user', 'Permissions'),
                                    'data-pjax' => '0'
                                ]
                            );
                        },
                        'password' => function ($url, $model, $key) {
                            return Html::a(Yii::t('yee/user', 'Password'),
                                Url::to(['default/change-password', 'id' => $model->id]), [
                                    'title' => Yii::t('yee/user', 'Password'),
                                    'data-pjax' => '0'
                                ]
                            );
                        }
                    ],
                    'options' => ['style' => 'width:300px']
                ],
                [
                    'attribute' => 'fullName',
                ],

                [
                    'attribute' => 'email',
                    'format' => 'raw',
                    'visible' => User::hasPermission('viewUserEmail'),
                ],
                [
                    'attribute' => 'personalInformation.mobile',
                ],
                [
                    'attribute' => 'personalInformation.gender',
                ],
                [
                    'attribute' => 'personalInformation.nationality',
                    'visible' => false,
                ],
                [
                    'attribute' => 'personalInformation.street_address_line_1',
                    'visible' => false,
                ],
                [
                    'attribute' => 'personalInformation.address_line_2',
                    'visible' => false,
                ],
                [
                    'attribute' => 'personalInformation.city',
                    'visible' => false,
                ],
                [
                    'attribute' => 'personalInformation.zip_postal_code',
                    'visible' => false,
                ],
                [
                    'attribute' => 'personalInformation.home_phone',
                    'visible' => false,
                ],
                [
                    'attribute' => 'personalInformation.work_phone',
                    'visible' => false,
                ],
                [
                    'attribute' => 'personalInformation.placeOfResidence',
                    'visible' => false,
                ],
                [
                    'attribute' => 'personalInformation.advanceNotice',
                    'visible' => false,
                ],
                [
                    'attribute' => 'personalInformation.date_of_availability',
                    'visible' => false,
                ],
                [
                    'attribute' => 'personalInformation.current_annual_ctc',
                    'visible' => false,
                ],
                [
                    'attribute' => 'personalInformation.expected_annual_ctc',
                    'visible' => false,
                ],
                [
                    'attribute' => 'personalInformation.sourceTracking',
                    'visible' => false,
                ],
                [
                    'attribute' => 'personalInformation.date_of_birth',
                ],
                [
                    'class' => 'yeesoft\grid\columns\StatusColumn',
                    'attribute' => 'status',
                    'order' => DynaGrid::ORDER_FIX_RIGHT,
                        'optionsArray' => [
                            [User::STATUS_ACTIVE, Yii::t('yee', 'Active'), 'primary'],
                            [User::STATUS_INACTIVE, Yii::t('yee', 'Inactive'), 'info'],
                            [User::STATUS_BANNED, Yii::t('yee', 'Banned'), 'default'],
                        ],
                    'options' => ['style' => 'width:60px']
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
                    'showPageSummary' => false,
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
                        '{export}',
                        //'{toggleData}'
                    ]
                ],
                'options' => ['id' => 'activities'] // a unique identifier is important
            ]);
            if (substr($dynagrid->theme, 0, 6) == 'simple') {
                $dynagrid->gridOptions['panel'] = false;
            }
            DynaGrid::end();
            ?>
        </div>
    </div>
</div>
