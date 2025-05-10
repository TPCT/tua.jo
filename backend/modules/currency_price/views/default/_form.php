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

                        <?=
                            $form->field($model, 'published_at')
                                ->widget(DatePicker::className(), ['dateFormat' => 'yyyy-MM-dd', 'options' => ['class' => 'form-control']]);
                        ?>

                        <?= $form->field($model, 'currency_id')->dropDownList($model->getCurrencyList(),["prompt"=>"Select Currency", 'class'=>'form-select' ]) ?>
                        
                        <?= $form->field($model, 'sell_price')->widget(NumberControl::classname(), [
                            'name' => 'normal-decimal',
                            "value" => round($model->sell_price, 3),
                                'displayOptions' => [
                                    'placeholder' => '100'
                                ],
                                'maskedInputOptions' => [
                                    'min' => 0,
                                    'suffix' => ' JOD',
                                    'rightAlign' => false,
                                    'digits' => 3,
                                ],
                            ]); 
                        ?>

                        <?= $form->field($model, 'buy_price')->widget(NumberControl::classname(), [
                            'name' => 'normal-decimal',
                            "value" => round($model->buy_price, 3),
                                'displayOptions' => [
                                    'placeholder' => '100'
                                ],
                                'maskedInputOptions' => [
                                    'min' => 0,
                                    'suffix' => ' JOD',
                                    'rightAlign' => false,
                                    'digits' => 3,
                                ],
                            ]); 
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


                            <?php if( $model->canMakerSeeStatus() ): ?>
                                <?= $form->field($model, 'status')->dropDownList(CurrencyPrice::getStatusList(), ['class'=>'form-select'] ) ?>
                            <?php endif; ?>


                            <?php if (!$model->isNewRecord): ?>
                                <?php $form->field($model, 'created_by')->dropDownList(User::getUsersList(), ['class'=>'form-select'] ) ?>
                            <?php endif; ?>

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