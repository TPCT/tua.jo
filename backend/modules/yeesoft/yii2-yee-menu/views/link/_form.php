<?php

use common\helpers\Utility;
use yeesoft\helpers\Html;
use yeesoft\helpers\FA;
use yeesoft\models\Menu;
use yeesoft\widgets\ActiveForm;
use yeesoft\widgets\LanguagePills;

/* @var $this yii\web\View */
/* @var $model yeesoft\menu\models\MenuLink */
/* @var $form yeesoft\widgets\ActiveForm */
?>

<div class="menu-link-form">

    <?php
    $form = ActiveForm::begin([
        'id' => 'menu-link-form',
        'validateOnBlur' => true,
        'encodeErrorSummary' => false,
                'errorSummaryCssClass' => 'help-block alert alert-danger',
                'options' => ['autocomplete' => 'off'],
            ]); ?>

            <?= $form->errorSummary($model) ?>

    <div class="row">
        <div class="col-md-9">

            <div class="panel panel-default">
                <div class="panel-body">

                    <?php if ($model->isMultilingual()): ?>
                        <?= LanguagePills::widget() ?>
                    <?php endif; ?>

                    <?= $form->field($model, 'label')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'brief')->textarea(['maxlength' => true]) ?>

                    <?php if ($model->isNewRecord): ?>
                        <?= $form->field($model, 'id')->textInput() ?>
                    <?php endif; ?>

                    

                    <?= $form->field($model, 'link')->textInput(['maxlength' => true]) ?>
                    
                    <?php // $form->field($model, 'order')->textInput() ?>

                    <?= $form->field($model, 'image')->widget(yeesoft\media\widgets\FileInput::className(), [
                        'name' => 'image',
                        'buttonTag' => 'button',
                        'buttonName' => Yii::t('site', 'Browse'),
                        'buttonOptions' => ['class' => 'btn btn-default btn-file-input'],
                        'options' => ['class' => 'form-control'],
                        'template' => '<div class="menulink-image thumbnail"></div><div class="input-group">{input}<span class="input-group-btn">{button}</span></div>',
                        'thumb' => 'original',
                        'imageContainer' => '.menulink-image',
                        'pasteData' => yeesoft\media\widgets\FileInput::DATA_URL,
                        'callbackBeforeInsert' => 'function(e, data) {
                                $(".menulink-image").show();
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
                                    <?= $model->attributeLabels()['id'] ?> :
                                </label>
                                <span><?= $model->id ?></span>
                            </div>
                        <?php endif; ?>
                        
                        <?= $form->field($model, 'alwaysVisible')->checkbox() ?>

                        <?= $form->field($model, 'is_prime')->checkbox() ?>
                        <?= $form->field($model, 'is_break')->checkbox() ?>
                        <?= $form->field($model, 'menu_color')->widget(\kartik\color\ColorInput::className(), [ 'options' => ['readonly' => true] ]) ?>


                        <?php if ($model->isNewRecord): ?>
                            <?php $menuID = Utility::sanitizeValue($_GET['menu_id']); ?>
                            <?= $form->field($model, 'menu_id')->dropDownList(Menu::getMenus(), ['class' => 'clearfix form-control form-select'
                            ,'options' => [ $menuID => ['Selected'=>'selected']], 'prompt' => ' -- Select Menu --']) ?>
                        <?php endif; ?>
                        
                        <?= $form->field($model, 'admin_icon')->dropDownList(FA::getIconsList(), [
                            'class' => 'clearfix form-control fa-font-family form-select',
                            'encode' => false,
                        ]) ?>

                        <?php echo  $form->field($model, 'position')->textInput() ?>
                        <?php echo  $form->field($model, 'additional_attributes')->textInput() ?>


                        <div class="form-group">
                            <?php if ($model->isNewRecord): ?>
                                <?= Html::submitButton(Yii::t('yee', 'Create'), ['class' => 'btn btn-primary']) ?>

                                <?= Html::a(Yii::t('yee', 'Cancel'), ['/menu/link/index'], ['class' => 'btn btn-default']) ?>
                            <?php else: ?>
                                <?= $form->field($model, 'menu_id')->dropDownList(Menu::getMenus(), ['class' => 'clearfix form-control form-select'
                            // ,'options' => [$_GET['menu_id'] => ['Selected'=> true]]
                            , 'prompt' => ' -- Select Menu --']) ?>
                                <?= Html::submitButton(Yii::t('yee', 'Save'), ['class' => 'btn btn-primary']) ?>
                                <?= Html::a(Yii::t('yee', 'Delete'),
                                    ['/menu/link/delete', 'id' => $model->id], [
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

        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<?php
$js = <<<JS

 var image = $("#menulink-image").val();
    if(image.length == 0){
        $('.menulink-image').hide();
    } else {
        $('.menulink-image').html('<img src="' + image + '" />');
    }
    
    
    $('#menulink-admin_icon-styler ul li').each(function(){
        var glyphicon = $(this).text();
        $(this).addClass('glyphicon').addClass('glyphicon-'+glyphicon).html('');
    });
    $('#menulink-admin_icon-styler ul li:first').html('No Icon');

    setTimeout(function(){
       
    },1000);
    

JS;
$this->registerJs($js);
?>