<?php

use backend\modules\city\models\City;
use backend\modules\blogs\models\Blogs;
use kartik\number\NumberControl;
use kartik\select2\Select2;
use yeesoft\helpers\Html;
use yeesoft\media\widgets\TinyMce;
use yeesoft\models\User;
use yeesoft\page\models\Page;
use yeesoft\widgets\ActiveForm;
use yeesoft\widgets\LanguagePills;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\jui\DatePicker;
use yeesoft\helpers\FA;

/* @var $this yii\web\View */
/* @var $model News */
/* @var $form yeesoft\widgets\ActiveForm */
?>

    <div class="page-form">

        <?php
        $form = ActiveForm::begin([
            'id' => 'page-form',
            'validateOnBlur' => true,
        ])
        ?>
        <?= $form->errorSummary([$model, ...$model->ItemsList], ['class' => 'alert alert-danger']); ?>

        <div class="row">
            <div class="col-md-9">

                <div class="panel panel-default">
                    <div class="panel-body">

                        <?php if ($model->isMultilingual()): ?>
                            <?= LanguagePills::widget() ?>
                        <?php endif; ?>

                        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'brief')->textarea(['maxlength' => true]) ?>

                        <?= $form->field($model, 'image')->widget(yeesoft\media\widgets\FileInput::className(), [
                                'name' => 'image',
                                'buttonTag' => 'button',
                                'buttonName' => Yii::t('site', 'Browse'),
                                'buttonOptions' => ['class' => 'btn btn-default btn-file-input'],
                                'options' => ['class' => 'form-control for-img'],
                                'template' => '<div class="news-image thumbnail"></div><div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                                'thumb' => $this->context->module->thumbnailSize,
                                'imageContainer' => '.news-image',
                                'pasteData' => yeesoft\media\widgets\FileInput::DATA_URL,
                                'callbackBeforeInsert' => 'function(e, data) {
                                $(".news-image").show();
                            }',
                            ]) ?>

                        <?= $form->field($model, 'fatwa_file')->widget(yeesoft\media\widgets\FileInput::className(), [
                                'name' => 'fatwa_file',
                                'buttonTag' => 'button',
                                'buttonName' => Yii::t('site', 'Browse'),
                                'buttonOptions' => ['class' => 'btn btn-default btn-file-input'],
                                'options' => ['class' => 'form-control for-img'],
                                'template' => '<div class="news-image thumbnail"></div><div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                                'thumb' => $this->context->module->thumbnailSize,
                                'imageContainer' => '.news-image',
                                'pasteData' => yeesoft\media\widgets\FileInput::DATA_URL,
                                'callbackBeforeInsert' => 'function(e, data) {
                                $(".news-image").show();
                            }',
                            ]) ?>

                        <div class="panel panel-default">
                            <div class="panel-body">

                                <?php \wbraganca\dynamicform\DynamicFormWidget::begin([
                                    'widgetContainer' => 'dynamic_form_3', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                                    'widgetBody' => '.container-items_group', // required: css class selector
                                    'widgetItem' => '.tab_group', // required: css class
                                    'limit' => 5, // the maximum times, an element can be cloned (default 999)
                                    'min' => 3, // 0 or 1 (default 1)
                                    'insertButton' => '.add-tab_group', // css class
                                    'deleteButton' => '.remove-tab_group', // css class
                                    'model' => $model->FeaturesList[0],
                                    'formId' => 'page-form',
                                    'formFields' => [
                                        '[]id',
                                    ],
                                ]); ?>

                                <div class="col-md-12">

                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3 class="panel-title"><?= Yii::t('app', 'Features') ?></h3>
                                        </div>
                                        <div class="container-items_group">
                                            <?php foreach ($model->FeaturesList as $chapterKey => $chapter): ?>
                                                <div class="tab_group col-4" pk="<?= $chapter->id ?>">
                                                    <div class="panel-body">
                                                        <div class="row">


                                                            <div class="col-md-11">

                                                                <div class="col-md-12">
                                                                    <?= $form->field($chapter, "[$chapterKey]id")->hiddenInput()->label(false); ?>
                                                                </div>

                                                                <div class="col-md-12">
                                                                    <?= $form->field($chapter, "[$chapterKey]image")->widget(yeesoft\media\widgets\FileInput::className(), [
                                                                        'name' => "[$chapterKey]image",
                                                                        'buttonTag' => 'button',
                                                                        'buttonName' => Yii::t('site', 'Browse'),
                                                                        'buttonOptions' => ['class' => 'btn btn-default btn-file-input'],
                                                                        'options' => ['class' => 'form-control for-img'],
                                                                        'template' => "<div class='feature-image-{$chapterKey} thumbnail'></div><div class='input-group'>{input}<span class='input-group-btn'>{button}</span></div>",
                                                                        'thumb' => $this->context->module->thumbnailSize,
                                                                        'imageContainer' => ".feature-image-{$chapterKey}",
                                                                        'pasteData' => yeesoft\media\widgets\FileInput::DATA_URL,
                                                                        'callbackBeforeInsert' => 'function(e, data) {
                                                                                $(".feature-image-' . $chapterKey . '").show();
                                                                            }',
                                                                    ]) ?>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <?= $form->field($chapter, "[$chapterKey]title_en")->textInput(); ?>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <?= $form->field($chapter, "[$chapterKey]title_ar")->textInput(); ?>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <?= $form->field($chapter, "[$chapterKey]value")->textInput(); ?>
                                                                </div>

                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>


                                                <?php $chapterKey++; endforeach; ?>
                                        </div>
                                    </div>
                                </div>

                                <?php \wbraganca\dynamicform\DynamicFormWidget::end(); ?>

                            </div>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-body">

                                <?php \wbraganca\dynamicform\DynamicFormWidget::begin([
                                    'widgetContainer' => 'dynamic_form_4', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                                    'widgetBody' => '.container-items_group', // required: css class selector
                                    'widgetItem' => '.tab_group', // required: css class
                                    'limit' => 3, // the maximum times, an element can be cloned (default 999)
                                    'min' => 0, // 0 or 1 (default 1)
                                    'insertButton' => '.add-tab_group', // css class
                                    'deleteButton' => '.remove-tab_group', // css class
                                    'model' => $model->PromotionsList[0],
                                    'formId' => 'page-form',
                                    'formFields' => [
                                        '[]id',
                                    ],
                                ]); ?>

                                <div class="col-md-12">

                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3 class="panel-title"><?= Yii::t('app', 'Related Programs') ?></h3>
                                        </div>

                                        <div class="pull-right panel-body">
                                            <button type="button" class="add-tab_group btn btn-success btn-sm">
                                                <i class="glyphicon glyphicon-plus"></i> <?= yii::t('app', 'Add') ?>
                                            </button>
                                        </div>

                                        <div class="container-items_group">
                                            <?php foreach ($model->PromotionsList as $chapterKey => $chapter): ?>
                                                <div class="tab_group col-4" pk="<?= $chapter->id ?>">
                                                    <div class="panel-body">
                                                        <div class="row">


                                                            <div class="col-md-11">

                                                                <div class="col-md-12">
                                                                    <?= $form->field($chapter, "[$chapterKey]id")->hiddenInput()->label(false); ?>
                                                                </div>

                                                                <div class="col-md-12">
                                                                    <?= $form->field($chapter, "[$chapterKey]donation_program_id")->dropDownList(\backend\modules\donation_programs\models\DonationProgram::getDonationPrograms($model->id)); ?>
                                                                </div>

                                                            </div>

                                                            <div class="col-md-1">
                                                                <div style="text-align: right; margin-top: 31px">
                                                                    <button pk="<?= $chapter->id ?>"
                                                                            class="remove-tab_group btn btn-danger btn-xs">
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

                                <?php \wbraganca\dynamicform\DynamicFormWidget::end(); ?>

                            </div>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-body">

                                <?php \wbraganca\dynamicform\DynamicFormWidget::begin([
                                    'widgetContainer' => 'dynamicform_wrapper_group', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                                    'widgetBody' => '.container-items_group', // required: css class selector
                                    'widgetItem' => '.tab_group', // required: css class
                                    'limit' => 100, // the maximum times, an element can be cloned (default 999)
                                    'min' => 0, // 0 or 1 (default 1)
                                    'insertButton' => '.add-tab_group', // css class
                                    'deleteButton' => '.remove-tab_group', // css class
                                    'model' => $model->TabsList[0],
                                    'formId' => 'page-form',
                                    'formFields' => [
                                        '[]id',
                                    ],
                                ]); ?>

                                <div class="row">
                                    <div class="col-md-12">

                                        <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <h3 class="panel-title"><?= Yii::t('app', 'Tabs') ?></h3>
                                            </div>
                                            <div class="pull-right panel-body">
                                                <button type="button" class="add-tab_group btn btn-success btn-sm">
                                                    <i class="glyphicon glyphicon-plus"></i> <?= yii::t('app', 'Add') ?>
                                                </button>
                                            </div>
                                            <div class="clearfix"></div>
                                            <div class="clearfix"></div>

                                            <div class="container-items_group">
                                                <?php foreach ($model->TabsList as $chapterKey => $chapter): ?>
                                                    <div class="tab_group" pk="<?= $chapter->id ?>">
                                                        <div class="panel-body">
                                                            <div class="row">


                                                                <div class="col-md-11">

                                                                    <div class="col-md-12">
                                                                        <?= $form->field($chapter, "[$chapterKey]id")->hiddenInput()->label(false); ?>
                                                                    </div>



                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <?= $form->field($chapter, "[$chapterKey]title_en")->textInput(['maxlength' => true]) ?>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <?= $form->field($chapter, "[$chapterKey]title_ar")->textInput(['maxlength' => true]) ?>
                                                                        </div>
                                                                    </div>


                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <?= $form->field($chapter, "[$chapterKey]label_url_en")->textInput(['maxlength' => true]) ?>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <?= $form->field($chapter, "[$chapterKey]label_url_ar")->textInput(['maxlength' => true]) ?>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <?= $form->field($chapter, "[$chapterKey]brief_en")->widget(TinyMce::className(), [
                                                                                'clientOptions' =>
                                                                                    [
                                                                                        'height' => 600,
                                                                                        'image_dimensions' => true,
                                                                                        'entity_encoding' => 'raw',
                                                                                        'plugins' => 'print preview paste importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons bootstrap',
                                                                                        'toolbar' => 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | ltr rtl | bootstrap',
                                                                                        'bootstrapConfig' => [
                                                                                            'url' => '/js/tinymce/plugins/bootstrap/',
                                                                                            'iconFont' => 'fontawesome5',
                                                                                            'key' => Yii::$app->params['BootstrapEditorKey']
                                                                                        ],
                                                                                    ]
                                                                            ]);
                                                                            ?>
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <?= $form->field($chapter, "[$chapterKey]brief_ar")->widget(TinyMce::className(), [
                                                                                'clientOptions' =>
                                                                                    [
                                                                                        'height' => 600,
                                                                                        'image_dimensions' => true,
                                                                                        'entity_encoding' => 'raw',
                                                                                        'plugins' => 'print preview paste importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons bootstrap',
                                                                                        'toolbar' => 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | ltr rtl | bootstrap',
                                                                                        'bootstrapConfig' => [
                                                                                            'url' => '/js/tinymce/plugins/bootstrap/',
                                                                                            'iconFont' => 'fontawesome5',
                                                                                            'key' => Yii::$app->params['BootstrapEditorKey']
                                                                                        ],
                                                                                    ]
                                                                            ]);
                                                                            ?>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                                <div class="col-md-1">
                                                                    <div style="text-align: right; margin-top: 31px">
                                                                        <button pk="<?= $chapter->id ?>"
                                                                                class="remove-tab_group btn btn-danger btn-xs">
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
                                <?php \wbraganca\dynamicform\DynamicFormWidget::end(); ?>

                            </div>
                        </div>

                        <div class="panel panel-default">
                            <div class="panel-body">

                                <?php \wbraganca\dynamicform\DynamicFormWidget::begin([
                                    'widgetContainer' => 'dynamic_form_parents', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                                    'widgetBody' => '.container-parents_group', // required: css class selector
                                    'widgetItem' => '.parent_group', // required: css class
                                    'limit' => 2, // the maximum times, an element can be cloned (default 999)
                                    'min' => 2, // 0 or 1 (default 1)
                                    'insertButton' => '.add-parent_group', // css class
                                    'deleteButton' => '.remove-parent_group', // css class
                                    'model' => $model->ParentsList[0],
                                    'formId' => 'page-form',
                                    'formFields' => [
                                        '[]id',
                                    ],
                                ]); ?>

                                <div class="col-md-12">

                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3 class="panel-title"><?= Yii::t('app', 'Parents') ?></h3>
                                        </div>
                                        <div class="container-parents_group">
                                            <?php foreach ($model->ParentsList as $chapterKey => $chapter): ?>
                                                <div class="parent_group col-6" pk="<?= $chapter->id ?>">
                                                    <div class="panel-body">
                                                        <div class="row">
                                                            <div class="col-md-11">

                                                                <div class="col-md-12">
                                                                    <?= $form->field($chapter, "[$chapterKey]id")->hiddenInput()->label(false); ?>
                                                                </div>

                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <?= $form->field($chapter, "[$chapterKey]title_en")->textInput(); ?>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <?= $form->field($chapter, "[$chapterKey]title_ar")->textInput(); ?>
                                                                    </div>
                                                                </div>

                                                                <?php \wbraganca\dynamicform\DynamicFormWidget::begin([
                                                                    'widgetContainer' => 'dynamic_form_2', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                                                                    'widgetBody' => '.container-items_group', // required: css class selector
                                                                    'widgetItem' => '.tab_group', // required: css class
                                                                    'limit' => 100, // the maximum times, an element can be cloned (default 999)
                                                                    'min' => $chapterKey ? 0 : 1, // 0 or 1 (default 1)
                                                                    'insertButton' => '.add-tab_group', // css class
                                                                    'deleteButton' => '.remove-tab_group', // css class
                                                                    'model' => $chapter->ItemsList[0],
                                                                    'formId' => 'page-form',
                                                                    'formFields' => [
                                                                        '[]id',
                                                                    ],
                                                                ]); ?>

                                                                <div class="row">
                                                                    <div class="col-md-12">

                                                                        <div class="panel panel-default">
                                                                            <div class="panel-heading">
                                                                                <h3 class="panel-title"><?= Yii::t('app', 'Items') ?></h3>
                                                                            </div>
                                                                            <div class="pull-right panel-body">
                                                                                <button type="button" class="add-tab_group btn btn-success btn-sm add-item">
                                                                                    <i class="glyphicon glyphicon-plus"></i> <?= yii::t('app', 'Add') ?>
                                                                                </button>
                                                                            </div>
                                                                            <div class="clearfix"></div>
                                                                            <div class="clearfix"></div>

                                                                            <div class="container-items_group" data-parent-index="<?=$chapterKey?>">
                                                                                <?php
                                                                                    foreach ($chapter->ItemsList as $itemKey => $item):
                                                                                        $pk = uniqid();
                                                                                ?>
                                                                                    <div class="tab_group" pk="<?= $item->id ?>">
                                                                                        <div class="panel-body">
                                                                                            <div class="row">

                                                                                                <div class="col-md-11">
                                                                                                    <?=$form->field($item, "[" . $pk  . "]parent_index")->hiddenInput(['value' => $chapterKey, 'class' => 'parent-index'])->label(false)?>
                                                                                                    <?=$form->field($item, "[" . $pk  . "]id")->hiddenInput()->label(false); ?>

                                                                                                    <div class="row">
                                                                                                        <div class="col-md-6">
                                                                                                            <?= $form->field($item, "[" . $pk . "]donation_type_id")->dropDownList(\backend\modules\donation_programs\models\DonationProgram::getDonationTypes(false)) ?>
                                                                                                        </div>
                                                                                                        <div class="col-md-6">
                                                                                                            <?= $form->field($item, "[" . $pk . "]campaign_id")->dropDownList(\backend\modules\donation_programs\models\DonationProgram::getCampaigns(true)) ?>
                                                                                                        </div>
                                                                                                        <div class="col-md-6">
                                                                                                            <?= $form->field($item, "[" . $pk . "]amount_jod")->textInput() ?>
                                                                                                        </div>
                                                                                                        <div class="col-md-6">
                                                                                                            <?= $form->field($item, "[" . $pk . "]amount_usd")->textInput() ?>
                                                                                                        </div>
                                                                                                    </div>

                                                                                                </div>

                                                                                                <div class="col-md-1">
                                                                                                    <div style="text-align: right; margin-top: 31px">
                                                                                                        <button pk="<?= $item->id ?>"
                                                                                                                class="remove-tab_group btn btn-danger btn-xs">
                                                                                                            <i class="glyphicon glyphicon-minus"></i></button>
                                                                                                    </div>
                                                                                                </div>

                                                                                            </div>

                                                                                        </div>
                                                                                    </div>
                                                                                    <?php $itemKey++; endforeach; ?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <?php \wbraganca\dynamicform\DynamicFormWidget::end(); ?>
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>

                                <?php \wbraganca\dynamicform\DynamicFormWidget::end(); ?>

                            </div>
                        </div>
                    </div>
                </div>


            </div>

            <div class="col-md-3">

                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="record-info">
                            <?php if (!$model->isNewRecord): ?>

                                <div class="form-group clearfix">
                                    <label class="control-label" style="float: left; padding-right: 5px;">
                                        <?= $model->attributeLabels()['created_at'] ?> :
                                    </label>
                                    <span><?= $model->createdDatetime ?></span>
                                </div>

                                <div class="form-group clearfix">
                                    <label class="control-label" style="float: left; padding-right: 5px;">
                                        <?= $model->attributeLabels()['updated_at'] ?> :
                                    </label>
                                    <span><?= $model->updatedDatetime ?></span>
                                </div>

                                <div class="form-group clearfix">
                                    <label class="control-label" style="float: left; padding-right: 5px;">
                                        <?= $model->attributeLabels()['updated_by'] ?> :
                                    </label>
                                    <span><?= $model->updatedBy->username ?></span>
                                </div>

                            <?php endif; ?>

                            <div class="form-group">
                                <?php if ($model->isNewRecord): ?>
                                    <?= Html::submitButton(Yii::t('site', 'Create'), ['class' => 'btn btn-primary']) ?>
                                    <?= Html::a(Yii::t('site', 'Cancel'), ["/{$this->context->module->id}/default/index"], ['class' => 'btn btn-default',]) ?>
                                <?php else: ?>
                                    <?= Html::submitButton(Yii::t('site', 'Save'), ['class' => 'btn btn-primary']) ?>
                                    <?=
                                    Html::a(Yii::t('site', 'Delete'), ["/{$this->context->module->id}/default/delete", 'id' => $model->id], [
                                        'class' => 'btn btn-danger',
                                        'data' => [
                                            'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                            'method' => 'post',
                                        ],
                                    ])
                                    ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-body">
