<?php

/**
 * @var yii\web\View $this
 * @var yeesoft\models\User $user
 */

$this->title = Yii::t('yee/auth', 'E-mail confirmed');
?>


<div class="close-botton"><a href="/"><img src="/images/close-button.png"/></a></div>
<div class="tabs">
    <ul>
        <li><a class="sign-in active"><?= Yii::t('site', 'E-mail confirmed') ?></a></li>
    </ul>
</div>
<div class="tabs-content">
    <div id="sign-in" class="tab-content active">


        <div class="change-own-password-success">

            <h3><?= Yii::t('site', 'E-mail confirmed') ?> - <b><?= $user->email ?></b></h3>

        </div>


    </div>
</div>
