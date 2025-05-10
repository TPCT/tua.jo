<?php

/**
 * @var $this yii\web\View
 * @var $model yeesoft\auth\models\forms\LoginForm
 */

use kartik\widgets\ActiveForm;
use yii\helpers\Html;

$this->title = Yii::t('site', 'LOGIN');

$col12 = $this->context->module->gridColumns;
$col9 = (int)($col12 * 3 / 4);
$col6 = (int)($col12 / 2);
$col3 = (int)($col12 / 4);

$lng = Yii::$app->language;

?>



<!-- Start Banner -->
<?php $this->beginBlock('top-banner'); ?>
<div class="inner_banner">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h2><?= Yii::t('site', 'Login') ?></h2>
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
              <div class="commonpage_gapping">  
                
                
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="loginpage">

                        <?php
                        $form = ActiveForm::begin([
                            'type' => 'horizontal',
                            'id' => 'BannerFormTop',
                            'options' => [
                                'autocomplete' => 'off',
                                'class' => ' loginpage'
                            ],
                            // 'enableAjaxValidation' => true,
                            // 'enableClientValidation' => true,
                            'action' => ['/auth/login'],
                            'formConfig' => ['labelSpan' => 12],
                        ])
                        ?>
                        <div class="GrayBox">
                            <!--form group-->
                            <?= $form->field($model, 'username')->textInput(['placeholder' => Yii::t('site', 'Username'), 'autocomplete' => 'off']) ?>

                            <?= $form->field($model, 'password')->passwordInput(['placeholder' => Yii::t('site', 'Password'), 'autocomplete' => 'off']) ?>

                        </div>
                        <li class="remember">
                            <?= $form->field($model, 'rememberMe')->checkbox(['value' => true])->label(Yii::t('site', 'Remember me')) ?>
                            <?= Html::a(Yii::t('site', 'Forgot Password?'), $url = '/auth/reset-password'); ?>
                        </li>
                            <?php $form->field($model, 'reCaptcha', [])->widget(\himiklab\yii2\recaptcha\ReCaptcha::className())->label(''); ?>
                        <li class="loginbtn">
                            <?= Html::submitButton(Yii::t('site', 'Login'), ['class' => 'btn login']) ?>
                        </li>
                        <li>
                            <?= Html::a(Yii::t('site', 'Register'), $url = '/auth/signup', ['class' => 'btn register']); ?>
                        </li>

                        <?php ActiveForm::end() ?>
                       </div> 
                    </div>
                </div>
                    
             </div>   
            </div>
        </div>
    </div>
</div>
