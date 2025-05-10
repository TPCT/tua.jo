<?php

use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var yeesoft\auth\models\forms\PasswordRecoveryForm $model
 */
$this->title = Yii::t('yee/auth', 'Reset Password');

?>

<?php if (Yii::$app->session->hasFlash('error')): ?>
    <div class="alert-alert-warning text-center">
        <?= Yii::$app->session->getFlash('error') ?>
    </div>
<?php endif; ?>




    <div class="close-botton"><a href="/"><img src="/images/close-button.png"/></a></div>
    <div class="tabs">
        <ul>
            <li><a class="sign-in active"><?= Yii::t('site', 'Reset Password') ?></a></li>
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

            <?= $form->field($model, 'email')->textInput(['placeholder' => $model->getAttributeLabel('email'), 'autocomplete' => 'off']) ?>

            <?= $form->field($model, 'captcha')->widget(\yii\captcha\Captcha::className(), [
                'options' => ['placeholder' => Yii::t('site', 'Enter verification code *')],

                'captchaAction' => [\yii\helpers\Url::to(['/auth/captcha'])]
            ]) ?>
            <?= Html::submitButton(Yii::t('site', 'Reset'), ['class' => 'btn btn-lg btn-primary btn-block']) ?>

            <?php ActiveForm::end() ?>

        </div>
    </div>

<?php
$css = <<<CSS
#update-wrapper {
	position: relative;
	top: 30%;
	margin: 45px;
}
CSS;

$this->registerCss($css);
?>