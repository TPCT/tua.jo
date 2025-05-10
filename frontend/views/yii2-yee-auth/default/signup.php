<?php

use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var \yeesoft\auth\models\forms\SignupForm $model
 */
$this->title = Yii::t('site', 'Register');

$col12 = $this->context->module->gridColumns;
$col9 = (int)($col12 * 3 / 4);
$col6 = (int)($col12 / 2);
$col3 = (int)($col12 / 4);
?>

<!-- Start Banner -->
<?php $this->beginBlock('top-banner'); ?>
<div class="inner_banner">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2><?= Yii::t('site', 'Register') ?></h2>
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
                
                <?php $form = ActiveForm::begin([
                    'id' => 'signup',
                    'validateOnBlur' => false,
                    'enableAjaxValidation' => true,
                    'encodeErrorSummary' => false,
                    'errorSummaryCssClass' => 'help-block alert alert-danger',
                    'options' => ['autocomplete' => 'off'],
                ]); ?>

                <?= $form->errorSummary($model) ?>

                
                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'first_name')->textInput(['maxlength' => 50]) ?>
                    </div>
                    <div class="col-md-6">
                        
                    <?= $form->field($model, 'last_name')->textInput(['maxlength' => 50]) ?>
                    </div>
                </div>
                    
                    
                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'username')->textInput(['maxlength' => 50]) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>
                    </div>
                </div>
             
             
             <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'phone')->label(Yii::t('site', 'Phone'))->widget(\borales\extensions\phoneInput\PhoneInput::className(), [
                            'jsOptions' => [
                                'initialCountry' => 'JO', // auto not working
    //                            'placeholderNumberType' => 'FIXED_LINE',
                                'nationalMode' => false,
                            ]
                        ]) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'address')->textInput(['maxlength' => 255])->label(Yii::t('site', 'Address')) ?>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'password')->passwordInput(['maxlength' => 50]) ?>
                    </div>
                    <div class="col-md-6">
                        <?= $form->field($model, 'repeat_password')->passwordInput(['maxlength' => 255]) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <?= $form->field($model, 'reCaptcha', [])->widget(\himiklab\yii2\recaptcha\ReCaptcha::className())->label(''); ?>
                    </div>
                </div>
                
                <hr class="spacer30px"/><hr class="spacer30px"/>
                <div class="row justify-content-md-center">
                    

                    <div class="col col-md-6"><?= Html::submitButton(Yii::t('site', 'Register'), ['class' => 'btn-style-one']) ?></div>
                </div>

                    <?php ActiveForm::end() ?>
             
                
                
                
             </div>   
            </div>
        </div>
    </div>
</div>

<?php
$css = <<<CSS

#signup-wrapper {
    position: relative;
    top: 30%;
}
#signup-wrapper .registration-block {
    margin-top: 15px;
}

.registerpage input[type=text] {
    margin: 0px;
}

.help-block-error {
    color:red;
}
CSS;

$this->registerCss($css);
?>


















