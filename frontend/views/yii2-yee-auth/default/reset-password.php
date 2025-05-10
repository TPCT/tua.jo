<?php

use kartik\widgets\ActiveForm;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var yeesoft\auth\models\forms\ConfirmSmsForm $smsConfirm
 */
$this->title = Yii::t('site', 'Confirm E-mail');


$lng = Yii::$app->language;
$this->beginBlock('inner-banner-text');
echo "<h1></h1>";
$this->endBlock();

?>



<!-- Start Banner -->
<?php $this->beginBlock('top-banner'); ?>
<div class="inner_banner">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2><?= Yii::t('site', 'Reset Password') ?></h2>
            </div>
        </div>
    </div>
</div>
<?php $this->endBlock(); ?>
<!-- End Banner -->



<div class="commonpage ">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
              <div class="commonpage_gapping2 registerpage">  
                
                <hr class="spacer30px"/>
                
                <!--Start Contact Form-->
                <?php
                $form = ActiveForm::begin([
                    'type' => 'horizontal',
                    'id' => 'user',
                    'options' => ['autocomplete' => 'off',
                        'class' => 'form-horizontal'
                    ],
                    'enableAjaxValidation' => false,
                    'enableClientValidation' => false,
//                    'action' => ['/auth/confirm-registration-sms'],
                    'formConfig' => ['labelSpan' => 3],
                ]);

                ?>
                <div class="GrayBox">
                    <!--form group-->
                    <?= $form->field($model, 'username')->label(Yii::t('site', 'Username'))->textInput(['maxlength' => 255, 'autofocus' => false]) ?>
                    <div class="form-group ConfirmationPart">
                        <div class="col-sm-12">
                            <!-- <label class="control-label">سؤال تأكيدي</label> -->
                            <div class="ConfirmationBox">
                                <section class="row">
                                    <!-- <p>هذا السؤال للتأكد أنك مستخدم حقيقي.</p> -->
                                    <?= $form->field($model, 'reCaptcha', [
//
                                    ])->widget(\himiklab\yii2\recaptcha\ReCaptcha::className())->label(''); ?>
                                </section>
                            </div>
                            <?= Html::submitButton(Yii::t('site', 'Send'), ['class' => 'btn btn-success btn-lg']) ?>
                        </div>
                    </div>
                </div>


                <?php ActiveForm::end() ?>
                <!--End Contact Form-->
                
                
             </div>   
            </div>
        </div>
    </div>
</div>
