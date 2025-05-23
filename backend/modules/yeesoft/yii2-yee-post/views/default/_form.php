<?php

use dosamigos\fileupload\FileUploadUI;
use kartik\widgets\FileInput;
use yeesoft\helpers\Html;
use yeesoft\media\widgets\TinyMce;
use yeesoft\models\User;
use yeesoft\post\models\Category;
use yeesoft\post\models\Post;
use yeesoft\widgets\ActiveForm;
use yeesoft\widgets\LanguagePills;
use yii\jui\DatePicker;
use yeesoft\post\widgets\MagicSuggest;
use yeesoft\post\models\Tag;

/* @var $this yii\web\View */
/* @var $model yeesoft\post\models\Post */
/* @var $form yeesoft\widgets\ActiveForm */
?>

    <div class="post-form">

        <?php
        $form = ActiveForm::begin([
            'id' => 'post-form',
            'validateOnBlur' => false,
        ])
        ?>

        <div class="row">
            <div class="col-md-9">

                <div class="panel panel-default">
                    <div class="panel-body">

                        <?php if ($model->isMultilingual()): ?>
                            <?= LanguagePills::widget() ?>
                        <?php endif; ?>

                        <?= $form->field($model, 'author_name')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'brief')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'tagValues')->widget(MagicSuggest::className(), ['items' => Tag::getTags()]); ?>

                        <?= $form->field($model, 'content')->widget(TinyMce::className(), [
                            'clientOptions' => [
                                'height' => 400,
                                'image_dimensions' => true,
                                'entity_encoding' => 'raw',                             'force_br_newlines' => true,                             'force_p_newlines' => false,                             'forced_root_block' => '',
                                'plugins' => [
                                    'directionality code print preview fullpage searchreplace autolink directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists textcolor wordcount imagetools   contextmenu colorpicker textpattern',
                                ],
                                'toolbar' => 'undo redo | styleselect fontsizeselect bold italic | ltr rtl | alignleft aligncenter alignright alignjustify bullist numlist outdent indent | pagebreak link image table | forecolor backcolor | removeformat | code',

                            ]
                        ]); ?>

                        <?php try {
                            $fileModel = new yeesoft\media\models\Media();
                            echo
                            FileUploadUI::widget([
                                'model' => $fileModel,
                                'attribute' => 'file',
                                'url' => ['/media/manage/upload'],
                                'gallery' => true,
                                'fieldOptions' => [
                                    'accept' => 'image/*'
                                ],
                                'clientOptions' => [
                                    'maxFileSize' => 2000000
                                ],
                                // ...
                                'clientEvents' => [
                                    'fileuploaddone' => 'function(e, data) {
                                    var result = data.result;
                                    var file = result.files[0];
                                    console.log(file.url);
                                    $(\'<input>\').attr({
                                        value: file.url,
                                        type: \'hidden\',
                                        name: \'Post[images][]\'
                                    }).appendTo(\'form\');

                                          
                                }',
                                    'fileuploadfail' => 'function(e, data) {

                                }',
                                ],
                            ]);
                        } 
                        catch (Exception $e) 
                        {
                            error_log($e->getMessage());
                        }
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
                                    <?= Html::a(Yii::t('yee', 'Cancel'), ['index'], ['class' => 'btn btn-default']) ?>
                                <?php else: ?>
                                    <?= Html::submitButton(Yii::t('yee', 'Save'), ['class' => 'btn btn-primary']) ?>
                                    <?= Html::a(Yii::t('yee', 'Delete'), ['delete', 'id' => $model->id], [
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
                            <?= $form->field($model, 'category_id')->dropDownList(Category::getCategories(), ['prompt' => '', 'encodeSpaces' => true, 'class'=>'form-select' ]) ?>

                            <?= $form->field($model, 'published_at')
                                ->widget(DatePicker::className(), ['dateFormat' => 'yyyy-MM-dd', 'options' => ['class' => 'form-control']]); ?>

                            <?php if( $model->canMakerSeeStatus() ): ?>
                                <?= $form->field($model, 'status')->dropDownList(\common\helpers\Utility::getStatusList(), ['class'=>'form-select'] ) ?>
                            <?php endif; ?>
                        

                            <?php if (!$model->isNewRecord): ?>
                                <?= $form->field($model, 'created_by')->dropDownList(User::getUsersList(), ['class'=>'form-select'] ) ?>
                            <?php endif; ?>

                            <?= $form->field($model, 'comment_status')->dropDownList(Post::getCommentStatusList(), ['class'=>'form-select'] ) ?>

                            <?= $form->field($model, 'view')->dropDownList($this->context->module->viewList, ['class'=>'form-select'] ) ?>

                            <?= $form->field($model, 'layout')->dropDownList($this->context->module->layoutList, ['class'=>'form-select'] ) ?>

                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="record-info">
                            <?= $form->field($model, 'thumbnail')->widget(yeesoft\media\widgets\FileInput::className(), [
                                'name' => 'image',
                                'buttonTag' => 'button',
                                'buttonName' => Yii::t('yee', 'Browse'),
                                'buttonOptions' => ['class' => 'btn btn-default btn-file-input'],
                                'options' => ['class' => 'form-control'],
                                'template' => '<div class="post-thumbnail thumbnail"></div><div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                                'thumb' => $this->context->module->thumbnailSize,
                                'imageContainer' => '.post-thumbnail',
                                'pasteData' => yeesoft\media\widgets\FileInput::DATA_URL,
                                'callbackBeforeInsert' => 'function(e, data) {
                                $(".post-thumbnail").show();
                            }',
                            ]) ?>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
<?php
$css = <<<CSS
.ms-ctn .ms-sel-ctn {
    margin-left: -6px;
    margin-top: -2px;
}
.ms-ctn .ms-sel-item {
    color: #666;
    font-size: 14px;
    cursor: default;
    border: 1px solid #ccc;
}
CSS;

$js = <<<JS
    var thumbnail = $("#post-thumbnail").val();
    if(thumbnail.length == 0){
        $('.post-thumbnail').hide();
    } else {
        $('.post-thumbnail').html('<img src="' + thumbnail + '" />');
    }
JS;

$this->registerCss($css);
$this->registerJs($js, yii\web\View::POS_READY);
?>