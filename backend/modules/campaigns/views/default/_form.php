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
        <?= $form->errorSummary($model, ['class' => 'alert alert-danger']); ?>

        <div class="row">
            <div class="col-md-9">

                <div class="panel panel-default">
                    <div class="panel-body">

                        <?php if ($model->isMultilingual()): ?>
                            <?= LanguagePills::widget() ?>
                        <?php endif; ?>

                        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'cms_title')->textInput(['maxlength' => true]) ?>

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
                        <?= $form->field($model, 'guid')->textInput(['maxlength' => true , 'disabled'=>true]) ?>
                        <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'estimated_amount')->textInput(['maxlength' => true]) ?>

                        <?=
                        $form->field($model, 'start_date')
                            ->widget(DatePicker::className(), ['dateFormat' => 'yyyy-MM-dd', 'options' => ['class' => 'form-control']]);
                        ?>

                        <?=
                        $form->field($model, 'end_date')
                            ->widget(DatePicker::className(), ['dateFormat' => 'yyyy-MM-dd', 'options' => ['class' => 'form-control']]);
                        ?>
                        <?= $form->field($model, 'donation_type_id')->dropDownList($model->getDonationTypeList(), ["prompt" => "Select Category", 'class' => 'form-select']) ?>

                        <?=
                        $form->field($model, 'published_at')
                            ->widget(DatePicker::className(), ['dateFormat' => 'yyyy-MM-dd', 'options' => ['class' => 'form-control']]);
                        ?>

                        <?php if ($model->canMakerSeeStatus()): ?>
                            <?= $form->field($model, 'status')->dropDownList(Blogs::getStatusList(), ['class' => 'form-select']) ?>
                        <?php endif; ?>



                        <?= $form->field($model, 'weight')->textInput(['type' => 'number']) ?>


                        <?= $this->render('//common/_image_object_fit_inputs.php', ['model' => $model, 'form' => $form]) ?>

                        <?php if (!$model->isNewRecord): ?>
                            <?php $form->field($model, 'created_by')->dropDownList(User::getUsersList(), ['class' => 'form-select']) ?>
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


                        <?= $form->field($model, 'sitemap_priority') ?>


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