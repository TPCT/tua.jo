<?php

use yii\helpers\Url;
use kartik\form\ActiveForm;
use frontend\widgets\HeaderImage;
use frontend\widgets\breadcrumbs\BreadCrumbs;

use frontend\assets\SlickAsset;

SlickAsset::register($this);


$this->registerCssFile("/theme/css/main-dontation.css", ['depends' => [\frontend\assets\AppAsset::className()],]);
$this->registerCssFile("/theme/css/Empowerment-products.css", ['depends' => [\frontend\assets\AppAsset::className()],]);
$this->registerCssFile("/theme/css/Empowerment-details-new.css", ['depends' => [\frontend\assets\AppAsset::className()],]);



$this->title =  $targetEmpowermentProduct->title ;
$this->description = $targetEmpowermentProduct->brief;
$this->og_image =  $targetEmpowermentProduct->image   ;
$this->type = "article";

$lng = Yii::$app->language;
?>
<?php



?>
<?= BreadCrumbs::widget(['is_inner'=> false , 'bread_crumb_slug'=>$targetEmpowermentProduct->slug , 'bread_crumb_title'=>$targetEmpowermentProduct->title  ]) ?>

      
      <section class="Empowerment-details-new-section">
            <div class="container">

                <?= \frontend\widgets\WebpImage::widget(["src" => $targetEmpowermentProduct->image, "alt" => $targetEmpowermentProduct->title, "loading" => "lazy", 'css' => "Empowerment-details-main-img"]) ?>

                <div>
                    <div class="Empowerment-product-price">
                        <h3><?= $targetEmpowermentProduct->category->title ?></h3>
                        <h3><?= Yii::t('site', 'PRICE') ?>: 5 <?= Yii::t('site', 'JOD') ?></h3>
                    </div>
                    <div>
                        <h4><?= Yii::t('site', 'DESCRIPTION') ?></h4>
                        <p> <?= $targetEmpowermentProduct->brief ?></p>
                    </div>
                    <div class="donation-amount-detailed">

                        <div class="donation-amount-detailed-btns">
                            <div class="quantity-control">
                              <button type="button" class="quantity-btn minus">−</button>
                              <h4 class="quantity">0</h4>
                              <button type="button" class="quantity-btn plus">+</button>
                            </div>
                            <a class="type-3-btn w-100" href="">
                              <span> <?= Yii::t('site', 'ADD_TO_CART') ?> </span>
                              <svg width="23" height="21" viewBox="0 0 23 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M22.4728 5.45062L20.0691 14.1019C19.9369 14.5745 19.6542 14.9911 19.2639 15.2885C18.8736 15.5859 18.397 15.7479 17.9063 15.75H8.64C8.14784 15.7498 7.66926 15.5886 7.27725 15.291C6.88524 14.9935 6.6013 14.5758 6.46875 14.1019L3.18 2.25H1.5C1.30109 2.25 1.11032 2.17098 0.96967 2.03033C0.829018 1.88968 0.75 1.69891 0.75 1.5C0.75 1.30109 0.829018 1.11032 0.96967 0.96967C1.11032 0.829018 1.30109 0.75 1.5 0.75H3.75C3.91397 0.749969 4.07343 0.803673 4.20398 0.902893C4.33452 1.00211 4.42895 1.14138 4.47281 1.29938L5.36156 4.5H21.75C21.8656 4.49998 21.9797 4.52669 22.0833 4.57805C22.1869 4.6294 22.2772 4.70401 22.3472 4.79605C22.4171 4.88809 22.4649 4.99506 22.4867 5.10861C22.5085 5.22216 22.5037 5.33922 22.4728 5.45062ZM8.25 17.25C7.95333 17.25 7.66332 17.338 7.41665 17.5028C7.16997 17.6676 6.97771 17.9019 6.86418 18.176C6.75065 18.4501 6.72094 18.7517 6.77882 19.0426C6.8367 19.3336 6.97956 19.6009 7.18934 19.8107C7.39912 20.0204 7.66639 20.1633 7.95737 20.2212C8.24834 20.2791 8.54994 20.2494 8.82403 20.1358C9.09811 20.0223 9.33238 19.83 9.4972 19.5834C9.66203 19.3367 9.75 19.0467 9.75 18.75C9.75 18.3522 9.59196 17.9706 9.31066 17.6893C9.02936 17.408 8.64783 17.25 8.25 17.25ZM18 17.25C17.7033 17.25 17.4133 17.338 17.1666 17.5028C16.92 17.6676 16.7277 17.9019 16.6142 18.176C16.5007 18.4501 16.4709 18.7517 16.5288 19.0426C16.5867 19.3336 16.7296 19.6009 16.9393 19.8107C17.1491 20.0204 17.4164 20.1633 17.7074 20.2212C17.9983 20.2791 18.2999 20.2494 18.574 20.1358C18.8481 20.0223 19.0824 19.83 19.2472 19.5834C19.412 19.3367 19.5 19.0467 19.5 18.75C19.5 18.3522 19.342 17.9706 19.0607 17.6893C18.7794 17.408 18.3978 17.25 18 17.25Z" fill="#041E42"/>
                                </svg>
                                
                            </a>
                            
                          </div>
                    </div>
                    <div class="donor-details-box">
                        <form class="donor-details-main-form">
                            <div class="check-input">
                                <input type="checkbox" name="" id="">
                                <p> <?= Yii::t('site', 'DONATE_AS_A_GIFT') ?> </p>
                            </div>
                            <div class=" donor-details-main-form-inputs">
                              <div class="row w-100 px-0 g-4  pb-2">
                                <div class="col-lg-12 col-12 d-flex flex-column gap-2">
                                  <label for="subject">Select donor’s user* </label>
                                  <select type="subject" name="subject" id="subject" placeholder=" -select- ">
                                    <option value=""></option>
                                    <option value=""></option>
                                    <option value=""></option>
                                  </select>
                                </div>
                                <div class="col-lg-6 col-12 d-flex flex-column gap-2">
                                  <label for="name">Sender’s Name* </label>
                                  <input type="text" name="name" id="name" placeholder=" Sender’s Name ">
                                </div>
                                <div class="col-lg-6 col-12 d-flex flex-column gap-2">
                                  <label for="email">Recipient’s Name* </label>
                                  <input type="email" name="email" id="email" placeholder=" Recipient’s Name ">
                                </div>
                                <div class="col-lg-6 col-12 d-flex flex-column gap-2">
                                  <label for="name">Recipient’s number  </label>
                                  <input type="text" name="name" id="mobile-number-input" placeholder=" xxxx xx xxx">
                                </div>
                                <div class="col-lg-6 col-12 d-flex flex-column gap-2">
                                  <label for="email">Recipient’s email* </label>
                                  <input type="email" name="email" id="email" placeholder=" info@example.com ">
                                </div>
                                <div class=" col-12 d-flex flex-column gap-2">
                                  <label for="message">Message </label>
                                  <textarea name="message" id="message" placeholder=" Type here "></textarea>
                                </div>
    
                              </div>
                            </div>
                        </form>
                        <div class="donation-amount-detailed-btns my-3">
                            <div class="quantity-control">
                              <button type="button" class="quantity-btn minus">−</button>
                              <h4 class="quantity">0</h4>
                              <button type="button" class="quantity-btn plus">+</button>
                            </div>
                            <a class="type-3-btn w-100" href="">
                              <span>  <?= Yii::t('site', 'ADD_TO_CART') ?>  </span>
                              <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M26.2183 8.10906L23.4139 18.2022C23.2597 18.7535 22.9299 19.2396 22.4746 19.5866C22.0192 19.9336 21.4631 20.1226 20.8906 20.125H10.08C9.50582 20.1247 8.94747 19.9367 8.49012 19.5895C8.03277 19.2424 7.70152 18.7552 7.54688 18.2022L3.71 4.375H1.75C1.51794 4.375 1.29538 4.28281 1.13128 4.11872C0.967187 3.95462 0.875 3.73206 0.875 3.5C0.875 3.26794 0.967187 3.04538 1.13128 2.88128C1.29538 2.71719 1.51794 2.625 1.75 2.625H4.375C4.5663 2.62496 4.75234 2.68762 4.90464 2.80338C5.05694 2.91913 5.16711 3.08161 5.21828 3.26594L6.25516 7H25.375C25.5099 6.99997 25.643 7.03114 25.7638 7.09105C25.8847 7.15097 25.99 7.23802 26.0717 7.3454C26.1533 7.45277 26.2091 7.57758 26.2345 7.71005C26.2599 7.84253 26.2544 7.97908 26.2183 8.10906ZM9.625 21.875C9.27888 21.875 8.94054 21.9776 8.65275 22.1699C8.36497 22.3622 8.14066 22.6355 8.00821 22.9553C7.87576 23.2751 7.8411 23.6269 7.90863 23.9664C7.97615 24.3059 8.14282 24.6177 8.38756 24.8624C8.63231 25.1072 8.94413 25.2738 9.28359 25.3414C9.62306 25.4089 9.97493 25.3742 10.2947 25.2418C10.6145 25.1093 10.8878 24.885 11.0801 24.5972C11.2724 24.3095 11.375 23.9711 11.375 23.625C11.375 23.1609 11.1906 22.7158 10.8624 22.3876C10.5342 22.0594 10.0891 21.875 9.625 21.875ZM21 21.875C20.6539 21.875 20.3155 21.9776 20.0278 22.1699C19.74 22.3622 19.5157 22.6355 19.3832 22.9553C19.2508 23.2751 19.2161 23.6269 19.2836 23.9664C19.3512 24.3059 19.5178 24.6177 19.7626 24.8624C20.0073 25.1072 20.3191 25.2738 20.6586 25.3414C20.9981 25.4089 21.3499 25.3742 21.6697 25.2418C21.9895 25.1093 22.2628 24.885 22.4551 24.5972C22.6474 24.3095 22.75 23.9711 22.75 23.625C22.75 23.1609 22.5656 22.7158 22.2374 22.3876C21.9093 22.0594 21.4641 21.875 21 21.875Z"></path>
                                <g clip-path="url(#clip0_938_63966)">
                                  <path d="M18.8127 13.9974C18.8127 14.1134 18.7666 14.2247 18.6845 14.3068C18.6025 14.3888 18.4912 14.4349 18.3752 14.4349H15.6043V17.2057C15.6043 17.3218 15.5582 17.433 15.4762 17.5151C15.3941 17.5971 15.2829 17.6432 15.1668 17.6432C15.0508 17.6432 14.9395 17.5971 14.8575 17.5151C14.7754 17.433 14.7293 17.3218 14.7293 17.2057V14.4349H11.9585C11.8425 14.4349 11.7312 14.3888 11.6491 14.3068C11.5671 14.2247 11.521 14.1134 11.521 13.9974C11.521 13.8814 11.5671 13.7701 11.6491 13.688C11.7312 13.606 11.8425 13.5599 11.9585 13.5599H14.7293V10.7891C14.7293 10.673 14.7754 10.5618 14.8575 10.4797C14.9395 10.3977 15.0508 10.3516 15.1668 10.3516C15.2829 10.3516 15.3941 10.3977 15.4762 10.4797C15.5582 10.5618 15.6043 10.673 15.6043 10.7891V13.5599H18.3752C18.4912 13.5599 18.6025 13.606 18.6845 13.688C18.7666 13.7701 18.8127 13.8814 18.8127 13.9974Z"  stroke="
                                    #041E42" stroke-width="0.5"></path>
                                </g>
                                <defs>
                                  <clipPath id="clip0_938_63966">
                                    <rect width="9.33333" height="9.33333" transform="translate(10.5 9.33203)">
                                    </rect>
                                  </clipPath>
                                </defs>
                              </svg>
                            </a>
                            
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="donation-flow-slider-section">
            <div class="container centerd-section-topic">
              <h3> <?= Yii::t('site', 'MORE_PRODUCTS') ?>  </h3>
            </div>
            <div class="slider-wrapper container position-relative">
              <span href="" class="donation-flow-slider-btn-main donation-flow-slider-prev">
                <i class="fa-solid fa-arrow-left"></i>
              </span>
              <div class="donation-flow-slider">

   
              <?php foreach($moreEmpowermentProducts as $moreEmpowermentProduct) : ?>

   
                <div class="empowerment-card">

                    <?= \frontend\widgets\WebpImage::widget(["src" => $moreEmpowermentProduct->image, "alt" => $moreEmpowermentProduct->title, "loading" => "lazy", 'css' => ""]) ?>

                    <div class="empowerment-card-content">
                        <div>
                            <div class="product-price">
                                <h4><?= $moreEmpowermentProduct->category->title ?></h4>
                                <h4>5 JOD</h4>
                            </div>
                            <p><?= $moreEmpowermentProduct->title ?></p>
                        </div>
                        <div class="buttons">
                            <a href="#" id="Readbuttn" class="type-4-btn" style="opacity: 1; transform: translateX(0px); transition: 0.5s ease-in-out; display: flex; flex-shrink: 0;">
                              <span> <?= Yii::t('site', 'READ_MORE') ?> </span>
                              <i class="fa-solid fa-arrow-right"></i>
                            </a>
                
                            <?= frontend\widgets\cards_share_button\CardsShareButton::widget() ?>
                        </div>
                    </div>
                </div>

                <?php endforeach; ?>


              </div>
              <span href="" class="donation-flow-slider-btn-main donation-flow-slider-next">
                <i class="fa-solid fa-arrow-right"></i>
              </span>
            </div>
      
          </section>

      
    <?php if($lng=="en"): ?>

