<?php 

$lng = Yii::$app->language; 
?>
<?php if (!empty($programs)): ?>
    <div class="container centerd-section-topic wow fadeInDownBig" id="<?=$id?>">
        <h2><?= $title ?></h2>
        <div><?= $subtitle ?></div>
    </div>
    <div class="slider-wrapper container home-page-fourth-section position-relative donation-programs-slider">
        <div class="colored-slider">
            <?php foreach ($programs as $program): ?>
                <div class="colored-slide wow fadeInUpBig">
                    <div class="d-flex flex-column h-100 position-relative">
                        <?= \frontend\widgets\WebpImage::widget(["src" => $program->image, "alt" => $program->title, "loading" => "lazy", 'css' => ""]) ?>

                        <div class="colored-slide-img" style="background: <?=$program->color?> !important;">
                            <?= \frontend\widgets\WebpImage::widget(["src" => $program->tag_icon, "alt" => $program->tag, "loading" => "lazy", 'css' => ""]) ?>

                            <span style="color: <?= $program->color ?> !important;"><?= $program->tag ?></span>
                        </div>
                        <div class="d-flex flex-column home-page-fourth-section-content  justify-content-start h-100 px-2">
                            <h3><?= $program->title ?></h3>
                           <p> <?= $program->brief ?> </p> 
                        </div>
                    </div>
                    <div class="px-2">
                        <?php if ($program->progress != -1): ?>
                            <div class="d-flex justify-content-between border-top pt-3">
                                <div class="d-flex flex-column align-items-start raised-goal-ps">
                                    <p><?= Yii::t('site', 'Raised') ?></p>
                                    <p><?= number_format($program->raised, 2) ?> <?= Yii::t('site', 'JOD') ?></p>
                                </div>
                                <div class="d-flex flex-column align-items-end raised-goal-ps">
                                    <p><?= Yii::t('site', 'Goal') ?></p>
                                    <p><?= number_format($program->goal, 2) ?> <?= Yii::t('site', 'JOD') ?></p>
                                </div>
                            </div>
                            <div class="main-colored-progress-bar border-bottom pb-4">
                                <div class="outer-colored-progress-bar" style="background: <?=$program->color?> !important;"></div>
                                <div class="inner-colored-progress-bar" style="background: <?=$program->color?> !important;" progress="<?= (int)($program->progress) ?>%">
                                    <span style="background: <?=$program->color?> !important;"> </span>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if ($program->has_amount && $program->has_goal && $program->progress >= 0 && $program->progress < 100): ?>
                            <?php $FID = uniqid('form-') ?>
                            <div class="d-flex justify-content-between border-bottom pt-2 pb-2 gap-1 mb-2">

                                <form id="<?=$FID?>" class="position-relative w-100" id="program-<?= $program->id ?>" method="post"
                                      action="<?= \yii\helpers\Url::to(['/cart/add']) ?>">
                                    <input type="hidden" name="<?= Yii::$app->request->csrfParam ?>"
                                           value="<?= Yii::$app->request->csrfToken ?>"/>
                                    <input type="hidden" name="items[0][type]" value="1"/>
                                    <input type="hidden" name="items[0][program_id]" value="<?=$program->id?>" />
                                    <input type="hidden" name="items[0][id]" value="<?=$program->parents[0]->items[0]?->id?>">
                                    <?php if (empty($program->parents) || empty($program->parents[0]->items)): ?>
                                        <input type="hidden" name="items[0][donation]"
                                               value="<?= \common\components\TuaClient::PUBLIC_DONATIONS_TYPE_ID ?>"/>
                                        <input type="hidden" name="items[0][campaign]"
                                               value=""/>
                                    <?php else: ?>
                                        <input type="hidden" name="items[0][donation]"
                                               value="<?= $program->parents[0]->items[0]?->donationType?->guid ?>"/>
                                        <input type="hidden" name="items[0][campaign]"
                                               value="<?= $program->parents[0]->items[0]?->campaign?->guid ?>"/>
                                    <?php endif; ?>

                                    <input type="hidden" name="items[0][guid]" value="<?= uniqid('cart-item-') ?>"/>
                                    <input type="hidden" name="items[0][recurrence]" value="once"
                                           id="payment-recurrence-type"/>
                                    <input type="hidden" name="items[0][quantity]" value="1"/>
                                    <input type="hidden" name="items[0][currency]"
                                           value="<?= \common\helpers\Utility::selected_currency('slug') ?>"/>
                                    <div>
                                        <input type="text" placeholder="100" name="items[0][amount]" id="amount" class="amount" tabindex="0" required/>
                                        <button class="colored-slider-type-2-btn" tabindex="0" onclick="addToCart('#<?=$FID?>', true)"><?= Yii::t('site', 'Donate') ?></button>
                                    </div>
                                    <span class="text-danger d-none error-message"></span>
                                </form>
                                <button onclick="addToCart('#<?=$FID?>')" class="add-to-cart-btn" type="button">
                                    <svg width="28" height="28" viewBox="0 0 28 28" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path
                                                d="M26.2183 8.10906L23.4139 18.2022C23.2597 18.7535 22.9299 19.2396 22.4746 19.5866C22.0192 19.9336 21.4631 20.1226 20.8906 20.125H10.08C9.50582 20.1247 8.94747 19.9367 8.49012 19.5895C8.03277 19.2424 7.70152 18.7552 7.54688 18.2022L3.71 4.375H1.75C1.51794 4.375 1.29538 4.28281 1.13128 4.11872C0.967187 3.95462 0.875 3.73206 0.875 3.5C0.875 3.26794 0.967187 3.04538 1.13128 2.88128C1.29538 2.71719 1.51794 2.625 1.75 2.625H4.375C4.5663 2.62496 4.75234 2.68762 4.90464 2.80338C5.05694 2.91913 5.16711 3.08161 5.21828 3.26594L6.25516 7H25.375C25.5099 6.99997 25.643 7.03114 25.7638 7.09105C25.8847 7.15097 25.99 7.23802 26.0717 7.3454C26.1533 7.45277 26.2091 7.57758 26.2345 7.71005C26.2599 7.84253 26.2544 7.97908 26.2183 8.10906ZM9.625 21.875C9.27888 21.875 8.94054 21.9776 8.65275 22.1699C8.36497 22.3622 8.14066 22.6355 8.00821 22.9553C7.87576 23.2751 7.8411 23.6269 7.90863 23.9664C7.97615 24.3059 8.14282 24.6177 8.38756 24.8624C8.63231 25.1072 8.94413 25.2738 9.28359 25.3414C9.62306 25.4089 9.97493 25.3742 10.2947 25.2418C10.6145 25.1093 10.8878 24.885 11.0801 24.5972C11.2724 24.3095 11.375 23.9711 11.375 23.625C11.375 23.1609 11.1906 22.7158 10.8624 22.3876C10.5342 22.0594 10.0891 21.875 9.625 21.875ZM21 21.875C20.6539 21.875 20.3155 21.9776 20.0278 22.1699C19.74 22.3622 19.5157 22.6355 19.3832 22.9553C19.2508 23.2751 19.2161 23.6269 19.2836 23.9664C19.3512 24.3059 19.5178 24.6177 19.7626 24.8624C20.0073 25.1072 20.3191 25.2738 20.6586 25.3414C20.9981 25.4089 21.3499 25.3742 21.6697 25.2418C21.9895 25.1093 22.2628 24.885 22.4551 24.5972C22.6474 24.3095 22.75 23.9711 22.75 23.625C22.75 23.1609 22.5656 22.7158 22.2374 22.3876C21.9093 22.0594 21.4641 21.875 21 21.875Z"/>
                                        <g clip-path="url(#clip0_938_63966)">
                                            <path
                                                    d="M18.8127 13.9974C18.8127 14.1134 18.7666 14.2247 18.6845 14.3068C18.6025 14.3888 18.4912 14.4349 18.3752 14.4349H15.6043V17.2057C15.6043 17.3218 15.5582 17.433 15.4762 17.5151C15.3941 17.5971 15.2829 17.6432 15.1668 17.6432C15.0508 17.6432 14.9395 17.5971 14.8575 17.5151C14.7754 17.433 14.7293 17.3218 14.7293 17.2057V14.4349H11.9585C11.8425 14.4349 11.7312 14.3888 11.6491 14.3068C11.5671 14.2247 11.521 14.1134 11.521 13.9974C11.521 13.8814 11.5671 13.7701 11.6491 13.688C11.7312 13.606 11.8425 13.5599 11.9585 13.5599H14.7293V10.7891C14.7293 10.673 14.7754 10.5618 14.8575 10.4797C14.9395 10.3977 15.0508 10.3516 15.1668 10.3516C15.2829 10.3516 15.3941 10.3977 15.4762 10.4797C15.5582 10.5618 15.6043 10.673 15.6043 10.7891V13.5599H18.3752C18.4912 13.5599 18.6025 13.606 18.6845 13.688C18.7666 13.7701 18.8127 13.8814 18.8127 13.9974Z"
                                                    stroke="#041E42" stroke-width="0.5"/>
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_938_63966">
                                                <rect width="9.33333" height="9.33333" fill="white"
                                                      transform="translate(10.5 9.33203)"/>
                                            </clipPath>
                                        </defs>
                                    </svg>
                                </button>
                            </div>
                        <?php endif; ?>

                        <div class="buttons d-flex gap-2 pb-2 ">
                            <a class="type-4-btn w-100"
                                href="<?= \yii\helpers\Url::to(['/donation-programs/view/', 'slug' => $program->slug]) ?>">
                                    <span><?= Yii::t('site', 'MORE_DETAILS') ?></span>
                                    <svg width="21" height="21" viewBox="0 0 21 21" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                                d="M18.4152 11.1969L12.5089 17.1031C12.324 17.288 12.0732 17.3919 11.8117 17.3919C11.5502 17.3919 11.2993 17.288 11.1144 17.1031C10.9295 16.9182 10.8256 16.6674 10.8256 16.4058C10.8256 16.1443 10.9295 15.8935 11.1144 15.7086L15.3398 11.4848H3.28125C3.02018 11.4848 2.7698 11.3811 2.58519 11.1965C2.40059 11.0119 2.29688 10.7615 2.29688 10.5004C2.29688 10.2393 2.40059 9.98897 2.58519 9.80436C2.7698 9.61975 3.02018 9.51604 3.28125 9.51604H15.3398L11.1161 5.28979C10.9311 5.10487 10.8272 4.85405 10.8272 4.59253C10.8272 4.331 10.9311 4.08019 11.1161 3.89526C11.301 3.71034 11.5518 3.60645 11.8133 3.60645C12.0748 3.60645 12.3257 3.71034 12.5106 3.89526L18.4168 9.80151C18.5086 9.89309 18.5814 10.0019 18.631 10.1217C18.6806 10.2415 18.7061 10.3699 18.706 10.4995C18.7058 10.6292 18.68 10.7575 18.6301 10.8772C18.5802 10.9969 18.5072 11.1055 18.4152 11.1969Z"/>
                                    </svg>
                            </a>
                            <?= frontend\widgets\cards_share_box_button\CardsShareBoxButton::widget([
                                'url' =>  'donation-programs/' . $program->slug
                            ]); ?>

                 
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>

    </div>
