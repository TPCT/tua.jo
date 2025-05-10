<?php

use yeesoft\helpers\Html;
use yeesoft\models\User;
use yeesoft\widgets\ActiveForm;
use yeesoft\widgets\LanguagePills;
use yii\helpers\ArrayHelper;
use yii\jui\DatePicker;
use kartik\number\NumberControl;

/* @var $this yii\web\View */
/* @var $model \backend\modules\merchant\models\Merchant */
/* @var $form yeesoft\widgets\ActiveForm */

?>

<div class="page-form">

    <?php
    $form = ActiveForm::begin([
        'id' => 'page-form',
        'validateOnBlur' => false,
    ]);
    ?>
    <?= $form->errorSummary($model, ['class' => 'alert alert-danger']); ?>

    <div class="row">
        <div class="col-md-9">

            <div class="panel panel-default">
                <div class="panel-body">

                    <?php if ($model->isMultilingual()): ?>
                        <?= LanguagePills::widget() ?>
                    <?php endif; ?>

                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'module')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'action')->textInput(['maxlength' => true]) ?>

                </div>
            </div>
        </div>

        <div class="col-md-3">

            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="record-info">
                        
                        <div class="form-group">
                            <?php if ($model->isNewRecord): ?>
                                <?= Html::submitButton(Yii::t('yee', 'Create'), ['class' => 'btn btn-primary']) ?>
                                <?= Html::a(Yii::t('yee', 'Cancel'), ['/user/route/index'], ['class' => 'btn btn-default',]) ?>
                            <?php else: ?>
                                <?= Html::submitButton(Yii::t('yee', 'Save'), ['class' => 'btn btn-primary']) ?>
                                <?=
                                Html::a(Yii::t('yee', 'Delete'), ['/user/route/delete', 'id' => $model->name], [
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

            <div class="panel panel-default">
                <div class="panel-body">

                    <div class="record-info">


                    </div>
                </div>
            </div>


        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>


<?php
$script = <<< JS
$(document).ready(function(){


    
});

JS;
$this->registerJs($script);
?>