<?php
    $script = <<< JS


document.querySelectorAll('.quantity-btn').forEach(button => {
      button.addEventListener('click', function () {
          let quantityElement = this.closest('.quantity-control').querySelector('.quantity');
          let minusBtn = this.closest('.quantity-control').querySelector('.quantity-btn.minus');
          
          // Use setTimeout to wait for the update function to finish
          setTimeout(() => {
                      let quantity = parseInt(quantityElement.textContent);
  
                      if (quantity > 0) {
                          quantityElement.style.color = 'var(--primary-color)';
                          minusBtn.style.color = 'var(--primary-color)';
                      } else {
                          quantityElement.style.color = ''; // Resets to default CSS color
                          minusBtn.style.color = ''; // Resets to default CSS color
                      
                      }
                  }, 0); // Runs after the other function updates the quantity
      });
  });
  
  


$(document).ready(function () {
      $(".donation-flow-slider").slick({
        dots: true,
        infinite: true,
        slidesToShow: 4,
        slidesToScroll: 1,
        nextArrow: $(".donation-flow-slider-next"),
        prevArrow: $(".donation-flow-slider-prev"),
        responsive: [
          {
            breakpoint: 992,
            settings: {
              slidesToShow: 3,
            },
          },
          {
            breakpoint: 768,
            settings: {
              slidesToShow: 1,
            },
          },
        ],
      });
    });
