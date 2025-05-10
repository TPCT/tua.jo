<?php

use yeesoft\helpers\Html;
use yeesoft\widgets\ActiveForm;
use yeesoft\widgets\LanguagePills;
use kartik\select2\Select2;
use yeesoft\models\Menu;

/* @var $this yii\web\View */
/* @var $model yeesoft\models\Menu */
/* @var $form yeesoft\widgets\ActiveForm */
?>

<div class="menu-form">

    <?php
    $form = ActiveForm::begin([
        'id' => 'menu-form',
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

                        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'weight')->dropDownList(array_combine(range(-10, 10), range(-10, 10)), ['class'=>'form-select'] ) ?>

                        <?php if ($model->isNewRecord): ?>
                            <?= $form->field($model, 'id')->textInput(['maxlength' => true]) ?>
                        <?php endif; ?>

                    </div>
                </div>
            </div>

            <div class="col-md-3">

                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="record-info">

                            <?php if (!$model->isNewRecord): ?>
                                <div class="form-group">
                                    <label class="control-label" style="float: left; padding-right: 5px;">
                                        <?= $model->attributeLabels()['id'] ?> :
                                    </label>
                                    <span><?= $model->id ?></span>
                                </div>
                            <?php endif; ?>

                            <div class="form-group">
                                <?php if ($model->isNewRecord): ?>

                                    <?= Html::submitButton(Yii::t('yee', 'Create'), ['class' => 'btn btn-primary']) ?>
                                    <?= Html::a(Yii::t('yee', 'Cancel'), ['/menu/default/index'], ['class' => 'btn btn-default']) ?>

                                <?php else: ?>

                                    <?= Html::submitButton(Yii::t('yee', 'Save'), ['class' => 'btn btn-primary']) ?>
                                    <?= Html::a(Yii::t('yee', 'Delete'), ['/menu/default/delete', 'id' => $model->id], [
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
                        
                            <?= $form->field($model, 'category_slug')->widget(\kartik\select2\Select2::className(), [
                                    'options' => ['placeholder' => ''],
                                    'pluginOptions' => [
                                        'allowClear' => true,
                                        'multiple' => false
                                    ],
                                    'theme'=> Select2::THEME_BOOTSTRAP,
                                    'data' => Menu::getCategoryList()
                                ]);
                            ?>

                            <?= $form->field($model, 'active_header_url')->textInput(['maxlength' => true]) ?>

                            <?php if( $model->canMakerSeeStatus() ): ?>
                                <?= $form->field($model, 'status')->dropDownList(Menu::getStatusList(), ['class'=>'form-select'] ) ?>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>

            </div>
        </div>

    <?php ActiveForm::end(); ?>

</div>
