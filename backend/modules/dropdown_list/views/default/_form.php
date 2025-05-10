<?php

use backend\modules\dropdown_list\models\DropdownList;
use kartik\number\NumberControl;
use yeesoft\helpers\Html;
use yeesoft\media\widgets\TinyMce;
use yeesoft\models\User;
use yeesoft\widgets\ActiveForm;
use yeesoft\widgets\LanguagePills;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model \backend\modules\news\models\News */
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
                        <?= $form->field($model, 'slug')->textInput(['maxlength' => true,'disabled' => true]) ?>

                        <?= $form->field($model, 'brief')->textarea(['maxlength' => true]) ?>

                        <?= $form->field($model, 'image')->widget(yeesoft\media\widgets\FileInput::className(), [
                                'name' => 'image',
                                'buttonTag' => 'button',
                                'buttonName' => Yii::t('site', 'Browse'),
                                'buttonOptions' => ['class' => 'btn btn-default btn-file-input'],
                                'options' => ['class' => 'form-control for-img'],
                                'template' => '<div class="dropdownlist-icon thumbnail"></div><div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                                'thumb' => 'original',
                                'imageContainer' => '.dropdownlist-icon',
                                'pasteData' => yeesoft\media\widgets\FileInput::DATA_URL,
                                'callbackBeforeInsert' => 'function(e, data) {
                                $(".dropdownlist-icon").show();
                            }',
                        ]) ?>

                        <?= $form->field($model, 'pdf_file')->widget(yeesoft\media\widgets\FileInput::className(), [
                                'name' => 'pdf_file',
                                'buttonTag' => 'button',
                                'buttonName' => Yii::t('site', 'Browse'),
                                'buttonOptions' => ['class' => 'btn btn-default btn-file-input'],
                                'options' => ['class' => 'form-control for-img'],
                                'template' => '<div class="dropdownlist-icon thumbnail"></div><div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                                'thumb' => 'original',
                                'imageContainer' => '.dropdownlist-icon',
                                'pasteData' => yeesoft\media\widgets\FileInput::DATA_URL,
                                'callbackBeforeInsert' => 'function(e, data) {
                                $(".dropdownlist-icon").show();
                            }',
                        ]) ?>

                        <?= $this->render('//common/_image_object_fit_inputs.php', ['model'=> $model, 'form'=>$form]) ?>

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
                                        <?= 'Slug' ?> :
                                    </label>
                                    <span><?= $model->slug ?></span>
                                </div>
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
       <?= $form->field($model, 'donation_type_id')->dropDownList( \backend\modules\donation_programs\models\DonationProgram::getDonationTypes(false), ["prompt"=>"Select Category", 'class' => 'form-select'] ) ?>
                    <?= $form->field($model, 'campaign_id')->dropDownList( \backend\modules\donation_programs\models\DonationProgram::getCampaigns(true), ["prompt"=>"Select Category", 'class' => 'form-select'] ) ?>

                            <?=
                                $form->field($model, 'category')->dropDownList(DropdownList::getCategoryList(), ['prompt' => 'Select Category', 'class'=>'form-select' ])
                            ?>

                            <div class="sub-category-section <?= (in_array($model->category,DropdownList::HAVE_SUB_CATEGORY))? "":"d-none" ?> ">
                                <?=
                                    $form->field($model, 'parent_id')->dropDownList(DropdownList::getSubCategoryList($model->category), ['prompt' => 'Select Parent', 'class'=>'form-select' ])
                                ?>
                            </div>

                            <?= $form->field($model, 'promote_to_front')->checkbox() ?>

                            <?php if( $model->canMakerSeeStatus() ): ?>
                                <?= $form->field($model, 'status')->dropDownList(DropdownList::getStatusList(), ['class'=>'form-select'] ) ?>
                            <?php endif; ?>

                            <?= $form->field($model, 'weight')->textInput(['type' => 'number']) ?>

                            <?= $form->field($model, 'color')->widget(\kartik\color\ColorInput::className(), [ 'options' => ['readonly' => true] ]) ?>

                            
                            <?php if (!$model->isNewRecord): ?>
                                <?php $form->field($model, 'created_by')->dropDownList(User::getUsersList(), ['class'=>'form-select'] ) ?>
                            <?php endif; ?>


                                                                                    
                            <?= $form->field($model, 'header_image')->widget(yeesoft\media\widgets\FileInput::className(), [
                            'name' => 'header_image',
                            'buttonTag' => 'button',
                            'buttonName' => Yii::t('yee', 'Browse'),
                            'buttonOptions' => ['class' => 'btn btn-default btn-file-input'],
                            'options' => ['class' => 'form-control'],
                            'template' => '<div class="page-image_header thumbnail"></div><div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                            'thumb' => $this->context->module->thumbnailSize,
                            'imageContainer' => '.page-header_image',
                            'pasteData' => yeesoft\media\widgets\FileInput::DATA_URL,
                            'callbackBeforeInsert' => 'function(e, data) {
                                $(".page-header_image.thumbnail").show();
                            }',
                        ]) ?>

                            <?= $form->field($model, 'header_mobile_image')->widget(yeesoft\media\widgets\FileInput::className(), [
                            'name' => 'header_mobile_image',
                            'buttonTag' => 'button',
                            'buttonName' => Yii::t('yee', 'Browse'),
                            'buttonOptions' => ['class' => 'btn btn-default btn-file-input'],
                            'options' => ['class' => 'form-control'],
                            'template' => '<div class="page-image_header thumbnail"></div><div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                            'thumb' => $this->context->module->thumbnailSize,
                            'imageContainer' => '.page-header_mobile_image',
                            'pasteData' => yeesoft\media\widgets\FileInput::DATA_URL,
                            'callbackBeforeInsert' => 'function(e, data) {
                                $(".page-header_mobile_image.thumbnail").show();
                            }',
                        ]) ?>

                        <?= $form->field($model, 'header_image_title')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'header_image_brief')->textInput(['maxlength' => true]) ?>
                     

                        </div>
                    </div>
                </div>


            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>



<?php


$js = <<<JS
    
    const RELATED_FEATURE =['Finance Inner Investment Type'];
    $(document).on("change","#dropdownlist-category",function(){
        if(RELATED_FEATURE.includes($(this).val()) )
        {
            console.log($(this).val());
            $("#dropdownlist-parent_id").val(null);
            $(".sub-category-section").removeClass("d-none");
            $.get("/dropdown_list/default/sub-category?category="+$(this).val(),function(data){
                console.log(data);
                $("#dropdownlist-parent_id").html(data);
            });
        }
        else
        {
            $("#dropdownlist-parent_id").val(null);
            $(".sub-category-section").addClass("d-none");
        }
    
    });
    
JS;

$this->registerJs($js, yii\web\View::POS_END);
?>