JS;
$this->registerJs($script);
?>

<?php else: ?>

<?php
    $script = <<< JS
    

    document.querySelectorAll('.quantity-btn').forEach(button => {
        button.addEventListener('click', function () {
            let quantityElement = this.closest('.quantity-control').querySelector('.quantity');
            let minusBtn = this.closest('.quantity-control').querySelector('.quantity-btn.minus');

            // Use setTimeout to wait for the update function to finish
            setTimeout(() => {
                let quantity = parseInt(quantityElement.textContent);

                if (quantity > 0) {
                    quantityElement.style.color = 'var(--primary-color)';
                    minusBtn.style.color = 'var(--primary-color)';
                } else {
                    quantityElement.style.color = ''; // Resets to default CSS color
                    minusBtn.style.color = ''; // Resets to default CSS color

                }
            }, 0); // Runs after the other function updates the quantity
        });
    });




    document.querySelectorAll('.quantity-btn').forEach(button => {
        button.addEventListener('click', function () {
            const quantityElement = this.closest('.quantity-control').querySelector('.quantity');
            let quantity = parseInt(quantityElement.textContent);

            if (this.classList.contains('plus')) {
                quantity++;
            } else if (this.classList.contains('minus') && quantity > 0) {
                quantity--;
            }

            quantityElement.textContent = quantity;
        });

    });

    $(document).ready(function () {
        $(".donation-flow-slider").slick({
            dots: true,
            rtl: true,
            infinite: true,
            slidesToShow: 4,
            slidesToScroll: 1,
            nextArrow: $(".donation-flow-slider-next"),
            prevArrow: $(".donation-flow-slider-prev"),
            responsive: [
                {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 3,
                    },
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 1,
                    },
                },
            ],
        });
    });

JS;
$this->registerJs($script);
?>

<?php endif; ?>