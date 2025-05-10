<?php

use kartik\widgets\ActiveForm;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var yeesoft\auth\models\forms\ConfirmSmsForm $smsConfirm
 */
$this->title = Yii::t('site', 'Reset Password');


$lng = Yii::$app->language;
$this->beginBlock('inner-banner-text');
echo "<h1></h1>";
$this->endBlock();

?>


<section id="MainInner">
    <article class="container">
        <h2 class="InnerTitel"></h2>
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
//                    'action' => ['/auth/confirm-registration-sms'],
                    'formConfig' => ['labelSpan' => 3],
                ]);

                ?>
                <div class="GrayBox">
                    <!--form group-->
                    <?= $form->field($model, 'sms')->label(Yii::t('site', 'SMS'))->textInput(['maxlength' => 255, 'autofocus' => false]) ?>
                    <?= $form->field($model, 'password')->passwordInput(['maxlength' => 255, 'autofocus' => false]) ?>
                    <?= $form->field($model, 'repeat_password')->passwordInput(['maxlength' => 255, 'autofocus' => false]) ?>
                    <div class="form-group ConfirmationPart">
                        <div class="col-sm-12">
                            <label class="control-label">سؤال تأكيدي</label>
                            <div class="ConfirmationBox">
                                <section class="row">
                                    <p>هذا السؤال للتأكد أنك مستخدم حقيقي.</p>
                                    <?= $form->field($model, 'reCaptcha', [
//
                                    ])->widget(\himiklab\yii2\recaptcha\ReCaptcha::className())->label(''); ?>
                                </section>
                            </div>
                        </div>
                    </div>
                </div>

                <?= Html::submitButton(Yii::t('site', 'إرسال'), ['class' => 'btn btn-success btn-lg']) ?>

                <?php ActiveForm::end() ?>
                <!--End Contact Form-->

            </aside>
        </div>
    </article>
</section>