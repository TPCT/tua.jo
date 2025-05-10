<?php

/**
 * @var $this yii\web\View
 * @var $model yeesoft\auth\models\forms\LoginForm
 */

use kartik\widgets\ActiveForm;
use szaboolcs\recaptcha\InvisibleRecaptcha;
use yii\helpers\Html;

$this->title = Yii::t('site', 'Reset Password');

?>


<div class="container content-content">
    <div class="loginOuter">
        <h2 class="text-center"><?= Yii::t('site', 'Reset Password') ?></h2>
        <?php $form = ActiveForm::begin([
            'id' => 'update-form',
            'options' => ['autocomplete' => 'off'],
            'validateOnBlur' => false,
        ]) ?>

        <?php if ($model->scenario != 'restoreViaEmail'): ?>
            <?= $form->field($model, 'current_password')->textInput(['placeholder' => $model->getAttributeLabel('current_password'),])->passwordInput(['maxlength' => 255]) ?>
        <?php endif; ?>

        <?= $form->field($model, 'password')->label(false)->passwordInput(['placeholder' => $model->getAttributeLabel('password'), 'maxlength' => 255]) ?>

        <?= $form->field($model, 'repeat_password')->label(false)->passwordInput(['placeholder' => $model->getAttributeLabel('repeat_password'), 'maxlength' => 255]) ?>

        <?= Html::submitButton(Yii::t('site', 'Update'), ['class' => 'btn btn-lg btn-primary btn-block']) ?>

        <?php ActiveForm::end() ?>
    </div>
</div>

