<?php

/**
 * @var $this yii\web\View
 * @var $model yeesoft\auth\models\forms\LoginForm
 */

use kartik\widgets\ActiveForm;
use yeesoft\auth\widgets\AuthChoice;
use yii\helpers\Html;

$this->title = Yii::t('yee/auth', 'Authorization');

$lng = Yii::$app->language;

?>
<div class="close-botton"><a href="<?= (Yii::$app->request->referrer); ?>"><img src="/images/close-button.png"/></a></div>
<div class="tabs">
    <ul>
        <li><a class="sign-in active"><?= Yii::t('site', 'Sign In') ?></a></li>
        <li><a class="register"><?= Yii::t('site', 'Register') ?></a></li>
    </ul>
</div>
<div class="tabs-content">
    <div id="sign-in" class="tab-content active">
        <?php
        $form = ActiveForm::begin([
            'id' => 'login-form',
            'options' => ['autocomplete' => 'off'],
            'validateOnBlur' => false,
            'fieldConfig' => [
                'template' => "{input}\n{error}",
            ],
        ])
        ?>

        <?= $form->field($model, 'username')->textInput(['placeholder' => $model->getAttributeLabel('username'), 'autocomplete' => 'off']) ?>

        <?= $form->field($model, 'password')->passwordInput(['placeholder' => $model->getAttributeLabel('password'), 'autocomplete' => 'off']) ?>

        <?= Html::submitButton(Yii::t('site', 'SIGN IN'), ['class' => 'btn btn-lg btn-primary btn-block']) ?>
        <div class="forget-password">
            <?= Html::a(Yii::t('site', "Forgot password?"), ['default/reset-password']) ?>
        </div>


        <?php ActiveForm::end() ?>

        <div class="sign-in-using">
            <h2><?= Yii::t('site', 'Or sign in USING') ?></h2>
            <?php
            try {
                echo \yii\authclient\widgets\AuthChoice::widget([
                    'baseAuthUrl' => ['/auth/default/oauth', 'language' => false],
                    'popupMode' => false,
                    'options' => [
                        'class' => 'social-icons'
                    ]
                ]);
            } catch (Exception $e) {
            }
            ?>
        </div>
    </div>
    <div id="register" class="tab-content">
        <?php
        $signUpModel = new \yeesoft\auth\models\forms\SignupForm();

        $form = ActiveForm::begin([
            'action' => ['default/signup'],
            'id' => 'signup',
            'enableClientValidation' => true,
            'enableAjaxValidation' => true,
//                            'validateOnBlur' => false,
            'options' => ['autocomplete' => 'off'],
            'fieldConfig' => [
                'template' => "{input}\n{error}",
            ],
        ]); ?>

        <?= $form->field($signUpModel, 'first_name')->textInput(['maxlength' => 50, 'placeholder' => $signUpModel->getAttributeLabel('first_name'), 'autocomplete' => 'off']) ?>
        <?= $form->field($signUpModel, 'last_name')->textInput(['maxlength' => 50, 'placeholder' => $signUpModel->getAttributeLabel('last_name'), 'autocomplete' => 'off']) ?>
        <?= $form->field($signUpModel, 'phone')->widget(\borales\extensions\phoneInput\PhoneInput::className(), [
            'jsOptions' => [
                'initialCountry' => 'JO', // auto not working
//                            'placeholderNumberType' => 'FIXED_LINE',
                'nationalMode' => false,
            ]
        ]) ?>


        <?= $form->field($signUpModel, 'email')->textInput(['maxlength' => 255, 'placeholder' => $signUpModel->getAttributeLabel('email'), 'autocomplete' => 'off']) ?>

        <?= $form->field($signUpModel, 'password')->passwordInput(['maxlength' => 255, 'placeholder' => $signUpModel->getAttributeLabel('password'), 'autocomplete' => 'off']) ?>

        <?= $form->field($signUpModel, 'repeat_password')->passwordInput(['maxlength' => 255, 'placeholder' => $signUpModel->getAttributeLabel('repeat_password'), 'autocomplete' => 'off']) ?>
        <?=
        $form->field($signUpModel, 'city_id')->label(false)->widget(\kartik\select2\Select2::className(), [
            'theme' => \kartik\select2\Select2::THEME_BOOTSTRAP,
            'size' => \kartik\select2\Select2::LARGE,
            'data' => \yii\helpers\ArrayHelper::map(\backend\modules\city\models\City::find()->innerJoinWith('translations')->orderBy("title")
                ->where(['status' => 1, 'language' => "{$lng}"])->all(), 'id', 'title'),
            'options' => [
                'placeholder' => Yii::t('site', 'Select City *'),
            ],
        ]);
        ?>
        <?= $form->field($signUpModel, 'captcha')->widget(\yii\captcha\Captcha::className(), [
            'options' => ['placeholder' => Yii::t('site', 'Enter verification code *')],

            'captchaAction' => [\yii\helpers\Url::to(['/auth/captcha'])]
        ]) ?>

        <?= Html::submitButton(Yii::t('site', 'SIGN UP'), ['class' => 'btn btn-lg btn-primary btn-block']) ?>
        <!---->
        <!--                        <form action="/action_page.php">-->
        <!--                            <input type="text" name="first-name" placeholder="Name">-->
        <!--                            <input type="text" name="email" placeholder="Email">-->
        <!--                            <input type="text" name="password" placeholder="Password">-->
        <!--                            <input type="text" name="number" placeholder="Number">-->
        <!--                            <button class="register" type="submit" value="register" name="">Register</button>-->
        <!--                        </form>-->
        <?php ActiveForm::end() ?>

    </div>
</div>
