<?php

use yeesoft\helpers\Html;
use yeesoft\media\widgets\TinyMce;
use yeesoft\models\User;
use yeesoft\page\models\Page;
use yeesoft\widgets\ActiveForm;
use yeesoft\widgets\LanguagePills;
use yii\jui\DatePicker;
use wbraganca\dynamicform\DynamicFormWidget;
/* @var $this yii\web\View */
/* @var $model \backend\modules\news\models\News */
/* @var $form yeesoft\widgets\ActiveForm */
?>

    <div class="page-form">

        <?php
        $form = ActiveForm::begin([
            'id' => 'page-form',
            'validateOnBlur' => false,
        ])
        ?>
        <?= $form->errorSummary($model, ['class' => 'alert alert-danger']); ?>

        <div class="row">
            <div class="col-md-9">

                <div class="panel panel-default">
                    <div class="panel-body">
                    <?php if ($model->isMultilingual()): ?>
                            <?= LanguagePills::widget() ?>
                        <?php endif; ?>

                        <?= $form->field($model, 'path')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'image')->widget(yeesoft\media\widgets\FileInput::className(), [
                            'name' => 'image',
                            'buttonTag' => 'button',
                            'buttonName' => Yii::t('yee', 'Browse'),
                            'buttonOptions' => ['class' => 'btn btn-default btn-file-input'],
                            'options' => ['class' => 'form-control for-img'],
                            'template' => '<div class="post-image thumbnail"></div><div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                            'thumb' => $this->context->module->thumbnailSize,
                            'imageContainer' => '.post-image',
                            'pasteData' => yeesoft\media\widgets\FileInput::DATA_URL,
                            'callbackBeforeInsert' => 'function(e, data) {
                                $(".post-image").show();
                            }',
                        ]) ?>
                        <div>Hint: Image width and height should be 1400px by 228px</div>
                        <hr>
                        <?= $form->field($model, 'mobile_image')->widget(yeesoft\media\widgets\FileInput::className(), [
                            'name' => 'mobile_image',
                            'buttonTag' => 'button',
                            'buttonName' => Yii::t('yee', 'Browse'),
                            'buttonOptions' => ['class' => 'btn btn-default btn-file-input'],
                            'options' => ['class' => 'form-control for-img'],
                            'template' => '<div class="mobile_image thumbnail"></div><div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                            'thumb' => $this->context->module->thumbnailSize,
                            'imageContainer' => '.mobile_image',
                            'pasteData' => yeesoft\media\widgets\FileInput::DATA_URL,
                            'callbackBeforeInsert' => 'function(e, data) {
                                $(".mobile_image").show();
                            }',
                        ]) ?>

                        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'brief')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'button_text')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'button_url')->textInput(['maxlength' => true]) ?>






                        <div class="panel panel-default">
                    <div class="panel-body">

                        <?php DynamicFormWidget::begin([
                            'widgetContainer' => 'dynamicform_wrapper_group', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                            'widgetBody' => '.container-items_group', // required: css class selector
                            'widgetItem' => '.item_group', // required: css class
                            'limit' => 100, // the maximum times, an element can be cloned (default 999)
                            'min' => 0, // 0 or 1 (default 1)
                            'insertButton' => '.add-item_group', // css class
                            'deleteButton' => '.remove-item_group', // css class
                            'model' => $model->headerImageList[0],
                            'formId' => 'page-form',
                            'formFields' => [
                                '[]id',
                            ],
                        ]); ?>

                        <div class="row">
                            <div class="col-md-12">

                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"><?= Yii::t('app', 'Header Image BreadCrumb') ?></h3>


                                    </div>
                                    <div class="pull-right panel-body">
                                        <button type="button" class="add-item_group btn btn-success btn-sm">
                                            <i class="glyphicon glyphicon-plus"></i> <?= yii::t('app', 'Add') ?>
                                        </button>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="clearfix"></div>

                                    <div class="container-items_group">
                                        <?php foreach ($model->headerImageList as $chapterKey => $chapter): ?>
                                            <div class="item_group" pk="<?= $chapter->id ?>">
                                                <div class="panel-body">
                                                    <div class="row">
                                                        
                                                        

                                                            <div class="col-md-12">
                                                                <?= $form->field($chapter, "[$chapterKey]id")->hiddenInput()->label(false); ?>
                                                            </div>

                                                            <div class="col-md-12">
                                                                <?= $form->field($chapter, "[$chapterKey]button_url")->textInput(['maxlength' => true]) ?>
                                                            </div>
                                                            
                                                            <div class="col-md-6">
                                                                <?= $form->field($chapter, "[$chapterKey]button_text_en")->textInput(['maxlength' => true]) ?>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <?= $form->field($chapter, "[$chapterKey]button_text_ar")->textInput(['maxlength' => true]) ?>
                                                            </div>
                                            
                                                  

                                                        <div class="col-md-1">
                                                            <div style="text-align: right; margin-top: 31px">
                                                                <button pk="<?= $chapter->id ?>"
                                                                        class="remove-item_group btn btn-danger btn-xs">
                                                                    <i class="glyphicon glyphicon-minus"></i></button>
                                                            </div>
                                                        </div>
                                                        
                                                    </div>

                                                </div>
                                            </div>

                    
                                        <?php $chapterKey++; endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php DynamicFormWidget::end(); ?>

                    </div>
                </div>



                    </div>
                </div>
            </div>

            <div class="col-md-3">

                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="record-info">
                            <div class="form-group">
                                <?php if ($model->isNewRecord): ?>
                                    <?= Html::submitButton(Yii::t('yee', 'Create'), ['class' => 'btn btn-primary']) ?>
                                    <?= Html::a(Yii::t('yee', 'Cancel'), ['/header_image/default/index'], ['class' => 'btn btn-default',]) ?>
                                <?php else: ?>
                                    <?= Html::submitButton(Yii::t('yee', 'Save'), ['class' => 'btn btn-primary']) ?>
                                    <?=
                                    Html::a(Yii::t('yee', 'Delete'), ['/header_image/default/delete', 'id' => $model->id], [
                                        'class' => 'btn btn-default',
                                        'data' => [
                                            'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                            'method' => 'post',
                                        ],
                                    ])
                                    ?>
                                <?php endif; ?>

                                <br>
                                <?= $form->field($model, 'view')->dropDownList($this->context->module->headerImageView, ['class'=>'form-select m'] ) ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>


<?php


$js = <<<JS
    
JS;

$this->registerJs($js, yii\web\View::POS_END);
?>