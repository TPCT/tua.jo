<?php

use yii\widgets\Pjax;

$this->params['mainIdName'] = "secondary-users";
$this->title = Yii::t('site', 'Card Settings');
$this->registerCssFile("/theme/css/account-settings.css", ['depends' => [\frontend\assets\AppAsset::className()]]);
$this->registerCssFile("/theme/css/card-settings.css", ['depends' => [\frontend\assets\AppAsset::className()]]);
?>

<?php if (count($cards) == 0): ?>
<div class="empty-card">
    <h4 class="mb-3"><?=Yii::t('site', 'NO_CARDS')?></h4>
    <picture >
        <img src="/theme/assets/Images/login/Group.png" alt="">
    </picture>
    <a class="type-3-btn mt-5" href="<?=\yii\helpers\Url::to(['/account/card-settings/create'])?>" style="width: fit-content">
        <span ><?=Yii::t('site', 'ADD_YOUR_CARDS')?></span>
    </a>
</div>
<?php else : ?>
    <?php foreach ($cards as $card): ?>
        <div class="recent-card">
            <h4 class="mb-3"><?=Yii::t('site', 'RECENT_CARD')?></h4>
            <div class="add-card-content">
                <div class="card-info primary">
                    <div class="card-info-header">
                        <p><?=$card->holder?></p>
                        <div>
                            <?php if ($card->type == "VISA"): ?>
                                <picture>
                                    <img src="/theme/assets/Images/login/visa-small.png" alt="">
                                </picture>
                            <?php else: ?>
                                <picture>
                                    <img src="/theme/assets/Images/login/master-small.png" alt="">
                                </picture>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="card-info-body">
                        <span><?=Yii::t('site', 'CARD NUMBER')?></span>
                        <p>XXX XXXX XXXX <?=$card->last_four_digits?></p>
                    </div>
                    <div class="card-info-footer">
                        <div>
                            <span><?=Yii::t('site', 'MONTH')?>/<?=Yii::t('site', 'YEAR')?></span>
                            <p><?=$card->expiry_month?>/<?=$card->expiry_year?></p>
                        </div>
                        <div>
                            <span><?=Yii::t('site', 'CVV')?></span>
                            <p>XXX</p>
                        </div>
                    </div>
                </div>
                <form method="post" action="<?=\yii\helpers\Url::to(['/account/card-settings/delete'])?>" id="card-<?=$card->id?>">
                    <input type="hidden" name="<?=Yii::$app->request->csrfParam?>" value="<?=Yii::$app->request->csrfToken?>"/>
                    <input type="hidden" name="id" value="<?=$card->id?>" />
                </form>
            </div>
            <button class="type-6-btn mt-5" type="submit" form="card-<?=$card->id?>">
                <span ><?=Yii::t('site', 'REMOVE_CARD')?></span>
            </button>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
