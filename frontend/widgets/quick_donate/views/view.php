<?php

use common\components\TuaClient;
use common\helpers\Utility;
use yii\helpers\Url;

$formID = uniqid('form-');
?>
<div class="floationg-quick-donation">
    <div class="floationg-quick-donation-toggle">
        <i class="fa-solid fa-heart"></i>
        <span> <?= Yii::t('site', 'QUICK_1') ?></span>
        <span><?= Yii::t('site', 'DONATION+1') ?></span>
    </div>
    <div class="floationg-quick-donation-card">


        <form id="<?= $formID ?>" class="form-quick-donation" method="post"
              action="<?= Url::to(['/cart/add']) ?>">
            <input type="hidden" name="<?= Yii::$app->request->csrfParam ?>"
                   value="<?= Yii::$app->request->csrfToken ?>"/>
            <input type="hidden" name="items[0][type]" value="1"/>
            <input type="hidden" name="items[0][donation]"
                   value="<?= TuaClient::PUBLIC_DONATIONS_TYPE_ID ?>"/>
            <input type="hidden" name="items[0][campaign]" value=""/>
            <input type="hidden" name="items[0][guid]" value="<?= uniqid('cart-item-') ?>"/>
            <input type="hidden" name="items[0][recurrence]" value="once" id="payment-recurrence-type"/>
            <input type="hidden" name="items[0][quantity]" value="1"/>
            <input type="hidden" name="items[0][currency]"
                   value="<?= Utility::selected_currency('slug') ?>"/>

            <h4><?= Yii::t('site', 'QUICKK_DONATION_FOR_FAMIILY') ?></h4>

            <h4><?= Yii::t('site', 'CHOOSE_THE_AMOUNT') ?></h4>
            <div class="donation-buttons">
                <button type="button">5</button>
                <button type="button">10</button>
                <button type="button">20</button>
                <button type="button">50</button>
            </div>
            <div class="amount-input">

                <input type="number" placeholder="<?= Yii::t('site', 'DONATION_AMOUNT') ?>" name="items[0][amount]" class="amount" required/>

            </div>
            <div class="error-message"
                 style="color: red; display: none; font-size: 14px; margin-top: 5px;"><?= Yii::t('site', 'PLEASE_ENTER_GREATER_THAT_ZERO') ?></div>
            <div class="send-eCard">
                <picture>
                    <img src="/theme/assets/Icons/Gift.svg" alt="">
                </picture>
                <a href="javascript:void(0);" id="send-eCard-link">
                    <?= Yii::t('site', 'SEND_E_CARD') ?>
                </a>

            </div>
            <div class=" floationg-quick-donation-card-donate-box">
                <button class="type-6-btn w-100" tabindex="0" onclick="addToCart('#<?= $formID ?>', true)">
                    <span><?= Yii::t('site', 'DONATE') ?></span></button>
                <button class="add-to-cart-btn" type="button" onclick="addToCart('#<?= $formID ?>')">
                    <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                                d="M26.2183 8.10906L23.4139 18.2022C23.2597 18.7535 22.9299 19.2396 22.4746 19.5866C22.0192 19.9336 21.4631 20.1226 20.8906 20.125H10.08C9.50582 20.1247 8.94747 19.9367 8.49012 19.5895C8.03277 19.2424 7.70152 18.7552 7.54688 18.2022L3.71 4.375H1.75C1.51794 4.375 1.29538 4.28281 1.13128 4.11872C0.967187 3.95462 0.875 3.73206 0.875 3.5C0.875 3.26794 0.967187 3.04538 1.13128 2.88128C1.29538 2.71719 1.51794 2.625 1.75 2.625H4.375C4.5663 2.62496 4.75234 2.68762 4.90464 2.80338C5.05694 2.91913 5.16711 3.08161 5.21828 3.26594L6.25516 7H25.375C25.5099 6.99997 25.643 7.03114 25.7638 7.09105C25.8847 7.15097 25.99 7.23802 26.0717 7.3454C26.1533 7.45277 26.2091 7.57758 26.2345 7.71005C26.2599 7.84253 26.2544 7.97908 26.2183 8.10906ZM9.625 21.875C9.27888 21.875 8.94054 21.9776 8.65275 22.1699C8.36497 22.3622 8.14066 22.6355 8.00821 22.9553C7.87576 23.2751 7.8411 23.6269 7.90863 23.9664C7.97615 24.3059 8.14282 24.6177 8.38756 24.8624C8.63231 25.1072 8.94413 25.2738 9.28359 25.3414C9.62306 25.4089 9.97493 25.3742 10.2947 25.2418C10.6145 25.1093 10.8878 24.885 11.0801 24.5972C11.2724 24.3095 11.375 23.9711 11.375 23.625C11.375 23.1609 11.1906 22.7158 10.8624 22.3876C10.5342 22.0594 10.0891 21.875 9.625 21.875ZM21 21.875C20.6539 21.875 20.3155 21.9776 20.0278 22.1699C19.74 22.3622 19.5157 22.6355 19.3832 22.9553C19.2508 23.2751 19.2161 23.6269 19.2836 23.9664C19.3512 24.3059 19.5178 24.6177 19.7626 24.8624C20.0073 25.1072 20.3191 25.2738 20.6586 25.3414C20.9981 25.4089 21.3499 25.3742 21.6697 25.2418C21.9895 25.1093 22.2628 24.885 22.4551 24.5972C22.6474 24.3095 22.75 23.9711 22.75 23.625C22.75 23.1609 22.5656 22.7158 22.2374 22.3876C21.9093 22.0594 21.4641 21.875 21 21.875Z">
                        </path>
                        <g clip-path="url(#clip0_938_63966)">
                            <path
                                    d="M18.8127 13.9974C18.8127 14.1134 18.7666 14.2247 18.6845 14.3068C18.6025 14.3888 18.4912 14.4349 18.3752 14.4349H15.6043V17.2057C15.6043 17.3218 15.5582 17.433 15.4762 17.5151C15.3941 17.5971 15.2829 17.6432 15.1668 17.6432C15.0508 17.6432 14.9395 17.5971 14.8575 17.5151C14.7754 17.433 14.7293 17.3218 14.7293 17.2057V14.4349H11.9585C11.8425 14.4349 11.7312 14.3888 11.6491 14.3068C11.5671 14.2247 11.521 14.1134 11.521 13.9974C11.521 13.8814 11.5671 13.7701 11.6491 13.688C11.7312 13.606 11.8425 13.5599 11.9585 13.5599H14.7293V10.7891C14.7293 10.673 14.7754 10.5618 14.8575 10.4797C14.9395 10.3977 15.0508 10.3516 15.1668 10.3516C15.2829 10.3516 15.3941 10.3977 15.4762 10.4797C15.5582 10.5618 15.6043 10.673 15.6043 10.7891V13.5599H18.3752C18.4912 13.5599 18.6025 13.606 18.6845 13.688C18.7666 13.7701 18.8127 13.8814 18.8127 13.9974Z"
                                    stroke="#041E42" stroke-width="0.5"></path>
                        </g>
                        <defs>
                            <clipPath id="clip0_938_63966">
                                <rect width="9.33333" height="9.33333" fill="white"
                                      transform="translate(10.5 9.33203)"></rect>
                            </clipPath>
                        </defs>
                    </svg>
                </button>
        </form>
    </div>
    <h5>

        <?= Yii::t('site', 'DONATION_FOOTER') ?>
    </h5>

