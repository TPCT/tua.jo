<?php

$this->registerCssFile("/theme/css/Payment-method.css", ['depends' => [\frontend\assets\AppAsset::className()],]);
use yii\helpers\Url;
use kartik\form\ActiveForm;

$this->title = Yii::t("site", 'CARD_TITLE');
$this->description = Yii::t("site", 'CARD_DESCRIPTION');


$lng = Yii::$app->language;
?>
<?= \frontend\widgets\breadcrumbs\BreadCrumbs::widget([]) ?>

<section>
    <div class="payment-method-container container">
        <form action="<?=Url::to(['/payment/'])?>" method="post" id="payment-form">
            <input type="hidden" name="<?=Yii::$app->request->csrfParam?>" value="<?=Yii::$app->request->csrfToken?>" />
            <h3><?=Yii::t('site', 'DONATION_DETAILS')?></h3>
            <?php if (!Yii::$app->user->isGuest): ?>
                <p><?=Yii::t('site', 'SELECT_DONATION_USER')?> <span class="red-astrik">*</span></p>
                <select name="donor" id="">
                    <?php foreach ($users as $user): ?>
                        <option value="<?=$user['type']?>|<?=$user['guid']?>"><?=$user['name']?></option>
                    <?php endforeach; ?>
                </select>
            <?php endif; ?>
            <div class="donation-table-wrapper container">
                <table>
                    <thead>
                    <tr>
                        <th>
                            <p><?=Yii::t('site', 'DETAILSE')?></p>
                        </th>
                        <th>
                            <p class="donation-amount">
                                <?=Yii::t('site', 'DONATION_AMOUNT')?>
                            </p>
                        </th>
                        <th>
                            <p class="donation-quantity"><?=Yii::t('site', 'QUANTITTU')?></p>
                        </th>
                        <th>
                            <p class="donation-total"><?=Yii::t('site', 'TOTAL')?></p>
                        </th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cart as $guid => $item): ?>
                            <tr>
                                <td>
                                    <div class="donation-detail">
                                        <?= \frontend\widgets\WebpImage::widget(["src" => $item['image'], "alt" => $item['title'], "loading" => "lazy", 'css' => ""]) ?>

                                        <div>
                                            <h4><?=$item['title']?></h4>
                                            <?php if ($item['recurrence'] == "once"): ?>
                                                <h5><?=Yii::t('site', 'ONE_TIME_PAYMENT')?></h5>
                                            <?php elseif ($item['recurrence'] == "monthly"): ?>
                                                <h5><?=Yii::t('site', 'MONTHLYPAYMENT_')?></h5>
                                            <?php else: ?>
                                                <h5><?=Yii::t('site', 'YEARLY_PAYMENT')?></h5>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                                <td class="item-amount">
                                    <?=$item['amount']?>
                                </td>
                                <td class="controls">
                                    <div class="quantity-control">
                                        <button type="button" class="quantity-btn minus" data-guid="<?=$guid?>">−</button>
                                        <h4 class="quantity"><?=$item['quantity']?></h4>
                                        <button type="button" class="quantity-btn plus" data-guid="<?=$guid?>">+</button>
                                    </div>
                                </td>
                                <td class="item-total"><?=$item['total']?></td>
                                <td>
                                    <button class="remove-item" data-guid="<?=$guid?>" type="button">
                                        <svg width="34" height="34" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M23.6291 23.6296C23.4181 23.8405 23.132 23.9591 22.8336 23.9591C22.5353 23.9591 22.2491 23.8405 22.0381 23.6296L17 18.5914L11.9619 23.6296C11.7509 23.8405 11.4647 23.9591 11.1664 23.9591C10.868 23.9591 10.5819 23.8405 10.3709 23.6296C10.1599 23.4186 10.0414 23.1324 10.0414 22.8341C10.0414 22.5357 10.1599 22.2496 10.3709 22.0386L15.409 17.0004L10.3709 11.9623C10.1599 11.7513 10.0414 11.4652 10.0414 11.1668C10.0414 10.8684 10.1599 10.5823 10.3709 10.3713C10.5819 10.1603 10.868 10.0418 11.1664 10.0418C11.4647 10.0418 11.7509 10.1603 11.9619 10.3713L17 15.4094L22.0381 10.3713C22.2491 10.1603 22.5353 10.0418 22.8336 10.0418C23.132 10.0418 23.4181 10.1603 23.6291 10.3713C23.8401 10.5823 23.9586 10.8684 23.9586 11.1668C23.9586 11.4652 23.8401 11.7513 23.6291 11.9623L18.591 17.0004L23.6291 22.0386C23.8401 22.2496 23.9586 22.5357 23.9586 22.8341C23.9586 23.1324 23.8401 23.4186 23.6291 23.6296Z" fill="#FAFAFA"></path>
                                        </svg>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </form>
        <div class="donation-summary-container">
            <div class="donation-summary-box">
                <div class="donation-summary-header">
                    <h3><?=Yii::t('site', 'DONATION_SUMMARY')?></h3>
                </div>
                <div class="donation-summary-body">
                    <div>
                        <p><?=Yii::t('site', 'TOTAL_DONATION_SCHEMA')?></p>
                        <p class="items-count"><?=$total_donation_scheme?></p>
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
            <?php if ($payment = Yii::$app->session->getFlash('payment-status')): ?>
                <div class="badge <?=$payment['status'] ? "bg-success" : "bg-danger"?> mt-3 w-100">
                    <span class="text-white"><?=$payment['message']?></span>
                </div>
            <?php endif; ?>

            <div class="payment-method-container-btns flex-wrap">
                <div class="d-flex gap-3 w-100">
                    <?php if (count($cart)): ?>
                        <button type="submit" class="type-3-btn w-100" form="payment-form" id="donate-now">
                            <span><?=Yii::t('site', 'DONATE_SECUROTY')?></span>
                        </button>
                    <?php endif; ?>
                    <a class="type-5-btn w-100" href="<?=Url::to(['/site/index#homepage-donation-section'])?>">
                        <span><?=Yii::t('site', 'KEEP_GIVING')?></span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php

