<?php

use backend\modules\currency_price\models\CurrencyPrice;
use common\helpers\Utility;
use kartik\number\NumberControl;
use kartik\select2\Select2;
use yeesoft\helpers\Html;
use yeesoft\media\widgets\TinyMce;
use yeesoft\models\User;
use yeesoft\widgets\ActiveForm;
use yeesoft\widgets\LanguagePills;
use yii\jui\DatePicker;
use wbraganca\dynamicform\DynamicFormWidget;

/* @var $this yii\web\View */
/* @var $model CurrencyPrice */
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
                        <?= $form->field($model, 'num_code')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'alpha_2_code')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'alpha_3_code')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'en_short_name')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'ar_short_name')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'en_nationality')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'ar_nationality')->textInput(['maxlength' => true]) ?>

              


           
                        
                    </div>
                </div>

            </div>

            <div class="col-md-3">

                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="record-info">
     
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

                        <div class="record-info">


                      
                                <?= $form->field($model, 'status')->dropDownList(CurrencyPrice::getStatusList(), ['class'=>'form-select'] ) ?>
                


                       

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