<?php endif ;?>


<?php
$this->registerJsVar('language', Yii::$app->language);
$js = <<<JS
   $(document).ready(function () {
       let direction = $("main").hasClass("arabic-version");
       $(".colored-slider .add-to-cart-btn").on('click', function(){
           
                let form = $($(this).data("parent"));
                let amount = parseFloat(form.find(".amount").val());
                if (isNaN(amount) || amount <= 0)
                    return;
                $.ajax({
                    url: "/" + language + "/cart/add",
                    type: "POST",
                    data: form.serialize(),
                    success: function (data) {
                        if (data['status'] === false){
                            form.find('.error-message').text(data['message']).removeClass('d-none');
                        }else{
                            var toastSuccess = document.querySelector('.toast-success');
                            var toast = new bootstrap.Toast(toastSuccess);
                            toast.show();
                            $(".cart-items-count").text(data['cart_items_count']);
                            form.find('.error-message').addClass('d-none');
                            form.find(".amount").val("");
                        }
                    }
                })
            });
       
      $(".colored-slider").each(function (index, element) {
        let slider = $(element);
        slider.slick({
            rtl: direction,
          arrows: true,
          dots: true,
          infinite: true,
          slidesToShow: 4,
          slidesToScroll: 4,
          nextArrow:
            '<button class="slick-next"><i class="fa-solid fa-arrow-right"></i></button>',
          prevArrow:
            '<button class="slick-prev"><i class="fa-solid fa-arrow-left"></i></button>',
          responsive: [
            {
              breakpoint: 1400,
              settings: {
                slidesToShow: 3,
                slidesToScroll: 3,
              },
            },
            {
              breakpoint: 992,
              settings: {
                slidesToShow: 2,
                slidesToScroll: 2,
              },
            },
            {
              breakpoint: 768,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
              },
            },
          ],
        });
      });
    });
JS;
    $this->registerJs($js);
?>