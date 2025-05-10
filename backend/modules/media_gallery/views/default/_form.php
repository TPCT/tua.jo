<?php

use yeesoft\helpers\Html;
use yeesoft\models\User;
use backend\modules\media_gallery\models\MediaGallery;
use common\helpers\Utility;
use yeesoft\widgets\ActiveForm;
use yeesoft\widgets\LanguagePills;
use yii\jui\DatePicker;
use dosamigos\fileupload\FileUploadUI;
use yii\bootstrap5\Modal;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model \backend\modules\media_gallery\models\MediaGallery */
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


                        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'brief')->textInput(['maxlength' => true]) ?>

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

                        <?= $this->render('//common/_image_object_fit_inputs.php', ['model'=> $model, 'form'=>$form]) ?>


                        <?= $form->field($model, 'header_image')->widget(yeesoft\media\widgets\FileInput::className(), [
                                    'name' => 'header_image',
                                    'buttonTag' => 'button',
                                    'buttonName' => Yii::t('yee', 'Browse'),
                                    'buttonOptions' => ['class' => 'btn btn-default btn-file-input'],
                                    'options' => ['class' => 'form-control for-img'],
                                    'template' => '<div class="post-header_image thumbnail"></div><div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                                    'thumb' => $this->context->module->thumbnailSize,
                                    'imageContainer' => '.post-header_image',
                                    'pasteData' => yeesoft\media\widgets\FileInput::DATA_URL,
                                    'callbackBeforeInsert' => 'function(e, data) {
                                    $(".post-header_image").show();
                                }',
                            ]) 
                        ?>

                        <div class="row">
                            <div class="col-md-6">
                                <?= $form->field($model, 'header_image_object_fit')->dropDownList(Utility::$objectFitArray,["prompt"=>"Select Header Object Fit"]) ?>
                            </div>
                            <div class="col-md-6">
                                <?= $form->field($model, 'header_image_object_position')->textInput(['maxlength' => true]) ?>
                            </div>
                        </div>

                        <?php $form->field($model, 'header_image_title')->textInput() ?>

                    </div>
                </div>


           
                <div class="panel panel-default">
                            <div class="panel-body">
                                <label for="">Images</label>

                                <?= $form->field($model, 'multiple_files')->widget(yeesoft\media\widgets\FileInput::className(), [
                                    'name' => 'image',
                                    'buttonTag' => 'button',
                                    'buttonName' => Yii::t('yee', 'Browse'),
                                    'buttonOptions' => ['class' => 'btn btn-default btn-file-input'],
                                    'options' => ['class' => 'form-control', ],
                                    'template' => '<div class="media_gallery_multiple_files-image thumbnail"></div><div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                                    'thumb' => $this->context->module->thumbnailSize,
                                    'imageContainer' => '.media_gallery_multiple_files-image',
                                    'pasteData' => yeesoft\media\widgets\FileInput::DATA_URL,
                                    'is_multiple' => true,
                                    'callbackBeforeInsert' => 'function(e, data) {
                                    $(".media_gallery_multiple_files-image").show();
                                }',
                                ]) ?>


                                <div class="panel-heading"><?php echo Yii::t('site', 'Files') ?></div>
                                <?php
                                $dataProvider = new \yii\data\ActiveDataProvider();
                                $dataProvider->query = $model->getAllFiles();

                                echo \kartik\grid\GridView::widget(['id' => 'places-grid',
                                    'dataProvider' => $dataProvider,
                                    'summary' => false,
                                    'columns' => [
                                        [
                                            'attribute' => 'filename',
                                            'format' => 'raw',
                                            'value' => function ($data)
                                            {
                                                return Html::a($data->media->filename, [$data->media->url], ['target' => '_blank'/*, 'download' => 'download'*/]);
                                            }
                                        ],
                                        [
                                            'attribute' => 'caption_en',
                                            'format' => 'raw',
                                            'value' => function ($data) {
                                                return Html::input('text', "caption_en[{$data->id}]", $data->caption_en, [
                                                    'class' => 'form-control caption_en-input',
                                                    'data-id' => $data->id,
                                                ]);
                                            }
                                        ],
                                        [
                                            'attribute' => 'caption_ar',
                                            'format' => 'raw',
                                            'value' => function ($data) {
                                                return Html::input('text', "caption_ar[{$data->id}]", $data->caption_ar, [
                                                    'class' => 'form-control caption_ar-input',
                                                    'data-id' => $data->id,
                                                ]);
                                            }
                                        ],
                                        [
                                            'attribute' => 'weight',
                                            'format' => 'raw',
                                            'value' => function ($data) {
                                                return Html::input('number', "weights[{$data->id}]", $data->weight, [
                                                    'class' => 'form-control weight-input',
                                                    'data-id' => $data->id,
                                                    'min' => 0, // You can set constraints here if needed
                                                ]);
                                            }
                                        ],
                                        [
                                            'attribute' => 'object_fit',
                                            'format' => 'raw',
                                            'value' => function ($data) {
                                                return Html::dropDownList( "object_fit[{$data->id}]", $data->object_fit,Utility::$objectFitArray, [
                                                    'class' => 'form-control object_fit-input',
                                                    'data-id' => $data->id,
                                                ]);
                                            }
                                        ],
                                        [
                                            'attribute' => 'object_position',
                                            'format' => 'raw',
                                            'value' => function ($data) {
                                                return Html::input('text', "object_position[{$data->id}]", $data->object_position, [
                                                    'class' => 'form-control object_position-input',
                                                    'data-id' => $data->id,
                                                ]);
                                            }
                                        ],
                                        [
                                            'attribute' => 'actions',
                                            'format' => 'raw',
                                            'value' => function ($data) use ($model) {
                                                return Html::a('Delete', ["/{$this->context->module->id}/default/delete-file", 'newsId' => $model->id, 'imgId' => $data->media->id,'lng'=>'en'], ['data' => [
                                                    'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                                    'method' => 'post',
                                                ],'data-method' => 'POST', 'class' => 'btn  btn-danger']);
                                            }
                                        ]
                                    ],]);
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
                                    <?= Html::a(Yii::t('yee', 'Cancel'), ["/{$this->context->module->id}/default/index"], ['class' => 'btn btn-default',]) ?>
                                <?php else: ?>
                                    <?= Html::submitButton(Yii::t('yee', 'Save'), ['class' => 'btn btn-primary']) ?>
                                    <?=
                                    Html::a(Yii::t('yee', 'Delete'), ["/{$this->context->module->id}/default/delete", 'id' => $model->id], [
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

                            <?= $form->field($model, 'promote_to_front')->checkbox() ?>

                            <?=
                                $form->field($model, 'category_id')->dropDownList(MediaGallery::getCategoryList(), ['prompt' => 'Select Category', 'class'=>'form-select'])
                            ?>


                            <?=
                            $form->field($model, 'published_at')
                                ->widget(DatePicker::className(), ['dateFormat' => 'yyyy-MM-dd', 'options' => ['class' => 'form-control']]);
                            ?>

                            <?php if( $model->canMakerSeeStatus() ): ?>
                                <?= $form->field($model, 'status')->dropDownList(\common\helpers\Utility::getStatusList(), ['class'=>'form-select'] ) ?>
                            <?php endif; ?>
                            
                            <?= $form->field($model, 'weight')->textInput(['type' => 'number']) ?>

                            
                            <?php if (!$model->isNewRecord): ?>
                                <?php $form->field($model, 'created_by')->dropDownList(User::getUsersList(), ['class'=>'form-select'] ) ?>
                            <?php endif; ?>


                            <?php $form->field($model, 'view')->dropDownList($this->context->module->viewList, ['class'=>'form-select'] ) ?>

                            <?php $form->field($model, 'layout')->dropDownList($this->context->module->layoutList, ['class'=>'form-select'] ) ?>

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
$frontUrlDomain = Yii::$app->params["FrontendUrlDomain"];
$js = <<<JS

$('#editModal').on('show.bs.modal', function (event) {
        // var frontUrlDomain = '$frontUrlDomain'; 
        var button = $(event.relatedTarget); 
        var mediaId = button.data('id');
        var filename = button.data('filename');
        var url = button.data('url');
        var title_en = button.data('title_en');
        var title_ar = button.data('title_ar');
        var description_en = button.data('description_en');
        var description_ar = button.data('description_ar');
        var publishedDate = button.data('published_date');

        var modal = $(this);
        modal.find('#media-id').val(mediaId);
        modal.find('#media-filename').val(filename);
        $('#media-url').val(url);
        modal.find('#media-image').attr('src',url);
        modal.find('#media-title-en').val(title_en);
        modal.find('#media-title-ar').val(title_ar);
        modal.find('#media-description-en').val(description_en);
        modal.find('#media-description-ar').val(description_ar);
        modal.find('#published-date').val(publishedDate);
    });

$('#save-btn').on('click', function () {
    var data = {
        media_id: document.querySelector('#media-id').value,
        // filename: document.querySelector('#media-filename').value, 
        // url: document.querySelector('#media-url').value, 
        title_en: document.querySelector('#media-title-en').value,
        title_ar: document.querySelector('#media-title-ar').value,
        description_en: document.querySelector('#media-description-en').value,
        description_ar: document.querySelector('#media-description-ar').value,
        published_date: document.querySelector('#published-date').value
    };
    

        
    
    $.ajax({
        url: '/media_gallery/default/update-media', 
        type: 'POST',
        data: data,
        success: function (response) {
            var jsonResponse = typeof response === "string" ? JSON.parse(response) : response;
            if (jsonResponse.status === 'success') {
                $('#editModal').modal('hide');
                $.pjax.reload({container: '#press-room-container'}); 
            } else {
                alert('An error occurred while saving.');
            }
        },
        error: function () {
            alert('An error occurred.');
        }
    });
});

JS;
$this->registerJs($js, yii\web\View::POS_END);
?>