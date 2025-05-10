<?php

use yeesoft\helpers\Html;
use yeesoft\media\models\Category;
use yeesoft\widgets\ActiveForm;
use yeesoft\widgets\LanguagePills;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model yeesoft\media\models\Album */
/* @var $form yeesoft\widgets\ActiveForm */
?>

<div class="album-form">

    <?php
    $form = ActiveForm::begin([
        'id' => 'album-form',
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

                    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

                    <?= $form->field($model, 'cover_image')->widget(yeesoft\media\widgets\FileInput::className(), [
                        'name' => 'cover_image',
                        'buttonTag' => 'button',
                        'buttonName' => Yii::t('yee', 'Browse'),
                        'buttonOptions' => ['class' => 'btn btn-default btn-file-input'],
                        'options' => ['class' => 'form-control'],
                        'template' => '<div class="album-cover_image thumbnail"></div><div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                        'thumb' => 'original',
                        'imageContainer' => '.album-cover_image',
                        'pasteData' => yeesoft\media\widgets\FileInput::DATA_URL,
                        'callbackBeforeInsert' => 'function(e, data) {
                                $(".album-cover_image").show();
                            }',
                    ]) ?>
                </div>

            </div>
        </div>

        <div class="col-md-3">

            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="record-info">
                        <?= $form->field($model, 'category_id')->dropDownList(Category::getCategories(true), ['prompt' => '', 'class'=>'form-select']) ?>
                        <?php $form->field($model, 'created_at')
                            ->widget(DatePicker::className(), [
                                'dateFormat' => 'yyyy-MM-dd',
                                'options' => [
                                    'class' => 'form-control',
                                ]
                            ]) ?>
                        <?= $form->field($model, 'visible')->checkbox() ?>

                        <div class="form-group">
                            <?php if ($model->isNewRecord): ?>
                                <?= Html::submitButton(Yii::t('yee', 'Create'), ['class' => 'btn btn-primary']) ?>
                                <?= Html::a(Yii::t('yee', 'Cancel'), ['/media/album/index'], ['class' => 'btn btn-default']) ?>
                            <?php else: ?>
                                <?= Html::submitButton(Yii::t('yee', 'Save'), ['class' => 'btn btn-primary']) ?>
                                <?= Html::a(Yii::t('yee', 'Delete'), ['/media/album/delete', 'id' => $model->id], [
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

        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php


$js = <<<JS
    var image = $("#album-cover_image").val();
    if(image.length == 0){
        $('.album-cover_image').hide();
    } else {
        $('.album-cover_image').html('<img src="' + image + '" />');
    }
JS;

$this->registerJs($js, yii\web\View::POS_END);
?>