</div>
</div>


<div class="floationg-quick-donation-card mobile-version">
    <?php $formID = uniqid('form-'); ?>
    <form class="form-quick-donation hidden" id="<?= $formID ?>" method="post"
          action="<?= Url::to(['/cart/add']) ?>">
        <h4> <?= Yii::t('site', 'QUICK_1') ?>  </h4>
        <h4> <?= Yii::t('site', 'CHOOSE_THE_AMOUNT') ?>  </h4>
        <input type="hidden" name="<?= Yii::$app->request->csrfParam ?>"
               value="<?= Yii::$app->request->csrfToken ?>"/>
        <input type="hidden" name="items[0][type]" value="1"/>
        <input type="hidden" name="items[0][donation]"
               value="<?= TuaClient::PUBLIC_DONATIONS_TYPE_ID ?>"/>
        <input type="hidden" name="items[0][campaign]" value=""/>
        <input type="hidden" name="items[0][guid]" value="<?= uniqid('cart-item-') ?>"/>
        <input type="hidden" name="items[0][recurrence]" value="once" id="payment-recurrence-type"/>
        <input type="hidden" name="items[0][quantity]" value="1"/>
        <input type="hidden" name="items[0][currency]"
               value="<?= Utility::selected_currency('slug') ?>"/>

        <div class="donation-buttons">
            <button>5</button>
            <button>10</button>
            <button>20</button>
            <button>50</button>
        </div>
        <div class="amount-input">
            <input type="number" placeholder="<?= Yii::t('site', 'DONATION_AMOUNT') ?>" name="items[0][amount]" class="amount" required/>
        </div>
        <div class="send-eCard">
            <picture>
                <img src="/theme/assets/Icons/Gift.svg" alt="">
            </picture>
            <a href="">
                <?= Yii::t('site', 'SEND_E_CARD') ?>
            </a>
        </div>
        <h5>
            <?= Yii::t('site', 'DONATION_FOOTER') ?>

        </h5>
        <div class="floationg-quick-donation-card-donate-box">

            <button class="type-6-btn w-100" tabindex="0" type="submit" onclick="addToCart('#<?= $formID ?>', true)">
                <span><?= Yii::t('site', 'DONATE') ?></span></button>

            <button class="add-to-cart-btn" type="button" onclick="addToCart('#<?= $formID ?>')">

                <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                            d="M26.2183 8.10906L23.4139 18.2022C23.2597 18.7535 22.9299 19.2396 22.4746 19.5866C22.0192 19.9336 21.4631 20.1226 20.8906 20.125H10.08C9.50582 20.1247 8.94747 19.9367 8.49012 19.5895C8.03277 19.2424 7.70152 18.7552 7.54688 18.2022L3.71 4.375H1.75C1.51794 4.375 1.29538 4.28281 1.13128 4.11872C0.967187 3.95462 0.875 3.73206 0.875 3.5C0.875 3.26794 0.967187 3.04538 1.13128 2.88128C1.29538 2.71719 1.51794 2.625 1.75 2.625H4.375C4.5663 2.62496 4.75234 2.68762 4.90464 2.80338C5.05694 2.91913 5.16711 3.08161 5.21828 3.26594L6.25516 7H25.375C25.5099 6.99997 25.643 7.03114 25.7638 7.09105C25.8847 7.15097 25.99 7.23802 26.0717 7.3454C26.1533 7.45277 26.2091 7.57758 26.2345 7.71005C26.2599 7.84253 26.2544 7.97908 26.2183 8.10906ZM9.625 21.875C9.27888 21.875 8.94054 21.9776 8.65275 22.1699C8.36497 22.3622 8.14066 22.6355 8.00821 22.9553C7.87576 23.2751 7.8411 23.6269 7.90863 23.9664C7.97615 24.3059 8.14282 24.6177 8.38756 24.8624C8.63231 25.1072 8.94413 25.2738 9.28359 25.3414C9.62306 25.4089 9.97493 25.3742 10.2947 25.2418C10.6145 25.1093 10.8878 24.885 11.0801 24.5972C11.2724 24.3095 11.375 23.9711 11.375 23.625C11.375 23.1609 11.1906 22.7158 10.8624 22.3876C10.5342 22.0594 10.0891 21.875 9.625 21.875ZM21 21.875C20.6539 21.875 20.3155 21.9776 20.0278 22.1699C19.74 22.3622 19.5157 22.6355 19.3832 22.9553C19.2508 23.2751 19.2161 23.6269 19.2836 23.9664C19.3512 24.3059 19.5178 24.6177 19.7626 24.8624C20.0073 25.1072 20.3191 25.2738 20.6586 25.3414C20.9981 25.4089 21.3499 25.3742 21.6697 25.2418C21.9895 25.1093 22.2628 24.885 22.4551 24.5972C22.6474 24.3095 22.75 23.9711 22.75 23.625C22.75 23.1609 22.5656 22.7158 22.2374 22.3876C21.9093 22.0594 21.4641 21.875 21 21.875Z">
                    </path>
                    <g clip-path="url(#clip0_938_63966)">
                        <path
                                d="M18.8127 13.9974C18.8127 14.1134 18.7666 14.2247 18.6845 14.3068C18.6025 14.3888 18.4912 14.4349 18.3752 14.4349H15.6043V17.2057C15.6043 17.3218 15.5582 17.433 15.4762 17.5151C15.3941 17.5971 15.2829 17.6432 15.1668 17.6432C15.0508 17.6432 14.9395 17.5971 14.8575 17.5151C14.7754 17.433 14.7293 17.3218 14.7293 17.2057V14.4349H11.9585C11.8425 14.4349 11.7312 14.3888 11.6491 14.3068C11.5671 14.2247 11.521 14.1134 11.521 13.9974C11.521 13.8814 11.5671 13.7701 11.6491 13.688C11.7312 13.606 11.8425 13.5599 11.9585 13.5599H14.7293V10.7891C14.7293 10.673 14.7754 10.5618 14.8575 10.4797C14.9395 10.3977 15.0508 10.3516 15.1668 10.3516C15.2829 10.3516 15.3941 10.3977 15.4762 10.4797C15.5582 10.5618 15.6043 10.673 15.6043 10.7891V13.5599H18.3752C18.4912 13.5599 18.6025 13.606 18.6845 13.688C18.7666 13.7701 18.8127 13.8814 18.8127 13.9974Z"
                                stroke="#041E42" stroke-width="0.5"></path>
                    </g>
                    <defs>
                        <clipPath id="clip0_938_63966">
                            <rect width="9.33333" height="9.33333" fill="white"
                                  transform="translate(10.5 9.33203)"></rect>
                        </clipPath>
                    </defs>
                </svg>
            </button>
            <button type="button" class="floating-box-close-btn">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
    </form>
    <button type="button" class="type-2-btn floating-box-toggle-mobile-version"
            onclick="addToCart('#<?= $formID ?>', true)">
        <picture>
            <img src="/theme/assets/Icons/Heart fill white.svg" alt="">
        </picture>
        <span>     <?= Yii::t('site', 'QUICK_DONATION') ?> </span>
    </button>
</div>


<?php
$this->registerJsVar('language', Yii::$app->language);
$js = <<<JS

$('.form-quick-donation .donation-buttons button').on('click', function (e) {
  e.preventDefault(); 

  var amount = $(this).text().trim();
  var form = $(this).closest('.form-quick-donation');
  var input = form.find('.amount-input input[type="number"]');
  if (input.length) {
    input.val(amount);
  }
});

$("#send-eCard-link").on('click', function (){
    const form = $(this).closest('form');
    let amount = parseFloat($(".form-quick-donation .amount").val());
    let input = form.find('.amount-input input[type="number"]');
    if (isNaN(amount) || amount <= 0) {
        form.find('.error-message').css('display', 'block');
        return;
    }
    form.attr('id', '').attr('action', "/" + language + "/e-card/step-one").submit();
});
JS;

$this->registerJs($js);
?>




