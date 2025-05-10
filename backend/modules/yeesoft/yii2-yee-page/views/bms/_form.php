<?php

use backend\modules\bms\models\Bms;
use kartik\select2\Select2;
use yeesoft\helpers\Html;
use yeesoft\media\widgets\TinyMce;
use yeesoft\models\User;
use yeesoft\widgets\ActiveForm;
use yeesoft\widgets\LanguagePills;
use yii\base\InvalidConfigException;
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
        ]);
        echo $form->field($model, 'module_id')->hiddenInput()->label(false);
        echo $form->field($model, 'module_class')->hiddenInput()->label(false);
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
                        <?= $form->field($model, 'second_title')->textarea(['maxlength' => true]) ?>

                        <?= $form->field($model, 'brief')->widget(TinyMce::className(), [
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

                        <?= $form->field($model, 'image')->widget(yeesoft\media\widgets\FileInput::className(), [
                            'name' => 'image',
                            'buttonTag' => 'button',
                            'buttonName' => Yii::t('site', 'Browse'),
                            'buttonOptions' => ['class' => 'btn btn-default btn-file-input'],
                            'options' => ['class' => 'form-control'],
                            'template' => '<div class="bms-image thumbnail"></div><div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                            'thumb' => $this->context->module->thumbnailSize,
                            'imageContainer' => '.bms-image',
                            'pasteData' => yeesoft\media\widgets\FileInput::DATA_URL,
                            'callbackBeforeInsert' => 'function(e, data) {
                                $(".bms-image").show();
                            }',
                        ]) ?>

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
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <?= $form->field($model, 'button_2_text')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-md-4">
                            <?= $form->field($model, 'url_2')->textInput(['maxlength' => true]) ?>
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
                                    <?= Html::a(Yii::t('site', 'Cancel'), ['/bms/default/index'], ['class' => 'btn btn-default',]) ?>
                                <?php else: ?>
                                    <?= Html::submitButton(Yii::t('site', 'Save'), ['class' => 'btn btn-primary']) ?>
                                    <?=
                                    Html::a(Yii::t('site', 'Delete'), ['/bms/default/delete', 'id' => $model->id], [
                                        'class' => 'btn btn-default',
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

                            <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>

                           
                            <?=
                            $form->field($model, 'published_at')
                                ->widget(DatePicker::className(), ['dateFormat' => 'yyyy-MM-dd', 'options' => ['class' => 'form-control']]);
                            ?>

                            <?= $form->field($model, 'category_slug')->widget(\kartik\select2\Select2::className(), [
                                'options' => ['placeholder' => ''],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    'multiple' => false
                                ],
                                'theme'=> Select2::THEME_BOOTSTRAP,
                                'data' => Bms::getPageBmsList()
                            ]) ?>

                            <?php if( $model->canMakerSeeStatus() ): ?>
                                <?=
                                    $form->field($model, 'status')->dropDownList(Bms::getStatusList(), ['class'=>'form-select'] )
                                ?>
                            <?php endif; ?>
                            

                            <?php if (!$model->isNewRecord): ?>
                                <?php $form->field($model, 'created_by')->dropDownList(User::getUsersList(), ['class'=>'form-select'] ) ?>
                            <?php endif; ?>

                            <?= $form->field($model, 'weight')->textInput(['type' => 'number']) ?>

                            <?= $form->field($model, 'color')->widget(\kartik\color\ColorInput::className(), [ 'options' => ['readonly' => true] ]) ?>



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