<!--                            --><?php //= $form->field($model, 'type')->dropDownList( $model->getDonationProgramsTypes(), ["Prompt"=>"Select Type", 'class' => 'form-select'] ) ?>

                            <?= $form->field($model, 'published_at')->widget(DatePicker::className(), ['dateFormat' => 'yyyy-MM-dd', 'options' => ['class' => 'form-control']]);?>
                            
                            <?php if( $model->canMakerSeeStatus() ): ?>
                                <?= $form->field($model, 'status')->dropDownList(Blogs::getStatusList(), ['class'=>'form-select']) ?>
                            <?php endif; ?>

                            <?= $form->field($model, 'tag')->textInput(['maxlength' => true]) ?>

                            <?= $form->field($model, 'color')->widget(\kartik\color\ColorInput::className(), [ 'options' => ['readonly' => true] ]) ?>
<!--                            --><?php //= $form->field($model, 'background_color')->widget(\kartik\color\ColorInput::className(), [ 'options' => ['readonly' => true] ]) ?>

                            <?= $form->field($model, 'tag_icon')->widget(yeesoft\media\widgets\FileInput::className(), [
                                'name' => 'tag_icon',
                                'buttonTag' => 'button',
                                'buttonName' => Yii::t('site', 'Browse'),
                                'buttonOptions' => ['class' => 'btn btn-default btn-file-input'],
                                'options' => ['class' => 'form-control for-img'],
                                'template' => '<div class="tag_icon-image thumbnail"></div><div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                                'thumb' => $this->context->module->thumbnailSize,
                                'imageContainer' => '.tag_icon-image',
                                'pasteData' => yeesoft\media\widgets\FileInput::DATA_URL,
                                'callbackBeforeInsert' => 'function(e, data) {
                                        $(".tag_icon-image").show();
                                    }',
                            ]) ?>

                            <?= $form->field($model, 'campaign_report')->widget(yeesoft\media\widgets\FileInput::className(), [
                                'name' => 'campaign_report',
                                'buttonTag' => 'button',
                                'buttonName' => Yii::t('site', 'Browse'),
                                'buttonOptions' => ['class' => 'btn btn-default btn-file-input'],
                                'options' => ['class' => 'form-control for-img'],
                                'template' => '<div class="campaign_report-image thumbnail"></div><div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                                'thumb' => $this->context->module->thumbnailSize,
                                'imageContainer' => '.campaign_report-image',
                                'pasteData' => yeesoft\media\widgets\FileInput::DATA_URL,
                                'callbackBeforeInsert' => 'function(e, data) {
                                        $(".campaign_report-image").show();
                                    }',
                            ]) ?>

                            <?=
                                $form->field($model, 'is_recurring')->checkbox();
                            ?>

                            <?=
                                $form->field($model, 'has_amount')->checkbox();
                            ?>


                        <?=
                                $form->field($model, 'has_goal')->checkbox();
                            ?>
                            <?=
                            $form->field($model, 'promote_to_payment_page')->checkbox();
                            ?>

                            <?=
                                $form->field($model, 'raised')->textInput(['maxlength' => true, 'type' => 'number'])
                            ?>

                            <?=
                                $form->field($model, 'goal')->textInput(['maxlength' => true, 'type' => 'number'])
                            ?>

                            <?=
                                $form->field($model, 'goal_achieved')->textInput(['maxlength' => true])
                            ?>

                            <?= $form->field($model, 'weight')->textInput(['type' => 'number']) ?>


                            <?php if (!$model->isNewRecord): ?>
                                <?php $form->field($model, 'created_by')->dropDownList(User::getUsersList(), ['class'=>'form-select']) ?>
                            <?php endif; ?>
                            <?= $form->field($model, 'sitemap_priority') ?>

                            <?=
                                $this->render('//common/_seo_inputs', ["seoModel" => $seoModel, "form"=>$form]);
                            ?>


                        </div>
                    </div>
                </div>


            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>


<?php

$this->registerJsVar('donation_type', \backend\modules\donation_types\models\DonationTypes::class);
$this->registerJsVar('campaign_type', \backend\modules\campaigns\models\Campaign::class);

?>

<?php
$script = <<< JS
$('.dynamic_form_3').find('.container-items_group').addClass('row');
$('.dynamic_form_parents').find('.container-parents_group').addClass('row');
$('.dynamic_form_4').find('.container-items_group').addClass('row');

$(".dynamic_form_2").on('afterInsert', function(e, item) {
    $(item).find('input.parent-index').val($(item).parent().data('parent-index'))
})
JS;
$this->registerJs($script);
?>
