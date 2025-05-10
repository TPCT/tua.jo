<?php

use backend\modules\countries\models\Country;
use kartik\depdrop\DepDrop;
use yeesoft\helpers\Html;
use yeesoft\media\widgets\TinyMce;
use yeesoft\models\User;
use yeesoft\page\models\Page;
use yeesoft\widgets\ActiveForm;
use yeesoft\widgets\LanguagePills;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model yeesoft\page\models\Page */
/* @var $form yeesoft\widgets\ActiveForm */
?>

<div class="page-form">

    <?php
    $form = ActiveForm::begin([
        'id' => 'page-form',
        'validateOnBlur' => false,
    ]);

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
                    <?= $form->field($model, 'second_title')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'brief')->textarea(['maxlength' => true]) ?>

                    <?= $form->field($model, 'keywords')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'video')->widget(yeesoft\media\widgets\FileInput::className(), [
                        'name' => 'video',
                        'buttonTag' => 'button',
                        'buttonName' => Yii::t('yee', 'Browse'),
                        'buttonOptions' => ['class' => 'btn btn-default btn-file-input'],
                        'options' => ['class' => 'form-control for-img'],
                        'template' => '<div class="video thumbnail"></div><div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                        'thumb' => $this->context->module->thumbnailSize,
                        'imageContainer' => '.video',
                        'pasteData' => yeesoft\media\widgets\FileInput::DATA_URL,
                        'callbackBeforeInsert' => 'function(e, data) {
                                    $(".video").show();
                                }',
                    ])
                        ?>

                    <?= $form->field($model, 'header_image')->widget(yeesoft\media\widgets\FileInput::className(), [
                        'name' => 'header_image',
                        'buttonTag' => 'button',
                        'buttonName' => Yii::t('yee', 'Browse'),
                        'buttonOptions' => ['class' => 'btn btn-default btn-file-input'],
                        'options' => ['class' => 'form-control for-img'],
                        'template' => '<div class="header_image thumbnail"></div><div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                        'thumb' => $this->context->module->thumbnailSize,
                        'imageContainer' => '.header_image',
                        'pasteData' => yeesoft\media\widgets\FileInput::DATA_URL,
                        'callbackBeforeInsert' => 'function(e, data) {
                                    $(".header_image").show();
                                }',
                    ])
                        ?>

                    <?= $form->field($model, 'header_image_title')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'header_image_brief')->textarea(['maxlength' => true]) ?>


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



                    <?= $form->field($model, 'footer_content')->widget(TinyMce::className(), [
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


                        <?php endif; ?>

                        <div class="form-group">
                            <?php if ($model->isNewRecord): ?>
                                <?= Html::submitButton(Yii::t('yee', 'Create'), ['class' => 'btn btn-primary']) ?>
                                <?= Html::a(Yii::t('yee', 'Cancel'), ['/page/default/index'], ['class' => 'btn btn-default',]) ?>
                            <?php else: ?>
                                <?= Html::submitButton(Yii::t('yee', 'Save'), ['class' => 'btn btn-primary']) ?>

                                <?=
                                    $this->render('//common/_preview-button', ["model" => $model, "with_preview" => true, "front_url" => ""]);
                                ?>

                                <?=
                                    Html::a(Yii::t('yee', 'Delete'), ['/page/default/delete', 'id' => $model->id], [
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

                        <?php if ($model->canMakerSeeStatus()): ?>
                            <?= $form->field($model, 'status')->dropDownList(\common\helpers\Utility::getStatusList(), ['class' => 'form-select']) ?>
                        <?php endif; ?>

                        <?php if (!$model->isNewRecord): ?>
                            <?php $form->field($model, 'created_by')->dropDownList(User::getUsersList(), ['class' => 'form-select']) ?>
                        <?php endif; ?>

                        <?= $form->field($model, 'view')->dropDownList($this->context->module->viewList, ['class' => 'form-select']) ?>

                        <?= $form->field($model, 'layout')->dropDownList($this->context->module->layoutList, ['class' => 'form-select']) ?>

                        <div class="page-bms-section <?= ($model->view == "page_bms") ? "" : "d-none" ?> ">
                            <?=
                                $form->field($model, 'bms_category_id')->dropDownList($model->getBmsCategoryList(), ['prompt' => 'Select Bms', 'class' => 'form-select'])
                                ?>
                        </div>



                        <?= $form->field($model, 'image')->widget(yeesoft\media\widgets\FileInput::className(), [
                            'name' => 'image',
                            'buttonTag' => 'button',
                            'buttonName' => Yii::t('yee', 'Browse'),
                            'buttonOptions' => ['class' => 'btn btn-default btn-file-input'],
                            'options' => ['class' => 'form-control for-img'],
                            'template' => '<div class="page-image thumbnail"></div><div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                            'thumb' => $this->context->module->thumbnailSize,
                            'imageContainer' => '.page-image',
                            'pasteData' => yeesoft\media\widgets\FileInput::DATA_URL,
                            'callbackBeforeInsert' => 'function(e, data) {
                                        $(".page-image").show();
                                    }',
                        ])
                            ?>

                        <?php try {

                            echo $form->field($model, 'country_id')->dropDownList(
                                ArrayHelper::map(Country::find()->all(), 'id', 'title'),
                                [
                                    'id' => 'country-id',
                                    'prompt' => 'Select Country',
                                ]
                            );


                            echo $form->field($model, 'city_id')->widget(DepDrop::classname(), [
                                'options' => ['id' => 'city-id'],
                                'pluginOptions' => [
                                    'depends' => ['country-id'],
                                    'placeholder' => 'Select City',
                                    'url' => Url::to(['list']),
                                    'initialize' => true,
                                ],
                                'data' => [$model->city_id => $model->city ? $model->city->title : ''],
                            ]);
                        } catch (\yii\base\InvalidConfigException $e) {
                        } ?>

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
$js = <<<JS

    $(document).on("change","#page-view",function(){
        if($(this).val() == "page_bms" )
        {
            console.log($(this).val());
            $("#page-bms_category_id").val(null);
            $(".page-bms-section").removeClass("d-none");
            
        }
        else
        {
            $("#page-bms_category_id").val(null);
            $(".page-bms-section").addClass("d-none");
        }
    
    });
    

JS;
$this->registerJs($js, yii\web\View::POS_END);
?>