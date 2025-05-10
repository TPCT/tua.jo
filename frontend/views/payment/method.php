<?php

$this->title = Yii::t('site', 'Payment Methods');
$this->registerCssFile("/theme/css/payment-method-options.css", ['depends' => [\frontend\assets\AppAsset::className()]]);
?>

<script>
    var wpwlOptions = {
        locale: "<?=Yii::$app->language?>"
    }
</script>
<script src="<?=\frontend\components\HyperPay::PAYMENT_URL?>/paymentWidgets.js?checkoutId=<?=$checkout['data']['id']?>" crossorigin="anonymous"></script>

<?= \frontend\widgets\breadcrumbs\BreadCrumbs::widget([]) ?>

<section class="mb-5">
    <div class="container">
        <h3><?=Yii::t('site', 'CHOOSE_THE_PAYMENT_METHOD')?></h3>
    </div>
    <div class="container payment-method-container">
        <div class="choose-method-box">
            <div class="payment-method-box">
                <div>
                    <label for=""><?=Yii::t('site', 'Visa/Mastercard')?></label>
                    <input type="radio" name="payment" value="visa-mastercard" checked="checked">
                </div>
            </div>
            <div class="ecard-step-content">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="m-0"><?=Yii::t('site' , 'Pay with Visa / Mastercard')?></h4>
                    <div class=" d-flex">
                        <picture>
                            <img src="/theme/assets/Images/visa 1.png" alt="">
                        </picture>
                        <picture>
                            <img src="/theme/assets/Images/mastercard 1.png" alt="" srcset="">
                        </picture>
                    </div>
                </div>
                <?php if (!empty($cards)): ?>
                    <h4 class="mb-1"><?=Yii::t('site', 'You can pay with your added card')?></h4>
                    <?php foreach ($cards as $card): ?>
                        <form method="post" action="<?=\yii\helpers\Url::to(['/payment/cards/' . $card->id])?>">
                            <input type="hidden" name="<?=Yii::$app->request->csrfParam?>" value="<?=Yii::$app->request->csrfToken?>" />
                            <div class="d-flex mb-1">
                                <input type="hidden" name="card"/>
                                <button type="submit" class="type-3-btn card-buton">
                                        <span class="mx-1">
                                            <?php if ($card->type == "VISA"): ?>
                                                <picture>
                                                    <img src="/theme/assets/Images/visa 1.png" alt="" style="width: 50px !important; height: 30px !important;">
                                                </picture>
                                            <?php else: ?>
                                                <picture>
                                                    <img src="/theme/assets/Images/mastercard 1.png" alt="" srcset="" style="width: 50px !important; height: 30px !important;">
                                                </picture>
                                            <?php endif; ?>
                                        </span>
                                    <span class="">
                                            XXXX XXX XXXX <?=$card->last_four_digits?>
                                        </span>
                                </button>
                            </div>
                        </form>
                    <?php endforeach; ?>
                    <h4 class="mb-3"><?=Yii::t('site', 'Or use another card')?></h4>
                <?php endif; ?>
                <form action="<?=\yii\helpers\Url::to(['/payment/hyper-pay-handler/?type=cart'], true)?>" class="paymentWidgets mt-5" data-brands="VISA MASTER AMEX"></form>

            </div>
        </div>
        <div class="donation-summary-box">
            <div class="donation-summary-header">
                <h3><?=Yii::t('site', 'DONATION_SUMMARY')?></h3>
            </div>
            <div class="donation-summary-body">
                <div>
                    <p><?=Yii::t('site', 'TOTAL_DONATION_SCHEMA')?></p>
                    <p><?=$total_donation_scheme?></p>
                </div>
                <div>
                    <p><?=Yii::t('site', 'SUBTOTAL')?></p>
                    <p class="sub-total"><?=$sub_total?></p>
                </div>
            </div>
            <div class="donation-summary-footer">
                <h4><?=Yii::t('site', 'TOTAL')?></h4>
                <h4 class="total"><?=$total?></h4>
            </div>
            <div>

            </div>
        </div>
    </div>
</section>

<?php

$js = <<<JS
    $(".card-buton").on("click", function() {
        $(this).prop('disabled', true);
        $(this).closest('form').submit();
    })
JS;
$this->registerJs($js);

