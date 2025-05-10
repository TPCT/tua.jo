<?php

use common\components\custom_tiny_mce\CustomTinyMce;
use yeesoft\widgets\ActiveForm;
use yeesoft\helpers\Html;
use yeesoft\models\User;

/* @var $this yii\web\View */
/* @var $model backend\modules\newsletter\models\NewsletterCampaign */
/* @var $form yeesoft\widgets\ActiveForm */
?>

<div class="newsletter-campaign-form">

    <?php 
    $form = ActiveForm::begin([
            'id' => 'newsletter-campaign-form',
            'validateOnBlur' => false,
        ])
    ?>

    <div class="row">
        <div class="col-md-9">

            <div class="panel panel-default">
                <div class="panel-body">
                    
                    <?= $form->field($model, 'subject')->textInput(['maxlength' => true]) ?>


                    <?= $form->field($model, 'body')->widget(CustomTinyMce::className(),[
                           'clientOptions' => [
                            'height' => 600,
                            'image_dimensions' => true,
                            'entity_encoding' => 'raw',
                            'plugins' => 'print preview paste importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons bootstrap',

//                            'plugins' => [
//                                'directionality code print preview fullpage searchreplace autolink directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists  wordcount imagetools textpattern bootstrap',
//                            ],
//                            'toolbar' => 'undo redo | styleselect fontsizeselect bold italic | ltr rtl | alignleft aligncenter alignright alignjustify bullist numlist outdent indent | pagebreak link image table | forecolor backcolor | removeformat | code | bootstrap',
                            'toolbar' => 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | ltr rtl | bootstrap',

                            'bootstrapConfig' => [
                                'url' => '/js/tinymce/plugins/bootstrap/',
                                'iconFont' => 'fontawesome5',
                                // 'imagesPath' => '/demo/demo-images',
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
                        <div class="form-group clearfix">
                            <label class="control-label" style="float: left; padding-right: 5px;"><?=  $model->attributeLabels()['id'] ?>: </label>
                            <span><?=  $model->id ?></span>
                        </div>

                        <div class="form-group">
                            <?php  if ($model->isNewRecord): ?>
                                <?= Html::submitButton(Yii::t('yee', 'Create'), ['class' => 'btn btn-primary']) ?>
                                <?= Html::a(Yii::t('yee', 'Cancel'), ['/newsletter/campaign/index'], ['class' => 'btn btn-default']) ?>
                            <?php  else: ?>
                                <?= Html::submitButton(Yii::t('yee', 'Save'), ['class' => 'btn btn-primary']) ?>
                                <?= Html::a(Yii::t('yee', 'Delete'),
                                    ['/newsletter/campaign/delete', 'id' => $model->id], [
                                    'class' => 'btn btn-default',
                                    'data' => [
                                        'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                        'method' => 'post',
                                    ],
                                ]) ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-body">

                    <div class="record-info">
                        <?=
                        $form->field($model, 'start_date')
                            ->widget(\kartik\widgets\DateTimePicker::className(), ['options' => ['class' => 'form-control']]);
                        ?>

                        <?php if (!$model->isNewRecord): ?>
                            <?= $form->field($model, 'created_by')->dropDownList(User::getUsersList()) ?>
                        <?php endif; ?>

                    </div>
                </div>
            </div>

        </div>
    </div>

    <?php  ActiveForm::end(); ?>

</div>
