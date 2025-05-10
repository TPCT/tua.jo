<?php

use yii\widgets\Pjax;

$this->params['mainIdName'] = "secondary-users";
$this->title = Yii::t('site', 'Card Settings');
$this->registerCssFile("/theme/css/account-settings.css", ['depends' => [\frontend\assets\AppAsset::className()]]);
$this->registerCssFile("/theme/css/card-settings.css", ['depends' => [\frontend\assets\AppAsset::className()]]);
?>
<script src="<?=\frontend\components\HyperPay::PAYMENT_URL?>/paymentWidgets.js?checkoutId=<?=$checkoutId?>" nonce="aRXTe2xDwSL010jDbcUSt6DBZZNSmTGwBFKCBz2qdH5i4x1igZRCGz93vvPETnqt" crossorigin="anonymous"></script>

<div class="add-card">
    <h4 class="mb-3"><?=Yii::t('site', 'ADD_YOUR_CARD')?></h4>
    <div class="add-card-content">
        <?php if ($message = Yii::$app->session->getFlash('add-card-status')): ?>
            <div class="badge bg-danger">
                <span class="text-white"><?=$message['message']?></span>
            </div>
        <?php endif ?>
        <div class="card-info">
            <div class="card-info-header">
                <p><?=Yii::t('site', 'YOUR_NAME')?></p>
                <div>
                    <picture>
                        <img src="/theme/assets/Images/login/visa-small.png" alt="">
                    </picture>
                    <span>/</span>
                    <picture>
                        <img src="/theme/assets/Images/login/master-small.png" alt="">
                    </picture>
                </div>
            </div>
            <div class="card-info-body">
                <span><?=Yii::t('site', 'CARD_NUMBER')?></span>
                <p>XXXX XXXX XXXX 1234</p>
            </div>
            <div class="card-info-footer">
                <div>
                    <span><?=Yii::t('site', 'MONTH')?>/<?=Yii::t('site', 'YEAR')?></span>
                    <p><?=date('m')?>/<?=date('y')?></p>
                </div>
                <div>
                    <span><?=Yii::t('site', 'CVV')?></span>
                    <p>XXX</p>
                </div>
            </div>
        </div>
        <form action="<?=\yii\helpers\Url::to(['/account/card-settings/payment-handler/'], true)?>" class="paymentWidgets" data-brands="VISA MASTER AMEX"></form>

</div>
