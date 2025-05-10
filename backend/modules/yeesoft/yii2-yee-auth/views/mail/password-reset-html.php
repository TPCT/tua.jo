<?php
/**
 * @var $this yii\web\View
 * @var $user yeesoft\models\User
 */

use common\helpers\Utility;
use yii\helpers\Html;

$token =  Utility::encrypt_decrypt('encrypt', $user->confirmation_token);

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['/auth/default/reset-password-request', 'token' => $token]);

?>

<div class="password-reset">
    <p>Hello <?= Html::encode($user->username) ?>,</p>

    <p>Follow the link below to reset your password:</p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>