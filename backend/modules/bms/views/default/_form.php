<?php

use backend\modules\bms\models\Bms;
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
use wbraganca\dynamicform\DynamicFormWidget;

use yeesoft\helpers\FA;

/* @var $this yii\web\View */
/* @var $model Bms */
/* @var $form yeesoft\widgets\ActiveForm */
?>

    <div class="page-form">

        <?php
        $form = ActiveForm::begin([
            'id' => 'page-form',
            'validateOnBlur' => true,
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

                        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'second_title')->textInput(['maxlength' => true]) ?>

                        
                        <?= $form->field($model, 'brief')->textarea(['maxlength' => true]) ?>

                        <?= $form->field($model, 'content')->widget(TinyMce::className(), [
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
                        
                        
                        <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>
                        
                        <?= $form->field($model, 'image')->widget(yeesoft\media\widgets\FileInput::className(), [
                            'name' => 'image',
                            'buttonTag' => 'button',
                            'buttonName' => Yii::t('site', 'Browse'),
                            'buttonOptions' => ['class' => 'btn btn-default btn-file-input'],
                            'options' => ['class' => 'form-control for-img'],
                            'template' => '<div class="bms-image thumbnail"></div><div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                            'thumb' => $this->context->module->thumbnailSize,
                            'imageContainer' => '.bms-image',
                            'is_multiple'=> false,
                            'pasteData' => yeesoft\media\widgets\FileInput::DATA_URL,
                            'callbackBeforeInsert' => 'function(e, data) {
                                $(".bms-image").show();
                            }',
                        ]) ?>

                        <?= $this->render('//common/_image_object_fit_inputs.php', ['model'=> $model, 'form'=>$form]) ?>

                        <?= $form->field($model, 'mobile_image')->widget(yeesoft\media\widgets\FileInput::className(), [
                            'name' => 'mobile_image',
                            'buttonTag' => 'button',
                            'buttonName' => Yii::t('site', 'Browse'),
                            'buttonOptions' => ['class' => 'btn btn-default btn-file-input'],
                            'options' => ['class' => 'form-control for-img'],
                            'template' => '<div class="bms-mobile_image thumbnail"></div><div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                            'thumb' => $this->context->module->thumbnailSize,
                            'imageContainer' => '.bms-mobile_image',
                            'is_multiple'=> false,
                            'pasteData' => yeesoft\media\widgets\FileInput::DATA_URL,
                            'callbackBeforeInsert' => 'function(e, data) {
                                $(".bms-mobile_image").show();
                            }',
                        ]) ?>

                    </div>
                </div>



                <div class="panel panel-default">
                    <div class="panel-body">

                        <div class="row">
                            <div class="col-md-4">
                                <?= $form->field($model, 'button_text')->textInput(['maxlength' => true]) ?>
                            </div>
                            <div class="col-md-4">
                                <?= $form->field($model, 'url_1')->textInput(['maxlength' => true]) ?>
                            </div>
                            <div class="col-md-4">
                                <?= 
                                    $form->field($model, 'button_image_1')->widget(yeesoft\media\widgets\FileInput::className(), [
                                        'name' => 'image_1',
                                        'buttonTag' => 'button',
                                        'buttonName' => Yii::t('site', 'Browse'),
                                        'buttonOptions' => ['class' => 'btn btn-default btn-file-input'],
                                        'options' => ['class' => 'form-control'],
                                        'template' => '<div class="bms-button_image_1 thumbnail"></div><div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                                        'thumb' => $this->context->module->thumbnailSize,
                                        'imageContainer' => '.bms-button_image_1',
                                        'pasteData' => yeesoft\media\widgets\FileInput::DATA_URL,
                                        'is_multiple'=> false,
                                        'callbackBeforeInsert' => 'function(e, data) {
                                            $(".bms-button_image_1").show();
                                        }',
                                    ]) 
                                ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <?= $form->field($model, 'button_2_text')->textInput(['maxlength' => true]) ?>
                            </div>
                            <div class="col-md-4">
                                <?= $form->field($model, 'url_2')->textInput(['maxlength' => true]) ?>
                            </div>
                            <div class="col-md-4">
                                <?= 
                                    $form->field($model, 'button_image_2')->widget(yeesoft\media\widgets\FileInput::className(), [
                                        'name' => 'image_2',
                                        'buttonTag' => 'button',
                                        'buttonName' => Yii::t('site', 'Browse'),
                                        'buttonOptions' => ['class' => 'btn btn-default btn-file-input'],
                                        'options' => ['class' => 'form-control'],
                                        'template' => '<div class="bms-button_image_2 thumbnail"></div><div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                                        'thumb' => $this->context->module->thumbnailSize,
                                        'imageContainer' => '.bms-button_image_2',
                                        'is_multiple'=> false,
                                        'pasteData' => yeesoft\media\widgets\FileInput::DATA_URL,
                                        'callbackBeforeInsert' => 'function(e, data) {
                                            $(".bms-button_image_2").show();
                                        }',
                                    ]) 
                                ?>
                            </div>
                        </div>

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
                            'model' => $model->bmsFeatureList[0],
                            'formId' => 'page-form',
                            'formFields' => [
                                '[]id',
                            ],
                        ]); ?>

                        <div class="row">
                            <div class="col-md-12">

                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h3 class="panel-title"><?= Yii::t('app', 'Diagnose Feature') ?></h3>


                                    </div>
                                    <div class="pull-right panel-body">
                                        <button type="button" class="add-item_group btn btn-success btn-sm">
                                            <i class="glyphicon glyphicon-plus"></i> <?= yii::t('app', 'Add') ?>
                                        </button>
                                    </div>
                                    <div class="clearfix"></div>
                                    <div class="clearfix"></div>

                                    <div class="container-items_group">
                                        <?php foreach ($model->bmsFeatureList as $chapterKey => $chapter): ?>
                                            <div class="item_group" pk="<?= $chapter->id ?>">
                                                <div class="panel-body">
                                                    <div class="row">
                                                        
                                                        
                                                        <div class="col-md-11">

                                                            <div class="col-md-12">
                                                                <?= $form->field($chapter, "[$chapterKey]id")->hiddenInput()->label(false); ?>
                                                            </div>

                                   
                                                            
                                                            <div class="col-md-12">
                                                                <?= $form->field($chapter, "[$chapterKey]title_en")->textInput(['maxlength' => true]) ?>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <?= $form->field($chapter, "[$chapterKey]title_ar")->textInput(['maxlength' => true]) ?>
                                                            </div>
                                   
                                                            
                                                            <div class="col-md-12">
                                                                <?= $form->field($chapter, "[$chapterKey]second_title_en")->textInput(['maxlength' => true]) ?>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <?= $form->field($chapter, "[$chapterKey]second_title_ar")->textInput(['maxlength' => true]) ?>
                                                            </div>
                                                            
                                                            <div class="col-md-12">
                                                                <?= $form->field($chapter, "[$chapterKey]brief_en")->textInput(['maxlength' => true]) ?>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <?= $form->field($chapter, "[$chapterKey]brief_ar")->textInput(['maxlength' => true]) ?>
                                                            </div>


                                                            <?= $form->field($chapter, "[$chapterKey]image")->widget(yeesoft\media\widgets\FileInput::className(), [
                                                                    'name' => 'image',
                                                                    'buttonTag' => 'button',
                                                                    'buttonName' => Yii::t('site', 'Browse'),
                                                                    'buttonOptions' => ['class' => 'btn btn-default btn-file-input'],
                                                                    'options' => ['class' => 'form-control'],
                                                                    'template' => '<div class="diagnose-image thumbnail"></div><div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                                                                    'thumb' => $this->context->module->thumbnailSize,
                                                                    'imageContainer' => ".diagnose-{$chapterKey}-image",
                                                                    'pasteData' => yeesoft\media\widgets\FileInput::DATA_URL,
                                                                    // 'callbackBeforeInsert' => 'function(e, data) {
                                                                    //     $(".diagnose-image").show();
                                                                    // }',
                                                                ]) ?>
                                                             </div>    
                                                             
                                                            
                                                            <div class="col-md-12">
                                                            <?= $form->field($chapter, "[$chapterKey]content_en")->widget(TinyMce::className(), [
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
                                                            ?>                                                            </div>
                                                            <div class="col-md-12">
                                                            <?= $form->field($chapter, "[$chapterKey]content_ar")->widget(TinyMce::className(), [
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

                        <div class="record-info">
                            
                            <?=
                            $form->field($model, 'published_at')
                                ->widget(DatePicker::className(), ['dateFormat' => 'yyyy-MM-dd', 'options' => ['class' => 'form-control']]);
                            ?>

                            <?= $form->field($model, 'category_slug')
                                ->widget(\kartik\select2\Select2::className(), [
                                    'options' => ['placeholder' => ''],
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                        'multiple' => false
                                    ],
                                    'theme'=> Select2::THEME_BOOTSTRAP,
                                    'data' => Bms::getCategoryList()
                                ]) ?>
                            <?php
                                $form->field($model, 'grid_size')->dropDownList(Bms::getGridSizeList(), ['class'=>'form-select'])
                            ?>
                    <?= $form->field($model, 'our_partner_id')->dropDownList( Bms::getOurPartnerList(false), ["prompt"=>"Select Category", 'class' => 'form-select'] ) ?>
                    <?= $form->field($model, 'donation_type_id')->dropDownList( \backend\modules\donation_programs\models\DonationProgram::getDonationTypes(false), ["prompt"=>"Select Category", 'class' => 'form-select'] ) ?>
                    <?= $form->field($model, 'campaign_id')->dropDownList( \backend\modules\donation_programs\models\DonationProgram::getCampaigns(true), ["prompt"=>"Select Category", 'class' => 'form-select'] ) ?>

                            <?php if( $model->canMakerSeeStatus() ): ?>
                                <?= $form->field($model, 'status')->dropDownList(Bms::getStatusList(), ['class'=>'form-select']) ?>
                            <?php endif; ?>

                            <?= $form->field($model, 'weight')->textInput(['type' => 'number']) ?>


                            <?= 
                                $form->field($model, 'video')->widget(yeesoft\media\widgets\FileInput::className(), [
                                    'name' => 'image_2',
                                    'buttonTag' => 'button',
                                    'buttonName' => Yii::t('site', 'Browse'),
                                    'buttonOptions' => ['class' => 'btn btn-default btn-file-input'],
                                    'options' => ['class' => 'form-control'],
                                    'template' => '<div class="bms-video thumbnail"></div><div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                                    'thumb' => $this->context->module->thumbnailSize,
                                    'imageContainer' => '.bms-video',
                                    'is_multiple'=> false,
                                    'pasteData' => yeesoft\media\widgets\FileInput::DATA_URL,
                                    'callbackBeforeInsert' => 'function(e, data) {
                                        $(".bms-video").show();
                                    }',
                                ]) 
                            ?>

                            <?= $form->field($model, 'icon')->dropDownList(FA::getIconsList(), [
                                'class' => 'clearfix form-control fa-font-family form-select',
                                'encode' => false,
                            ]) ?>
                            
                            <?php if (!$model->isNewRecord): ?>
                                <?php $form->field($model, 'created_by')->dropDownList(User::getUsersList(), ['class'=>'form-select']) ?>
                            <?php endif; ?>

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