$this->registerJsVar('language', Yii::$app->language);
$js = <<<JS
    $(".minus").on('click', function(){
        let row = $(this).closest('tr');
        $.ajax({
            url: "/" + language + "/cart/decrement/" + $(this).data('guid'),
            type: 'GET',
            success: function(response){
                row.find('td.item-amount').text(response['item']['amount'])
                row.find('td.controls .quantity').text(response['item']['quantity']);
                row.find('td.item-total').text(response['item']['total']);
                $(".sub-total").text(response['sub_total']);
                $(".total").text(response['total']);
            }
        })
    });

    $(".plus").on('click', function(){
        let row = $(this).closest('tr');
        $.ajax({
            url: "/" + language + "/cart/increment/" + $(this).data('guid'),
            type: 'GET',
            success: function(response){
                row.find('td.item-amount').text(response['item']['amount'])
                row.find('td.controls .quantity').text(response['item']['quantity']);
                row.find('td.item-total').text(response['item']['total'])
                $(".sub-total").text(response['sub_total']);
                $(".total").text(response['total']);
            }
        })
    });

    $(".remove-item").on("click", function() {
        $.ajax({
            url: "/" + language + "/cart/delete/" + $(this).data('guid'),
            type: "GET",
            success: function (response) {
                $(".cart-items-count").text(response['cart_items_count']);
                $(".items-count").text(response['items_count']);    
                $(".sub-total").text(response['sub_total']);
                $(".total").text(response['total']);
                if (!response['items_count']){
                    $("#donate-now").hide();
                    return;
                }
                $("#donate-now").show();
            }
        });
        $(this).parent().parent().remove();
    });
JS;

$this->registerJs($js, \yii\web\View::POS_END);

?>