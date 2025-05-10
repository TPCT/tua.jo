<?php

use kartik\dynagrid\DynaGrid;
use kartik\grid\GridView;
use yeesoft\widgets\ActiveForm;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */

?>

    <div class="pull-<?= $position ?> col-lg-<?= $width ?> widget-height-<?= $height ?>">
        <div class="panel panel-default dw-widget">
            <div class="panel-heading"><?= Yii::t('yee/user', 'Pending Items') ?></div>
            <div class="panel-body">


                <?php

//                $columns =
//                    [
//                        ['class' => 'kartik\grid\SerialColumn', 'order' => DynaGrid::ORDER_FIX_LEFT, 'mergeHeader' => false,],
//
//                        [
//                            'attribute' => "section",
//
//                        ],
//
//
//                    ];
//                $dynagrid = DynaGrid::begin([
//                    'columns' => $columns,
//                    //'theme' => 'panel-info',
//                    'showPersonalize' => false,
//                    'allowThemeSetting' => false,
//                    'allowSortSetting' => false,
//                    'allowFilterSetting' => false,
//                    'enableMultiSort' => false,
//                    //'storage'=>'cookie',
//                    'storage' => 'db',
//                    'gridOptions' => [
//                        'dataProvider' => $dataProvider,
//                        'filterModel' => null,
//                        'resizableColumns' => false,
//                        'responsive' => false,
//                        'striped' => false,
//                        'bordered' => false,
//                        'condensed' => true,
//                        'showPageSummary' => true,
//                        'floatHeader' => false,
//                        'export' => [
//                            'fontAwesome' => true,
//                            'showConfirmAlert' => false,
//                            'target' => GridView::TARGET_SELF
//                        ],
//                        'exportConfig' => [
//                            GridView::EXCEL => ['label' => 'Save as Excel'],
//                        ],
//                        'pjax' => false,
//                        'panel' => [
//                            'type' => 'info report-list',
//                            'heading' => false,
//                            'after' => '{pager}{summary}',
//                            'before' => '<div class="float-end"><div class="btn-toolbar kv-grid-toolbar" role="toolbar"></div></div>' . '{pager}',
//                            'footer' => false
//                        ],
//                        'toolbar' => [
//                            ['content' =>
//                                Html::a('<i class="glyphicon glyphicon-repeat"></i>', [''], [
//                                    'class' => 'btn btn-default',
//                                    'title' => Yii::t('app', 'Reset Grid')
//                                ])
//                            ],
//                            ['content' => '{dynagrid}'],
//                            //['content' => ''{dynagridFilter}{dynagridSort}{dynagrid}'],
//                            '{toggleData}',
//                            '{export}',
//                            //'{toggleData}'
//                        ]
//                    ],
//                    'options' => ['id' => 'audit-list'] // a unique identifier is important
//                ]);
//                if (substr($dynagrid->theme, 0, 6) == 'simple') {
//                    $dynagrid->gridOptions['panel'] = false;
//                }
//                DynaGrid::end();

                ?>

        <?php
            $form = ActiveForm::begin([
                'id' => 'dashboard-form',
                'validateOnBlur' => false,
            ])
        ?>
        <?= $form->errorSummary($model, ['class' => 'alert alert-danger']); ?>

        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-default">
                    <div class="panel-body">

                        <div class="row">
                        
                            <div class="col-md-10">
                                <?= $form->field($model, 'model')->dropDownList($model->getExistedRevision(),["prompt"=>Yii::t("site","Select Model"), 'class'=>'form-select'])->label(false) ?>
                            </div>
                            <?php // $form->field($model, 'module_key')->hiddenInput()->label(""); ?>
                            <div class="col-md-2">
                                <?= Html::submitButton(Yii::t('yee', 'Filter'), ['class' => 'btn btn-primary']) ?>
                            </div>        

                        </div>
                        
                    </div>
                </div>
            </div>


        </div>

        <?php ActiveForm::end(); ?>


                <?php Pjax::begin(['id' => 'page-grid-pjax']) ?>

                    <?php try {
                    echo
                    GridView::widget([
//                        'id' => 'page-grid',
                        'dataProvider' => $dataProvider,
//                        'filterModel' => false,
                        'columns' => [

                            [
                                'attribute' => 'section',

                            ],
                            [
                                'attribute' => "item",
                                'format' => "raw",
                                'value' => function ($data) {
                                    return Html::a($data['title'], $data['url'], ['data-pjax' => '0']);
                                }
                            ],
                        ],
                    ]);
                } 
                catch (Exception $e) 
                {
                    error_log($e->getMessage());
                }
                ?>

                    <?php Pjax::end() ?>

            </div>
        </div>
    </div>
<?php
$css = <<<CSS
.dw-widget{
    position:relative;
    padding-bottom:15px;
}
.dw-user {
    border-bottom: 1px solid #eee;
    padding-bottom: 5px;
    margin-bottom: 5px;
}
.dw-user-info {
    padding-left: 60px;
}
.dw-quick-links{
    position: absolute;
    bottom:10px;
    left:0;
    right:0;
    text-align: center;
}
.avatar {
    float: left;
    margin-right: 10px;
    margin-top: 3px;
}

CSS;

$this->registerCss($css);
?>