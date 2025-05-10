<?php

use kartik\widgets\ActiveForm;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var yeesoft\auth\models\forms\ConfirmSmsForm $smsConfirm
 */
$this->title = Yii::t('site', 'Confirm E-mail');

$col12 = $this->context->module->gridColumns;
$col9 = (int)($col12 * 3 / 4);
$col6 = (int)($col12 / 2);
$col3 = (int)($col12 / 4);

$lng = Yii::$app->language;
$this->beginBlock('inner-banner-text');
echo "<h1>رمز التاكيد</h1>";
$this->endBlock();

?>


<section id="MainInner">
    <article class="container">
        <h2 class="InnerTitel">رمز التاكيد</h2>
        <div class="row">
            <aside class="col-sm-8">

                <!--Start Contact Form-->
                <?php
                $form = ActiveForm::begin([
                    'type' => 'horizontal',
                    'id' => 'user',
                    'options' => ['autocomplete' => 'off',
                        'class' => 'form-horizontal'
                    ],
                    'enableAjaxValidation' => true,
                    'enableClientValidation' => true,
                    'action' => ['/auth/confirm-registration-sms'],
                    'formConfig' => ['labelSpan' => 3],
                ]);
                echo $form->field($smsConfirm, 'token')->hiddenInput()->label(false)

                ?>
                <div class="GrayBox">
                    <!--form group-->
                    <?= $form->field($smsConfirm, 'sms')->textInput(['maxlength' => 255, 'autofocus' => false]) ?>


                </div>

                <?= Html::submitButton(Yii::t('site', 'إرسال'), ['class' => 'btn btn-success btn-lg']) ?>

                <?php ActiveForm::end() ?>
                <!--End Contact Form-->

            </aside>
        </div>
    </article>
</section>