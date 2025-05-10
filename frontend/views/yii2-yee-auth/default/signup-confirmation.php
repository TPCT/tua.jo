<?php

/**
 * @var yii\web\View $this
 * @var yeesoft\models\User $user
 */

$this->title = Yii::t('yee/auth', 'Registration - confirm your e-mail');
$this->params['breadcrumbs'][] = $this->title;
?>


<div class="close-botton"><a href="/"><img src="/images/close-button.png"/></a></div>
<div class="tabs">
    <ul>
        <li><a class="sign-in active"><?= Yii::t('site', 'Confirm your e-mail') ?></a></li>
    </ul>
</div>
<div class="tabs-content">
    <div id="sign-in" class="tab-content active">



        <div class="registration-wait-for-confirmation">

                <h3><?= Yii::t('yee/auth', 'Check your e-mail {email} for instructions to activate account', [
                    'email' => '<b>' . $user->email . '</b>'
                ]) ?>
                </h3>

        </div>

    </div>
</div>
