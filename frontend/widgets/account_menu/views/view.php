<?php if ($is_guest): ?>
    <a href="<?=\yii\helpers\Url::to(['/account/login'])?>">
        <span class="icon-container"></span>
        <div class="">
            <span><?=Yii::t('site', 'LOGIN')?></span>
        </div>
    </a>
<?php else: ?>
    <div class="currency-selector-wrapper accounts-selector-wrapper">
        <a class="currency-selector" id="account-selector">
            <span class="icon-container"></span>
            <div>
                <span class="selected-name"><?=$user->first_name?> <?=$user->last_name?></span>
                <i class="fa-solid fa-chevron-down"></i>
            </div>
        </a>

        <ul class="currency-dropdown" id="account-dropdown">
            <li><a href="<?=\yii\helpers\Url::to(['/account/profile'])?>"><?=Yii::t('site', 'MY_ACCOUNT')?></a></li>
            <li>
                <form action="<?=\yii\helpers\Url::to(['/account/logout'])?>" method="post" id="logout-form">
                    <input type="hidden" name="<?=Yii::$app->request->csrfParam?>" value="<?=Yii::$app->request->csrfToken?>"/>
                </form>
                <a id="logout-form-input">
                    <?=Yii::t('site', 'LOGOUT')?>
                </a>
            </li>
        </ul>
    </div>

<?php endif; ?>

<?php

$js = <<<js
    $("#logout-form-input").on('click', function (e) {
        e.preventDefault();
        $("#logout-form").submit()
    })
js;

$this->registerJs($js);
?>
