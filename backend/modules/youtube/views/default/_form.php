<?php

use yeesoft\widgets\ActiveForm;
use backend\modules\youtube\models\YoutubeLinks;
use unclead\multipleinput\MultipleInput;
use yeesoft\helpers\Html;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model backend\modules\youtube\models\YoutubeLinks */
/* @var $form yeesoft\widgets\ActiveForm */
?>

<div class="youtube-form">

    <?php
    $form = ActiveForm::begin([
        'id' => 'youtube-form',
        'validateOnBlur' => false,
    ])
        ?>
    <?= $form->errorSummary($model, ['class' => 'alert alert-danger']); ?>


    <div class="row">
        <div class="col-md-9">

            <div class="panel panel-default">
                <div class="panel-body">

                    <?php if ($model->isMultilingual()): ?>
                        <?= \yeesoft\widgets\LanguagePills::widget() ?>
                    <?php endif; ?>
                    <?= $form->field($model, 'title')->textInput() ?>
                    <?= $form->field($model, 'brief')->textInput() ?>

                    <?= $form->field($model, 'slug')->textInput() ?>



                    <?= $form->field($model, 'media_path')->widget(yeesoft\media\widgets\FileInput::className(), [
                        'name' => 'media_path',
                        'buttonTag' => 'button',
                        'buttonName' => Yii::t('yee', 'Browse'),
                        'buttonOptions' => ['class' => 'btn btn-default btn-file-input'],
                        'options' => ['class' => 'form-control'],
                        'imageContainer' => '.youtubelinks-media_path',

                        'pasteData' => yeesoft\media\widgets\FileInput::DATA_URL,

                    ]) ?>
                    <?= $form->field($model, 'video_url')->textInput() ?>

                    <?= $form->field($model, 'cover_image')->widget(yeesoft\media\widgets\FileInput::className(), [
                        'name' => 'cover_image',
                        'buttonTag' => 'button',
                        'buttonName' => Yii::t('yee', 'Browse'),
                        'buttonOptions' => ['class' => 'btn btn-default btn-file-input'],
                        'options' => ['class' => 'form-control for-img'],
                        'template' => '<div class="youtubelinks-cover_image thumbnail"></div><div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                        'thumb' => $this->context->module->thumbnailSize,
                        'imageContainer' => '.youtubelinks-cover_image',
                        'pasteData' => yeesoft\media\widgets\FileInput::DATA_URL,
                        'callbackBeforeInsert' => 'function(e, data) {
                                $(".youtubelinks-cover_image").show();
                            }',
                    ]) ?>

                    <?= $this->render('//common/_image_object_fit_inputs.php', ['model'=> $model, 'form'=>$form]) ?>

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
                                <?= Html::submitButton(Yii::t('yee', 'Create'), ['class' => 'btn btn-primary']) ?>
                                <?= Html::a(Yii::t('yee', 'Cancel'), ["/{$this->context->module->id}/default/index"], ['class' => 'btn btn-default']) ?>
                            <?php else: ?>
                                <?= Html::submitButton(Yii::t('yee', 'Save'), ['class' => 'btn btn-primary']) ?>
                                <?= Html::a(
                                    Yii::t('yee', 'Delete'),
                                    ["/{$this->context->module->id}/default/delete", 'id' => $model->id],
                                    [
                                        'class' => 'btn btn-danger',
                                        'data' => [
                                            'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                            'method' => 'post',
                                        ],
                                    ]
                                ) ?>
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

                        <?= $form->field($model, 'promote_to_front')->checkbox() ?>

                        <?= $form->field($model, 'album_id')->dropDownList(YoutubeLinks::getAlbumList(), ['prompt' => 'Select Album', 'class' => 'form-select']) ?>

                        <?php if ($model->canMakerSeeStatus()): ?>
                            <?= $form->field($model, 'status')->dropDownList(\common\helpers\Utility::getStatusList(), ['class' => 'form-select']) ?>
                        <?php endif; ?>


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