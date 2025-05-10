<?php

use frontend\assets\SlickAsset;
use frontend\assets\WowAsset;
use common\helpers\Utility;
use yii\helpers\Url;
use common\components\custom_base_html\CustomBaseHtml;

$this->title = Yii::t('site', 'HOME_PAGE');
$this->registerCssFile("/theme/css/home.css", ['depends' => [\frontend\assets\AppAsset::className()],]);
$this->registerCssFile("/theme/css/Blogs.css", ['depends' => [\frontend\assets\AppAsset::className()],]);

SlickAsset::register($this);
WowAsset::register($this);

$lng = Yii::$app->language;  

?>

<?php if($homePageSliders): ?>


  <section class="hero-section">
      <div class="home-hero-slider">
      <?php foreach ($homePageSliders as $key => $homePageSlider): ?>

        <div class="hero-slide">
        <?php if($homePageSlider->image): ?>

          <?= \frontend\widgets\WebpImage::widget(["src" => $homePageSlider->image, "alt" => $homePageSlider->title, "loading" => "lazy", 'css' => ""]) ?>

        <?php else: ?>
        <div class="video">

            <div style="position: relative; padding-top: 56.25%;">
              <iframe title="TUA" width="100%" height="100%"
                src="<?= $homePageSlider->url ?>"
                frameborder="0" allowfullscreen="" sandbox="allow-same-origin allow-scripts allow-popups allow-forms"
                style="position: absolute; inset: 0px;">
              </iframe>
            </div>
        </div>

        <?php endif; ?>
 
          <div class="container position-relative">
            <div class="hero-content-box wow fadeInLeftBig">
              <h2> <?= $homePageSlider->title ?> </h2>
              <h3> <?= $homePageSlider->second_title ?> </h3>
              <h4><?= $homePageSlider->brief ?></h4>
              <?= $homePageSlider->content ?>

              <div class="d-flex gap-2">
              <?php if ($homePageSlider->url_1): ?>
                <a class="type-2-btn" <?= Utility::PrintAllUrl($homePageSlider->url_1) ?>>
                  <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g clip-path="url(#clip0_2559_1896)">
                      <path
                        d="M21.5934 13.7245C21.3482 13.5354 21.067 13.3983 20.7671 13.3215C20.4671 13.2446 20.1547 13.2295 19.8488 13.2773C21.6094 11.4998 22.5 9.73259 22.5 8.00009C22.5 5.51853 20.5041 3.50009 18.0506 3.50009C17.3996 3.496 16.7556 3.63445 16.1638 3.90573C15.5721 4.17701 15.0468 4.57454 14.625 5.0704C14.2032 4.57454 13.6779 4.17701 13.0862 3.90573C12.4944 3.63445 11.8504 3.496 11.1994 3.50009C8.74594 3.50009 6.75 5.51853 6.75 8.00009C6.75 9.03134 7.05375 10.0335 7.69312 11.0938C7.16947 11.2265 6.69158 11.4987 6.31031 11.8813L4.18969 14.0001H1.5C1.10218 14.0001 0.720644 14.1581 0.43934 14.4394C0.158035 14.7207 0 15.1023 0 15.5001L0 19.2501C0 19.6479 0.158035 20.0294 0.43934 20.3107C0.720644 20.5921 1.10218 20.7501 1.5 20.7501H11.25C11.3113 20.7501 11.3724 20.7426 11.4319 20.7276L17.4319 19.2276C17.4701 19.2185 17.5075 19.2059 17.5434 19.1901L21.1875 17.6395L21.2288 17.6207C21.579 17.4457 21.8789 17.1844 22.1002 16.8615C22.3215 16.5385 22.457 16.1646 22.4939 15.7748C22.5307 15.385 22.4678 14.9923 22.3109 14.6336C22.154 14.2749 21.9084 13.962 21.5972 13.7245H21.5934ZM11.1994 5.00009C11.7803 4.99159 12.3505 5.15653 12.8371 5.47384C13.3238 5.79114 13.7047 6.24638 13.9313 6.78134C13.9878 6.9189 14.0839 7.03655 14.2074 7.11935C14.3309 7.20215 14.4763 7.24636 14.625 7.24636C14.7737 7.24636 14.9191 7.20215 15.0426 7.11935C15.1661 7.03655 15.2622 6.9189 15.3187 6.78134C15.5453 6.24638 15.9262 5.79114 16.4129 5.47384C16.8995 5.15653 17.4697 4.99159 18.0506 5.00009C19.6491 5.00009 21 6.37353 21 8.00009C21 9.82915 19.5197 11.8982 16.7194 13.9907L15.6797 14.2298C15.7709 13.8443 15.7738 13.4431 15.6879 13.0564C15.6021 12.6696 15.4298 12.3073 15.1841 11.9966C14.9383 11.6859 14.6254 11.4348 14.2688 11.2622C13.9122 11.0897 13.5212 11 13.125 11.0001H9.43875C8.62969 9.90884 8.25 8.94884 8.25 8.00009C8.25 6.37353 9.60094 5.00009 11.1994 5.00009ZM1.5 15.5001H3.75V19.2501H1.5V15.5001ZM20.5716 16.2698L17.0091 17.7866L11.1562 19.2501H5.25V15.0604L7.37156 12.9398C7.51035 12.7999 7.67555 12.689 7.85758 12.6135C8.03961 12.538 8.23482 12.4995 8.43188 12.5001H13.125C13.4234 12.5001 13.7095 12.6186 13.9205 12.8296C14.1315 13.0406 14.25 13.3267 14.25 13.6251C14.25 13.9235 14.1315 14.2096 13.9205 14.4206C13.7095 14.6316 13.4234 14.7501 13.125 14.7501H10.5C10.3011 14.7501 10.1103 14.8291 9.96967 14.9698C9.82902 15.1104 9.75 15.3012 9.75 15.5001C9.75 15.699 9.82902 15.8898 9.96967 16.0304C10.1103 16.1711 10.3011 16.2501 10.5 16.2501H13.5C13.5565 16.2499 13.6127 16.2436 13.6678 16.2313L19.9491 14.7866L19.9781 14.7791C20.1699 14.7259 20.3745 14.7455 20.5527 14.8341C20.7309 14.9227 20.87 15.074 20.9433 15.259C21.0167 15.444 21.0189 15.6496 20.9498 15.8362C20.8806 16.0228 20.7449 16.1772 20.5687 16.2698H20.5716Z">
                      </path>
                    </g>
                    <defs>
                      <clipPath id="clip0_2559_1896">
                        <rect width="24" height="24" fill="white" transform="translate(0 0.5)"></rect>
                      </clipPath>
                    </defs>
                  </svg>
                  <span><?= $homePageSlider->button_text ?></span>
                </a>

                <?php endif; ?>
                <?php if ($homePageSlider->url_2): ?>
                <a class="type-1-btn" <?= Utility::PrintAllUrl($homePageSlider->url_2) ?>>
                  <span><?= $homePageSlider->button_2_text ?></span>
                  <svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                      d="M18.4152 11.1969L12.5089 17.1031C12.324 17.288 12.0732 17.3919 11.8117 17.3919C11.5502 17.3919 11.2993 17.288 11.1144 17.1031C10.9295 16.9182 10.8256 16.6674 10.8256 16.4058C10.8256 16.1443 10.9295 15.8935 11.1144 15.7086L15.3398 11.4848H3.28125C3.02018 11.4848 2.7698 11.3811 2.58519 11.1965C2.40059 11.0119 2.29688 10.7615 2.29688 10.5004C2.29688 10.2393 2.40059 9.98897 2.58519 9.80436C2.7698 9.61975 3.02018 9.51604 3.28125 9.51604H15.3398L11.1161 5.28979C10.9311 5.10487 10.8272 4.85405 10.8272 4.59253C10.8272 4.331 10.9311 4.08019 11.1161 3.89526C11.301 3.71034 11.5518 3.60645 11.8133 3.60645C12.0748 3.60645 12.3257 3.71034 12.5106 3.89526L18.4168 9.80151C18.5086 9.89309 18.5814 10.0019 18.631 10.1217C18.6806 10.2415 18.7061 10.3699 18.706 10.4995C18.7058 10.6292 18.68 10.7575 18.6301 10.8772C18.5802 10.9969 18.5072 11.1055 18.4152 11.1969Z">
                    </path>
                  </svg>
                </a>
                
        <?php endif; ?>
              </div>
            </div>
          </div>
        </div>
        <?php endforeach; ?>

      </div>
      <div class="container position-relative">
        <div class="hero-dots-container"></div>
      </div>
    </section>
 

    <div class="hero-content-md-container container my-5">
    <?php foreach ($homePageSliders as $key => $homePageSlider): ?>

      <div class="d-flex align-items-center justify-content-center">
        <div class="hero-content-box">
          <h2> <?= $homePageSlider->title ?>   </h2>
          <h3>  <?= $homePageSlider->second_title ?> </h3>
          <h4><?= $homePageSlider->brief ?></h4>
          <?= $homePageSlider->content ?>

          <div class="d-flex gap-2">
          <?php if ($homePageSlider->url_1): ?>

            <a class="type-2-btn" <?= Utility::PrintAllUrl($homePageSlider->url_1) ?>>
              <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_2559_1896)">
                  <path
                    d="M21.5934 13.7245C21.3482 13.5354 21.067 13.3983 20.7671 13.3215C20.4671 13.2446 20.1547 13.2295 19.8488 13.2773C21.6094 11.4998 22.5 9.73259 22.5 8.00009C22.5 5.51853 20.5041 3.50009 18.0506 3.50009C17.3996 3.496 16.7556 3.63445 16.1638 3.90573C15.5721 4.17701 15.0468 4.57454 14.625 5.0704C14.2032 4.57454 13.6779 4.17701 13.0862 3.90573C12.4944 3.63445 11.8504 3.496 11.1994 3.50009C8.74594 3.50009 6.75 5.51853 6.75 8.00009C6.75 9.03134 7.05375 10.0335 7.69312 11.0938C7.16947 11.2265 6.69158 11.4987 6.31031 11.8813L4.18969 14.0001H1.5C1.10218 14.0001 0.720644 14.1581 0.43934 14.4394C0.158035 14.7207 0 15.1023 0 15.5001L0 19.2501C0 19.6479 0.158035 20.0294 0.43934 20.3107C0.720644 20.5921 1.10218 20.7501 1.5 20.7501H11.25C11.3113 20.7501 11.3724 20.7426 11.4319 20.7276L17.4319 19.2276C17.4701 19.2185 17.5075 19.2059 17.5434 19.1901L21.1875 17.6395L21.2288 17.6207C21.579 17.4457 21.8789 17.1844 22.1002 16.8615C22.3215 16.5385 22.457 16.1646 22.4939 15.7748C22.5307 15.385 22.4678 14.9923 22.3109 14.6336C22.154 14.2749 21.9084 13.962 21.5972 13.7245H21.5934ZM11.1994 5.00009C11.7803 4.99159 12.3505 5.15653 12.8371 5.47384C13.3238 5.79114 13.7047 6.24638 13.9313 6.78134C13.9878 6.9189 14.0839 7.03655 14.2074 7.11935C14.3309 7.20215 14.4763 7.24636 14.625 7.24636C14.7737 7.24636 14.9191 7.20215 15.0426 7.11935C15.1661 7.03655 15.2622 6.9189 15.3187 6.78134C15.5453 6.24638 15.9262 5.79114 16.4129 5.47384C16.8995 5.15653 17.4697 4.99159 18.0506 5.00009C19.6491 5.00009 21 6.37353 21 8.00009C21 9.82915 19.5197 11.8982 16.7194 13.9907L15.6797 14.2298C15.7709 13.8443 15.7738 13.4431 15.6879 13.0564C15.6021 12.6696 15.4298 12.3073 15.1841 11.9966C14.9383 11.6859 14.6254 11.4348 14.2688 11.2622C13.9122 11.0897 13.5212 11 13.125 11.0001H9.43875C8.62969 9.90884 8.25 8.94884 8.25 8.00009C8.25 6.37353 9.60094 5.00009 11.1994 5.00009ZM1.5 15.5001H3.75V19.2501H1.5V15.5001ZM20.5716 16.2698L17.0091 17.7866L11.1562 19.2501H5.25V15.0604L7.37156 12.9398C7.51035 12.7999 7.67555 12.689 7.85758 12.6135C8.03961 12.538 8.23482 12.4995 8.43188 12.5001H13.125C13.4234 12.5001 13.7095 12.6186 13.9205 12.8296C14.1315 13.0406 14.25 13.3267 14.25 13.6251C14.25 13.9235 14.1315 14.2096 13.9205 14.4206C13.7095 14.6316 13.4234 14.7501 13.125 14.7501H10.5C10.3011 14.7501 10.1103 14.8291 9.96967 14.9698C9.82902 15.1104 9.75 15.3012 9.75 15.5001C9.75 15.699 9.82902 15.8898 9.96967 16.0304C10.1103 16.1711 10.3011 16.2501 10.5 16.2501H13.5C13.5565 16.2499 13.6127 16.2436 13.6678 16.2313L19.9491 14.7866L19.9781 14.7791C20.1699 14.7259 20.3745 14.7455 20.5527 14.8341C20.7309 14.9227 20.87 15.074 20.9433 15.259C21.0167 15.444 21.0189 15.6496 20.9498 15.8362C20.8806 16.0228 20.7449 16.1772 20.5687 16.2698H20.5716Z">
                  </path>
                </g>
                <defs>
                  <clipPath id="clip0_2559_1896">
                    <rect width="24" height="24" fill="white" transform="translate(0 0.5)"></rect>
                  </clipPath>
                </defs>
              </svg>
              <span> <?= $homePageSlider->button_text ?> </span>
            </a>
            <?php endif; ?>

            <?php if ($homePageSlider->url_2): ?>

            <a class="type-1-btn" <?= Utility::PrintAllUrl($homePageSlider->url_2) ?> >
              <span >  <?= $homePageSlider->button_2_text ?>  </span>
              <svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                  d="M18.4152 11.1969L12.5089 17.1031C12.324 17.288 12.0732 17.3919 11.8117 17.3919C11.5502 17.3919 11.2993 17.288 11.1144 17.1031C10.9295 16.9182 10.8256 16.6674 10.8256 16.4058C10.8256 16.1443 10.9295 15.8935 11.1144 15.7086L15.3398 11.4848H3.28125C3.02018 11.4848 2.7698 11.3811 2.58519 11.1965C2.40059 11.0119 2.29688 10.7615 2.29688 10.5004C2.29688 10.2393 2.40059 9.98897 2.58519 9.80436C2.7698 9.61975 3.02018 9.51604 3.28125 9.51604H15.3398L11.1161 5.28979C10.9311 5.10487 10.8272 4.85405 10.8272 4.59253C10.8272 4.331 10.9311 4.08019 11.1161 3.89526C11.301 3.71034 11.5518 3.60645 11.8133 3.60645C12.0748 3.60645 12.3257 3.71034 12.5106 3.89526L18.4168 9.80151C18.5086 9.89309 18.5814 10.0019 18.631 10.1217C18.6806 10.2415 18.7061 10.3699 18.706 10.4995C18.7058 10.6292 18.68 10.7575 18.6301 10.8772C18.5802 10.9969 18.5072 11.1055 18.4152 11.1969Z">
                </path>
              </svg>
            </a>
            <?php endif; ?>
          </div>
        </div>
      </div>
      <?php endforeach; ?>

    </div>
    <?php endif; ?>

    
    <section class="home-2nd-section overflow-hidden ">
      <div class="container centerd-section-topic wow fadeInDownBig" data-wow-offset="10">
        <h1> <?= Yii::t('site', 'IMPACT_OF_YOUR_COTRUBUTIONS_TITLE') ?>  </h1>
        <p><?= Yii::t('site', 'IMPACT_OF_YOUR_COTRUBUTIONS_BRIEF') ?></p>
      </div>

      <div class="container home-2nd-section-cards">

 
        <?php if($homePageFirstSections): ?>

        <?php foreach ($homePageFirstSections as $key => $homePageFirstSection): ?>

        <?php

        $delay = 0.1 * ($key + 1); 
    ?>

        <div class="home-2nd-section-card wow fadeInUpBig" data-wow-delay=" <?php echo $delay; ?>s">

          <?= \frontend\widgets\WebpImage::widget(["src" => $homePageFirstSection->image, "alt" => $homePageFirstSection->title, "loading" => "lazy", 'css' => ""]) ?>

          <div class="home-2nd-section-card-content">
            <div class="d-flex gap-2 align-items-center">
            <?= \frontend\widgets\WebpImage::widget(["src" => $homePageFirstSection->mobile_image, "alt" => $homePageFirstSection->title, "loading" => "lazy", 'css' => ""]) ?>


              <h2> <?= $homePageFirstSection->title ?> </h2>
            </div>
            <h3><?= $homePageFirstSection->second_title ?></h3>
          </div>
        </div>
        <?php endforeach; ?>

        <?php endif; ?>


      </div>
    </section>
    <?php if($homePagePromoteSection): ?>

    <?php $background =  $homePagePromoteSection->backgroumd_image?>
    <?= CustomBaseHtml::style(".Promoted-section-image { background: url( " . ($background ) . ") !important ; }") ?>

    <section class="home-3rd-section Promoted-section-image">
      <div class="container wow fadeInLeftBig">

        <?= \frontend\widgets\WebpImage::widget(["src" => $homePagePromoteSection->image, "alt" => $homePagePromoteSection->title, "loading" => "lazy", 'css' => ""]) ?>
        <?php $formID = uniqid('form-'); ?>
        <form id="<?=$formID?>" class="home-3rd-section-form" method="post" action="<?=Url::to(['/cart/add'])?>">
            <input type="hidden" name="<?= Yii::$app->request->csrfParam ?>" value="<?= Yii::$app->request->csrfToken ?>"/>
            <input type="hidden" name="items[0][type]" value="1"/>
            <input type="hidden" name="items[0][donation]" value="<?= $homePagePromoteSection->donationType?->guid ?>"/>
            <input type="hidden" name="items[0][campaign]" value="<?= $homePagePromoteSection->campaign?->guid?>"/>
            <input type="hidden" name="items[0][guid]" value="<?= uniqid('cart-item-') ?>"/>
            <input type="hidden" name="items[0][recurrence]" value="once" id="payment-recurrence-type"/>
            <input type="hidden" name="items[0][quantity]" value="1"/>
            <input type="hidden" name="items[0][currency]" value="<?= Utility::selected_currency('slug') ?>"/>

          <h2> <?= $homePagePromoteSection->title ?> </h2>
          <p>
              <?= $homePagePromoteSection->brief ?>
          </p>
          <div class="donation-buttons">
            <button>5</button>
            <button>10</button>
            <button>20</button>
            <button>50</button>
            <button>100</button>
            <button>200</button>
          </div>
          <div class="custom-amount-box">
            <div></div>
            <p> <?= Yii::t('site','OR_ENTER_THE_AMOUNT') ?></p>
            <div></div>
          </div>
          <div class="donate-box">
            <div class="amount-input">
              <input type="number" placeholder="<?=Yii::t('site', 'Amount')?>" name="items[0][amount]" class="amount"/>
              <div class="error-message" style="color: red; display: none; font-size: 14px; margin-top: 5px;"><?=Yii::t('site', 'Please enter an amount greater than 0')?></div>
            </div>
            <button class="type-2-btn" onclick="addToCart('#<?=$formID?>', true)">
              <span>
                <?= Yii::t('site','DONATE') ?>
              </span></button>
            <button class="add-to-cart-btn" onclick="addToCart('#<?=$formID?>')">
              <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                  d="M26.2183 8.10906L23.4139 18.2022C23.2597 18.7535 22.9299 19.2396 22.4746 19.5866C22.0192 19.9336 21.4631 20.1226 20.8906 20.125H10.08C9.50582 20.1247 8.94747 19.9367 8.49012 19.5895C8.03277 19.2424 7.70152 18.7552 7.54688 18.2022L3.71 4.375H1.75C1.51794 4.375 1.29538 4.28281 1.13128 4.11872C0.967187 3.95462 0.875 3.73206 0.875 3.5C0.875 3.26794 0.967187 3.04538 1.13128 2.88128C1.29538 2.71719 1.51794 2.625 1.75 2.625H4.375C4.5663 2.62496 4.75234 2.68762 4.90464 2.80338C5.05694 2.91913 5.16711 3.08161 5.21828 3.26594L6.25516 7H25.375C25.5099 6.99997 25.643 7.03114 25.7638 7.09105C25.8847 7.15097 25.99 7.23802 26.0717 7.3454C26.1533 7.45277 26.2091 7.57758 26.2345 7.71005C26.2599 7.84253 26.2544 7.97908 26.2183 8.10906ZM9.625 21.875C9.27888 21.875 8.94054 21.9776 8.65275 22.1699C8.36497 22.3622 8.14066 22.6355 8.00821 22.9553C7.87576 23.2751 7.8411 23.6269 7.90863 23.9664C7.97615 24.3059 8.14282 24.6177 8.38756 24.8624C8.63231 25.1072 8.94413 25.2738 9.28359 25.3414C9.62306 25.4089 9.97493 25.3742 10.2947 25.2418C10.6145 25.1093 10.8878 24.885 11.0801 24.5972C11.2724 24.3095 11.375 23.9711 11.375 23.625C11.375 23.1609 11.1906 22.7158 10.8624 22.3876C10.5342 22.0594 10.0891 21.875 9.625 21.875ZM21 21.875C20.6539 21.875 20.3155 21.9776 20.0278 22.1699C19.74 22.3622 19.5157 22.6355 19.3832 22.9553C19.2508 23.2751 19.2161 23.6269 19.2836 23.9664C19.3512 24.3059 19.5178 24.6177 19.7626 24.8624C20.0073 25.1072 20.3191 25.2738 20.6586 25.3414C20.9981 25.4089 21.3499 25.3742 21.6697 25.2418C21.9895 25.1093 22.2628 24.885 22.4551 24.5972C22.6474 24.3095 22.75 23.9711 22.75 23.625C22.75 23.1609 22.5656 22.7158 22.2374 22.3876C21.9093 22.0594 21.4641 21.875 21 21.875Z" />
                <g clip-path="url(#clip0_938_63966)">
                  <path
                    d="M18.8127 13.9974C18.8127 14.1134 18.7666 14.2247 18.6845 14.3068C18.6025 14.3888 18.4912 14.4349 18.3752 14.4349H15.6043V17.2057C15.6043 17.3218 15.5582 17.433 15.4762 17.5151C15.3941 17.5971 15.2829 17.6432 15.1668 17.6432C15.0508 17.6432 14.9395 17.5971 14.8575 17.5151C14.7754 17.433 14.7293 17.3218 14.7293 17.2057V14.4349H11.9585C11.8425 14.4349 11.7312 14.3888 11.6491 14.3068C11.5671 14.2247 11.521 14.1134 11.521 13.9974C11.521 13.8814 11.5671 13.7701 11.6491 13.688C11.7312 13.606 11.8425 13.5599 11.9585 13.5599H14.7293V10.7891C14.7293 10.673 14.7754 10.5618 14.8575 10.4797C14.9395 10.3977 15.0508 10.3516 15.1668 10.3516C15.2829 10.3516 15.3941 10.3977 15.4762 10.4797C15.5582 10.5618 15.6043 10.673 15.6043 10.7891V13.5599H18.3752C18.4912 13.5599 18.6025 13.606 18.6845 13.688C18.7666 13.7701 18.8127 13.8814 18.8127 13.9974Z"
                    stroke="#041E42" stroke-width="0.5" />
                </g>
                <defs>
                  <clipPath id="clip0_938_63966">
                    <rect width="9.33333" height="9.33333" fill="white" transform="translate(10.5 9.33203)" />
                  </clipPath>
                </defs>
              </svg>
            </button>
          </div>
          <a class="type-3-btn" <?= Utility::PrintAllUrl($homePagePromoteSection->button_url) ?> >
            <span><?= $homePagePromoteSection->button_label ?></span>
            <svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path
                d="M18.4152 11.1969L12.5089 17.1031C12.324 17.288 12.0732 17.3919 11.8117 17.3919C11.5502 17.3919 11.2993 17.288 11.1144 17.1031C10.9295 16.9182 10.8256 16.6674 10.8256 16.4058C10.8256 16.1443 10.9295 15.8935 11.1144 15.7086L15.3398 11.4848H3.28125C3.02018 11.4848 2.7698 11.3811 2.58519 11.1965C2.40059 11.0119 2.29688 10.7615 2.29688 10.5004C2.29688 10.2393 2.40059 9.98897 2.58519 9.80436C2.7698 9.61975 3.02018 9.51604 3.28125 9.51604H15.3398L11.1161 5.28979C10.9311 5.10487 10.8272 4.85405 10.8272 4.59253C10.8272 4.331 10.9311 4.08019 11.1161 3.89526C11.301 3.71034 11.5518 3.60645 11.8133 3.60645C12.0748 3.60645 12.3257 3.71034 12.5106 3.89526L18.4168 9.80151C18.5086 9.89309 18.5814 10.0019 18.631 10.1217C18.6806 10.2415 18.7061 10.3699 18.706 10.4995C18.7058 10.6292 18.68 10.7575 18.6301 10.8772C18.5802 10.9969 18.5072 11.1055 18.4152 11.1969Z" />
            </svg>
          </a>
        </form>
      </div>
    </section>
    <?php endif; ?>

    <?=\frontend\widgets\donation_programs\DonationPrograms::widget([
            'title' => Yii::t('site', 'DONATION_PROGRAMS_TITLE'),
            'subtitle' => Yii::t('site', 'DONATION_PROGRAMS_SUBTITLE'),
            'id' => 'homepage-donation-section'
    ])?>

    <?php if(Yii::$app->settings->get('site.home_page_our_impact_hidden')  == 1): ?>

    <section class="home-5th-section">
      <div class="container centerd-section-topic wow fadeInDownBig">
        <h2>  <?= Yii::t('site', 'IMPACT_OF_YOUR_COTRUBUTIONS_TITLE_SECOND_SECTION') ?>  </h2>
        <p>
        <?= Yii::t('site', 'IMPACT_OF_YOUR_COTRUBUTIONS_BRIEF_SECOND_SECTION') ?> 
        </p>
      </div>
      <?php if($homePageSecondImpactSections): ?>

      <div class="impact-slider wow fadeInUpBig">

      <?php foreach ($homePageSecondImpactSections as $key => $homePageSecondImpactSection): ?>


        <div class="impact-slide">

          <?= \frontend\widgets\WebpImage::widget(["src" => $homePageSecondImpactSection->image, "alt" => $homePageSecondImpactSection->title, "loading" => "lazy", 'css' => ""]) ?>

          <div class="impact-slide-content">
            <h3>
              <?= $homePageSecondImpactSection->title ?>
            </h3>
          </div>
        </div>

        <?php endforeach; ?>
      </div>

      <?php endif; ?>

    </section>
    <?php endif ; ?>

    <section class="home-6th-section">
      <div class="container centerd-section-topic wow fadeInDownBig">
        <h2>  <?= Yii::t('site', 'SUPPORT_AND_EMPOWER_TITLE') ?> </h2>
        <p>
        <?= Yii::t('site', 'SUPPORT_AND_EMPOWER_BRIEF') ?> 
        </p>
      </div>
      <div class="container home-6th-container">

      <?php if($homePageSupportSections): ?>
      <?php foreach ($homePageSupportSections as $key => $homePageSupportSection): ?>

        <div class="support-empower-box wow fadeInUpBig">

          <?= \frontend\widgets\WebpImage::widget(["src" => $homePageSupportSection->image, "alt" => $homePageSupportSection->title, "loading" => "lazy", 'css' => ""]) ?>

          <h3> <?= $homePageSupportSection->title ?> </h3>
          <p>
          <?= $homePageSupportSection->brief ?>
          </p>


        <?php if ($homePageSupportSection->url_1): ?>
          <a class="type-4-btn"  <?= Utility::PrintAllUrl($homePageSupportSection->url_1) ?> >
            <span> <?= $homePageSupportSection->button_text ?></span>
            <svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path
                d="M18.4152 11.1969L12.5089 17.1031C12.324 17.288 12.0732 17.3919 11.8117 17.3919C11.5502 17.3919 11.2993 17.288 11.1144 17.1031C10.9295 16.9182 10.8256 16.6674 10.8256 16.4058C10.8256 16.1443 10.9295 15.8935 11.1144 15.7086L15.3398 11.4848H3.28125C3.02018 11.4848 2.7698 11.3811 2.58519 11.1965C2.40059 11.0119 2.29688 10.7615 2.29688 10.5004C2.29688 10.2393 2.40059 9.98897 2.58519 9.80436C2.7698 9.61975 3.02018 9.51604 3.28125 9.51604H15.3398L11.1161 5.28979C10.9311 5.10487 10.8272 4.85405 10.8272 4.59253C10.8272 4.331 10.9311 4.08019 11.1161 3.89526C11.301 3.71034 11.5518 3.60645 11.8133 3.60645C12.0748 3.60645 12.3257 3.71034 12.5106 3.89526L18.4168 9.80151C18.5086 9.89309 18.5814 10.0019 18.631 10.1217C18.6806 10.2415 18.7061 10.3699 18.706 10.4995C18.7058 10.6292 18.68 10.7575 18.6301 10.8772C18.5802 10.9969 18.5072 11.1055 18.4152 11.1969Z">
              </path>
            </svg>
          </a>
          <?php endif ?>
        </div>
        <?php endforeach; ?>

        <?php endif; ?>

      </div>
    </section>
    <section class="slider-with-progress-bar-section">
      <div class="container">
        <div class="container centerd-section-topic wow fadeInDownBig">
          <h2> <?= Yii::t('site', 'LATEST_NEWS') ?> </h2>
        </div>

        <div class="slider-with-progress-bar-main-slider">
  

        
        <?php foreach ($latestNews as $key => $latestNew): ?>

        <?php

        $delay = 0.1 * ($key + 1); 
        ?>

          <div class="slider-with-progress-bar--single-slide wow fadeInUpBig"  data-wow-delay=" <?php echo $delay; ?>s">
            <div class="slider-with-progress-bar--single-slide-img">

              <?= \frontend\widgets\WebpImage::widget(["src" => $latestNew->image, "alt" => $latestNew->title, "loading" => "lazy", 'css' => "mw-100"]) ?>

            </div>
            <div class="slider-with-progress-bar--single-slide-content">
              <div class="slider-with-progress-bar--single-slide-date">
                <picture>
                  <img src="/theme/assets/Icons/CalendarDot.svg" alt="" />
                </picture>
                <span>  <?= $latestNew->getPublishedAtFullDate($latestNew->published_at) ?> </span>
              </div>
              <div class="d-flex flex-column justify-content-between h-100">
                <div class="slider-with-progress-bar--single-slide-title">
                  <h3>
                      <?= $latestNew->title ?>
                  </h3>
                </div>
                <div class="slider-with-progress-bar--single-slide-content-inner">
                <div class="buttons customize-home-page-read-more">
                      <a href="<?= Url::to(["/news/view", "slug" => $latestNew->slug]) ?>" class="type-4-btn">
                        <span> <?= Yii::t('site', 'READ_MORE') ?> </span>
                        <i class="fa-solid fa-arrow-right"></i>
                      </a>
                      <?= frontend\widgets\cards_share_button\CardsShareButton::widget() ?>

                    </div>
                </div>
              </div>
            </div>
          </div>
          <?php endforeach; ?>


        </div>

        <div class="slider-with-progress-bar--controllers">
          <div class="slider-with-progress-bar--controllers-arrow">
            <span class="slider-with-progress-bar--controllers-arrow-prev">
              <svg width="17" height="13" viewBox="0 0 17 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                  d="M1.33917e-06 6.50077C1.31764e-06 6.25456 0.107461 6.01844 0.298738 5.84434C0.490016 5.67024 0.749444 5.57243 1.01995 5.57243L13.5144 5.57243L9.13537 1.58753C8.94376 1.41313 8.83611 1.17659 8.83611 0.929952C8.83611 0.683314 8.94376 0.446777 9.13537 0.272377C9.32698 0.0979774 9.58686 -3.05597e-07 9.85783 -3.29286e-07C10.1288 -3.52976e-07 10.3887 0.0979773 10.5803 0.272377L16.7 5.84242C16.7951 5.92867 16.8705 6.03115 16.922 6.14399C16.9735 6.25684 17 6.37782 17 6.5C17 6.62218 16.9735 6.74316 16.922 6.85601C16.8705 6.96885 16.7951 7.07133 16.7 7.15758L10.5803 12.7276C10.4854 12.814 10.3728 12.8825 10.2488 12.9292C10.1249 12.9759 9.99201 13 9.85783 13C9.72366 13 9.5908 12.9759 9.46684 12.9292C9.34288 12.8825 9.23024 12.814 9.13537 12.7276C9.04049 12.6413 8.96523 12.5388 8.91389 12.4259C8.86254 12.3131 8.83611 12.1922 8.83611 12.07C8.83611 11.9479 8.86254 11.827 8.91389 11.7142C8.96523 11.6013 9.04049 11.4988 9.13537 11.4125L13.5144 7.42911L1.01995 7.42912C0.749444 7.42912 0.490016 7.33131 0.298738 7.15721C0.107461 6.98311 1.36069e-06 6.74699 1.33917e-06 6.50077Z" />
              </svg>
            </span>
            <span class="slider-with-progress-bar--controllers-arrow-next">
              <svg width="17" height="13" viewBox="0 0 17 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                  d="M1.33917e-06 6.50077C1.31764e-06 6.25456 0.107461 6.01844 0.298738 5.84434C0.490016 5.67024 0.749444 5.57243 1.01995 5.57243L13.5144 5.57243L9.13537 1.58753C8.94376 1.41313 8.83611 1.17659 8.83611 0.929952C8.83611 0.683314 8.94376 0.446777 9.13537 0.272377C9.32698 0.0979774 9.58686 -3.05597e-07 9.85783 -3.29286e-07C10.1288 -3.52976e-07 10.3887 0.0979773 10.5803 0.272377L16.7 5.84242C16.7951 5.92867 16.8705 6.03115 16.922 6.14399C16.9735 6.25684 17 6.37782 17 6.5C17 6.62218 16.9735 6.74316 16.922 6.85601C16.8705 6.96885 16.7951 7.07133 16.7 7.15758L10.5803 12.7276C10.4854 12.814 10.3728 12.8825 10.2488 12.9292C10.1249 12.9759 9.99201 13 9.85783 13C9.72366 13 9.5908 12.9759 9.46684 12.9292C9.34288 12.8825 9.23024 12.814 9.13537 12.7276C9.04049 12.6413 8.96523 12.5388 8.91389 12.4259C8.86254 12.3131 8.83611 12.1922 8.83611 12.07C8.83611 11.9479 8.86254 11.827 8.91389 11.7142C8.96523 11.6013 9.04049 11.4988 9.13537 11.4125L13.5144 7.42911L1.01995 7.42912C0.749444 7.42912 0.490016 7.33131 0.298738 7.15721C0.107461 6.98311 1.36069e-06 6.74699 1.33917e-06 6.50077Z" />
              </svg>
            </span>
          </div>
          <div class="slider-with-progress-bar--progress">
            <span class="" id="slider-progress" data-progress="0%"></span>
          </div>
          <a class="type-4-btn"  href="<?= Url::to(['/news/index']); ?>">
            <span> <?=  Yii::t('site', 'DISCOVER_ALL') ?> </span>
            <svg width="17" height="13" viewBox="0 0 17 13" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path
                d="M1.33917e-06 6.50077C1.31764e-06 6.25456 0.107461 6.01844 0.298738 5.84434C0.490016 5.67024 0.749444 5.57243 1.01995 5.57243L13.5144 5.57243L9.13537 1.58753C8.94376 1.41313 8.83611 1.17659 8.83611 0.929952C8.83611 0.683314 8.94376 0.446777 9.13537 0.272377C9.32698 0.0979774 9.58686 -3.05597e-07 9.85783 -3.29286e-07C10.1288 -3.52976e-07 10.3887 0.0979773 10.5803 0.272377L16.7 5.84242C16.7951 5.92867 16.8705 6.03115 16.922 6.14399C16.9735 6.25684 17 6.37782 17 6.5C17 6.62218 16.9735 6.74316 16.922 6.85601C16.8705 6.96885 16.7951 7.07133 16.7 7.15758L10.5803 12.7276C10.4854 12.814 10.3728 12.8825 10.2488 12.9292C10.1249 12.9759 9.99201 13 9.85783 13C9.72366 13 9.5908 12.9759 9.46684 12.9292C9.34288 12.8825 9.23024 12.814 9.13537 12.7276C9.04049 12.6413 8.96523 12.5388 8.91389 12.4259C8.86254 12.3131 8.83611 12.1922 8.83611 12.07C8.83611 11.9479 8.86254 11.827 8.91389 11.7142C8.96523 11.6013 9.04049 11.4988 9.13537 11.4125L13.5144 7.42911L1.01995 7.42912C0.749444 7.42912 0.490016 7.33131 0.298738 7.15721C0.107461 6.98311 1.36069e-06 6.74699 1.33917e-06 6.50077Z" />
            </svg>
          </a>
        </div>
      </div>
    </section>
    <?php if(Yii::$app->settings->get('site.home_page_dar_abu_abdallah_hidden')  == 1): ?>

    <section class="home-8th-section">
      <div class="container centerd-section-topic wow fadeInDownBig">
        <h2>  <?= Yii::t('site', 'DAR_ABU_ABDALLAH_TITLE') ?> </h2>
        <p>
        <?= Yii::t('site', 'DAR_ABU_ABDALLAH_BRIEF') ?>
        </p>
      </div>
      <?php if($DarAbuAbdullahBlocks): ?>

      <div class="container home-8th-section-container">

      <?php foreach ($DarAbuAbdullahBlocks as $DarAbuAbdullahBlock): ?>

        <div class="dar-abu-abdalllah-card wow fadeInUpBig" data-wow-delay=".2">

          <?= \frontend\widgets\WebpImage::widget(["src" => $DarAbuAbdullahBlock->image, "alt" => $DarAbuAbdullahBlock->title, "loading" => "lazy", 'css' => ""]) ?>

          <div class="dar-abu-abdalllah-card-content">
            <h3><?= $DarAbuAbdullahBlock->title ?> </h3>
            <p>
            <?= $DarAbuAbdullahBlock->brief ?>
            </p>
          </div>
        </div>
        <?php endforeach; ?>

      </div>
      <?php endif; ?>

      <div class="container d-flex justify-content-center align-items-center my-5 gap-2">
        <a class="type-2-btn" href="#">
        <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g clip-path="url(#clip0_2559_1896)">
              <path
                d="M21.5934 13.7245C21.3482 13.5354 21.067 13.3983 20.7671 13.3215C20.4671 13.2446 20.1547 13.2295 19.8488 13.2773C21.6094 11.4998 22.5 9.73259 22.5 8.00009C22.5 5.51853 20.5041 3.50009 18.0506 3.50009C17.3996 3.496 16.7556 3.63445 16.1638 3.90573C15.5721 4.17701 15.0468 4.57454 14.625 5.0704C14.2032 4.57454 13.6779 4.17701 13.0862 3.90573C12.4944 3.63445 11.8504 3.496 11.1994 3.50009C8.74594 3.50009 6.75 5.51853 6.75 8.00009C6.75 9.03134 7.05375 10.0335 7.69312 11.0938C7.16947 11.2265 6.69158 11.4987 6.31031 11.8813L4.18969 14.0001H1.5C1.10218 14.0001 0.720644 14.1581 0.43934 14.4394C0.158035 14.7207 0 15.1023 0 15.5001L0 19.2501C0 19.6479 0.158035 20.0294 0.43934 20.3107C0.720644 20.5921 1.10218 20.7501 1.5 20.7501H11.25C11.3113 20.7501 11.3724 20.7426 11.4319 20.7276L17.4319 19.2276C17.4701 19.2185 17.5075 19.2059 17.5434 19.1901L21.1875 17.6395L21.2288 17.6207C21.579 17.4457 21.8789 17.1844 22.1002 16.8615C22.3215 16.5385 22.457 16.1646 22.4939 15.7748C22.5307 15.385 22.4678 14.9923 22.3109 14.6336C22.154 14.2749 21.9084 13.962 21.5972 13.7245H21.5934ZM11.1994 5.00009C11.7803 4.99159 12.3505 5.15653 12.8371 5.47384C13.3238 5.79114 13.7047 6.24638 13.9313 6.78134C13.9878 6.9189 14.0839 7.03655 14.2074 7.11935C14.3309 7.20215 14.4763 7.24636 14.625 7.24636C14.7737 7.24636 14.9191 7.20215 15.0426 7.11935C15.1661 7.03655 15.2622 6.9189 15.3187 6.78134C15.5453 6.24638 15.9262 5.79114 16.4129 5.47384C16.8995 5.15653 17.4697 4.99159 18.0506 5.00009C19.6491 5.00009 21 6.37353 21 8.00009C21 9.82915 19.5197 11.8982 16.7194 13.9907L15.6797 14.2298C15.7709 13.8443 15.7738 13.4431 15.6879 13.0564C15.6021 12.6696 15.4298 12.3073 15.1841 11.9966C14.9383 11.6859 14.6254 11.4348 14.2688 11.2622C13.9122 11.0897 13.5212 11 13.125 11.0001H9.43875C8.62969 9.90884 8.25 8.94884 8.25 8.00009C8.25 6.37353 9.60094 5.00009 11.1994 5.00009ZM1.5 15.5001H3.75V19.2501H1.5V15.5001ZM20.5716 16.2698L17.0091 17.7866L11.1562 19.2501H5.25V15.0604L7.37156 12.9398C7.51035 12.7999 7.67555 12.689 7.85758 12.6135C8.03961 12.538 8.23482 12.4995 8.43188 12.5001H13.125C13.4234 12.5001 13.7095 12.6186 13.9205 12.8296C14.1315 13.0406 14.25 13.3267 14.25 13.6251C14.25 13.9235 14.1315 14.2096 13.9205 14.4206C13.7095 14.6316 13.4234 14.7501 13.125 14.7501H10.5C10.3011 14.7501 10.1103 14.8291 9.96967 14.9698C9.82902 15.1104 9.75 15.3012 9.75 15.5001C9.75 15.699 9.82902 15.8898 9.96967 16.0304C10.1103 16.1711 10.3011 16.2501 10.5 16.2501H13.5C13.5565 16.2499 13.6127 16.2436 13.6678 16.2313L19.9491 14.7866L19.9781 14.7791C20.1699 14.7259 20.3745 14.7455 20.5527 14.8341C20.7309 14.9227 20.87 15.074 20.9433 15.259C21.0167 15.444 21.0189 15.6496 20.9498 15.8362C20.8806 16.0228 20.7449 16.1772 20.5687 16.2698H20.5716Z" />
            </g>
            <defs>
              <clipPath id="clip0_2559_1896">
                <rect width="24" height="24" fill="white" transform="translate(0 0.5)" />
              </clipPath>
            </defs>
          </svg>
          <span> <?=  Yii::t('site', 'DONATE') ?> </span>
        </a>
        <a class="type-3-btn" href="<?= Url::to(['/dar-abu-abdullah']); ?>">
          <span> <?=  Yii::t('site', 'LEARN_MORE') ?> </span>
          <svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
              d="M18.4152 11.1969L12.5089 17.1031C12.324 17.288 12.0732 17.3919 11.8117 17.3919C11.5502 17.3919 11.2993 17.288 11.1144 17.1031C10.9295 16.9182 10.8256 16.6674 10.8256 16.4058C10.8256 16.1443 10.9295 15.8935 11.1144 15.7086L15.3398 11.4848H3.28125C3.02018 11.4848 2.7698 11.3811 2.58519 11.1965C2.40059 11.0119 2.29688 10.7615 2.29688 10.5004C2.29688 10.2393 2.40059 9.98897 2.58519 9.80436C2.7698 9.61975 3.02018 9.51604 3.28125 9.51604H15.3398L11.1161 5.28979C10.9311 5.10487 10.8272 4.85405 10.8272 4.59253C10.8272 4.331 10.9311 4.08019 11.1161 3.89526C11.301 3.71034 11.5518 3.60645 11.8133 3.60645C12.0748 3.60645 12.3257 3.71034 12.5106 3.89526L18.4168 9.80151C18.5086 9.89309 18.5814 10.0019 18.631 10.1217C18.6806 10.2415 18.7061 10.3699 18.706 10.4995C18.7058 10.6292 18.68 10.7575 18.6301 10.8772C18.5802 10.9969 18.5072 11.1055 18.4152 11.1969Z" "></path>
          </svg>
        </a>
      </div>
    </section>
    <?php endif ; ?>

    <?php if($homePageLastSection): ?>

    
    <section class="home-last-section wow fadeInUpBig">
      <div class="container">
        <div class="last-section-content">
          <h2>   <?= $homePageLastSection->title ?> </h2>
          <h3> <?= $homePageLastSection->second_title ?> </h3>
          <div class="last-section-cards">
     
          <?php foreach ($homePageLastSection->bmsFeatures as $key => $item): ?>

            <div class="last-section-card">

              <?= \frontend\widgets\WebpImage::widget(["src" => $item["image"], "alt" =>  $item["title_" . $lng] , "loading" => "lazy", 'css' => ""]) ?>

              <div class="last-section-card-content">
                <p> <?= $item["title_" . $lng] ?> </p>
                <span> <?= $item["brief_" . $lng] ?></span>
              </div>
            </div>
            <?php endforeach ?>

          </div>

          <div class="download-box">
          <?php if($homePageLastSection->url_1): ?>
              <a  <?= Utility::PrintAllUrl($homePageLastSection->url_1) ?> >

                <?= \frontend\widgets\WebpImage::widget(["src" => $homePageLastSection->button_image_1, "alt" => $homePageLastSection->title, "loading" => "lazy", 'css' => ""]) ?>

              </a>
            <?php endif; ?>
            <?php if($homePageLastSection->url_2): ?>

              <a <?= Utility::PrintAllUrl($homePageLastSection->url_2) ?> >
   
                <?= \frontend\widgets\WebpImage::widget(["src" => $homePageLastSection->button_image_2, "alt" => $homePageLastSection->title, "loading" => "lazy", 'css' => ""]) ?>

                
              </a>
            <?php endif; ?>

          </div>
        </div>
        <picture class="last-section-main-pic">
          <?= \frontend\widgets\WebpImage::widget(["src" => $homePageLastSection->image, "alt" => $homePageLastSection->title, "loading" => "lazy", 'css' => "mw-100"]) ?>

        </picture>
      </div>
    </section>
    <?php endif; ?>

    <?php if($lng=="en"): ?>

<?php
$this->registerJsVar('language', Yii::$app->language);
$script = <<< JS
        new WOW().init();

 $(document).ready(function () {
     $(".home-3rd-section-form .add-to-cart-btn").on('click', function(){
  
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
                          $(".cart-items-count").text(data['cart_items_count']);
                          form.find('.error-message').addClass('d-none');
                          form.find(".amount").val("");
                          var toastSuccess = document.querySelector('.toast-success');
                          var toast = new bootstrap.Toast(toastSuccess);
                          toast.show();
                      }
                  }
              })
          });
     

  });
  $(document).ready(function () {
    $('.home-3rd-section-form .donation-buttons button').on('click', function (e) {
    e.preventDefault(); 
    var amount = $(this).text().trim();
    var form = $(this).closest('.home-3rd-section-form');
    var input = form.find('.amount-input input[type="number"]');
    if (input.length) {
      input.val(amount);
    }
  });
  $('.home-3rd-section-form').on('submit', function (e) {
    var form = $(this);
    var input = form.find('.amount-input input[type="number"]');
    var error = form.find('.error-message');
    var amount = parseFloat(input.val());
    if (isNaN(amount) || amount <= 0) {
      e.preventDefault();
      error.show();
    } else {
      error.hide();
    }
  });
});

  
$('.hero-content-md-container').slick({
      infinite: true,
      slidesToShow: 1,
      slidesToScroll: 1,
      speed: 1000,
      dots: true,
      arrows: false,
      autoplay: true,
      autoplaySpeed: 2000,
      nextArrow:
        '<button class="slick-next"><i class="fa-solid fa-chevron-right"></i></button>',
      prevArrow:
        '<button class="slick-prev"><i class="fa-solid fa-chevron-left"></i></button>',
      asNavFor: '.home-hero-slider ',
    });


    const testimonialsSlider = $(".testimonials-container-main-slider");
    const testimonialsProgress = $("#testimonials-slider-progress");

    testimonialsSlider.slick({
      dots: false,
      infinite: false,
      slidesToShow: 4,
      slidesToScroll: 4,
      nextArrow: $(".testimonials--controllers-arrow-next"),
      prevArrow: $(".testimonials--controllers-arrow-prev"),
      responsive: [
        {
          breakpoint: 1200,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 3,
          },
        },
        {
          breakpoint: 991,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2,
          },
        },
        {
          breakpoint: 767,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
          },
        },
      ],
    });

    let totalTestimonialsSlides =
      testimonialsSlider.slick("getSlick").slideCount;

    // Calculate total slide groups based on current slidesToShow
    function calculateTotalGroups(slider, totalSlides) {
      const slidesToShow = slider.slick("slickGetOption", "slidesToShow");
      return Math.ceil(totalSlides / slidesToShow);
    }

    // Update progress bar for testimonials
    function updateTestimonialsProgress(currentSlide, nextSlide) {
      const slidesToShow = testimonialsSlider.slick(
        "slickGetOption",
        "slidesToShow"
      );
      const slidesToScroll = testimonialsSlider.slick(
        "slickGetOption",
        "slidesToScroll"
      );
      const totalGroups = calculateTotalGroups(
        testimonialsSlider,
        totalTestimonialsSlides
      );
      const currentGroup = Math.ceil(
        (nextSlide + slidesToScroll) / slidesToShow
      );
      const completedPercentage = (currentGroup / totalGroups) * 100;

      testimonialsProgress.css("width", completedPercentage);

      testimonialsProgress.attr("data-progress", Math.round(completedPercentage));

    }

    // Initial progress bar state for testimonials
    updateTestimonialsProgress(0, 0);

    // Update progress during slide change (beforeChange)
    testimonialsSlider.on(
      "beforeChange",
      function (event, slick, currentSlide, nextSlide) {
        updateTestimonialsProgress(currentSlide, nextSlide);
      }
    );

    // Recalculate progress after slide change (afterChange)
    testimonialsSlider.on(
      "afterChange",
      function (event, slick, currentSlide) {
        updateTestimonialsProgress(currentSlide, currentSlide);
      }
    );

    // Handle window resize to recalculate progress
    $(window).on("resize", function () {
      totalTestimonialsSlides =
        testimonialsSlider.slick("getSlick").slideCount;
      updateTestimonialsProgress(
        testimonialsSlider.slick("slickCurrentSlide"),
        testimonialsSlider.slick("slickCurrentSlide")
      );
    });

    // ===================================================
    // Main Slider with Progress Bar
    // ===================================================
    const mainSlider = $(".slider-with-progress-bar-main-slider");
    const mainProgress = $("#slider-progress");

    mainSlider.slick({
      dots: false,
      infinite: false,
      slidesToShow: 4,
      slidesToScroll: 4,
      nextArrow: $(".slider-with-progress-bar--controllers-arrow-next"),
      prevArrow: $(".slider-with-progress-bar--controllers-arrow-prev"),
      responsive: [
        {
          breakpoint: 1200,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 3,
          },
        },
        {
          breakpoint: 991,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2,
          },
        },
        {
          breakpoint: 500,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
          },
        },
      ],
    });

    let totalMainSlides = mainSlider.slick("getSlick").slideCount;

    // Update progress bar for main slider
    function updateMainProgress(currentSlide, nextSlide) {
      const slidesToShow = mainSlider.slick(
        "slickGetOption",
        "slidesToShow"
      );
      const slidesToScroll = mainSlider.slick(
        "slickGetOption",
        "slidesToScroll"
      );
      const totalGroups = calculateTotalGroups(mainSlider, totalMainSlides);
      const currentGroup = Math.ceil(
        (nextSlide + slidesToScroll) / slidesToShow
      );
      const completedPercentage = (currentGroup / totalGroups) * 100;

      // Set the width of the progress bar as a percentage
      mainProgress.css("width", completedPercentage + "%");

      // Update the data-progress attribute with the rounded percentage
      mainProgress.attr("data-progress", Math.round(completedPercentage));
          }

    // Initial progress bar state for main slider
    updateMainProgress(0, 0);

    // Update progress during slide change (beforeChange)
    mainSlider.on(
      "beforeChange",
      function (event, slick, currentSlide, nextSlide) {
        updateMainProgress(currentSlide, nextSlide);
      }
    );

    // Recalculate progress after slide change (afterChange)
    mainSlider.on("afterChange", function (event, slick, currentSlide) {
      updateMainProgress(currentSlide, currentSlide);
    });

    // Handle window resize to recalculate progress
    $(window).on("resize", function () {
      totalMainSlides = mainSlider.slick("getSlick").slideCount;
      updateMainProgress(
        mainSlider.slick("slickCurrentSlide"),
        mainSlider.slick("slickCurrentSlide")
      );
    });

    
    $(document).ready(function () {
      $(".impact-slider").slick({
        infinite: true,
        slidesToShow: 3,
        slidesToScroll: 1,
        centerMode: true,
        centerPadding: "200px",
        speed: 1000,
        autoplay: true,
        autoplaySpeed: 2000,
        responsive: [
          {
            breakpoint: 1300,
            settings: {
              centerPadding: "100px",
            },
          },
          {
            breakpoint: 992,
            settings: {
              centerPadding: "100px",
              slidesToShow: 2,
            },
          },
          {
            breakpoint: 767,
            settings: {
              centerPadding: "100px",
              slidesToShow: 1,
            },
          },
          {
            breakpoint: 450,
            settings: {
              centerPadding: "50px",
              slidesToShow: 1,
            },
          },
          {
            breakpoint: 400,
            settings: {
              centerPadding: "30px",
              slidesToShow: 1,
            },
          },
        ],
      });
    });

    $(document).ready(function () {
      $(".colored-slider").each(function (index, element) {
        let slider = $(element);

        slider.slick({
          dots: true,
          infinite: true,
          slidesToShow: 4,
          slidesToScroll: 4,
          nextArrow: slider.closest(".slider-wrapper").find(".colored-slider-next"),
          prevArrow: slider.closest(".slider-wrapper").find(".colored-slider-prev"),
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
            {
            breakpoint: 576,
            settings: {
              slidesToShow: 1.3,
            },
          },
          ],
        });
      });
    });

    $(document).ready(function () {
      // Hero Slider
      $(".home-hero-slider").slick({
        dots: true,
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        speed: 1000,
        autoplay: true,
        autoplaySpeed: 2000,
        fade: true,
        asNavFor: '.hero-content-md-container',
        // nextArrow: $(".home-hero-slider-arrows-next"),
        // prevArrow: $(".home-hero-slider-arrows-prev"),
        appendDots: $(".hero-dots-container"),
        customPaging: function (slider, i) {
          return '<span class="custom-dot"></span>';
        },
      });
    });

JS;
$this->registerJs($script);
?>

<?php else: ?>

<?php
    $script = <<< JS
    new WOW().init();


$('.home-3rd-section-form .donation-buttons button').on('click', function (e) {
    e.preventDefault(); 
    var amount = $(this).text().trim();
    var form = $(this).closest('.home-3rd-section-form');
    var input = form.find('.amount-input input[type="number"]');
    if (input.length) {
      input.val(amount);
    }
  });

    $('.hero-content-md-container').slick({
      rtl: true,
      infinite: true,
      slidesToShow: 1,
      slidesToScroll: 1,
      speed: 1000,
      dots: true,
      arrows: false,
      autoplay: true,
      autoplaySpeed: 2000,
      nextArrow:
        '<button class="slick-next"><i class="fa-solid fa-chevron-right"></i></button>',
      prevArrow:
        '<button class="slick-prev"><i class="fa-solid fa-chevron-left"></i></button>',
      asNavFor: '.home-hero-slider ',
    });


    // ===================================================
    // Testimonials Slider with Progress Bar
    // ===================================================
    const testimonialsSlider = $(".testimonials-container-main-slider");
    const testimonialsProgress = $("#testimonials-slider-progress");

    testimonialsSlider.slick({
      dots: false,
      infinite: false,
      slidesToShow: 4,
      slidesToScroll: 4,
      nextArrow: $(".testimonials--controllers-arrow-next"),
      prevArrow: $(".testimonials--controllers-arrow-prev"),
      responsive: [
        {
          breakpoint: 1200,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 3,
          },
        },
        {
          breakpoint: 991,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2,
          },
        },
        {
          breakpoint: 767,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
          },
        },
      ],
    });

    let totalTestimonialsSlides =
      testimonialsSlider.slick("getSlick").slideCount;

    // Calculate total slide groups based on current slidesToShow
    function calculateTotalGroups(slider, totalSlides) {
      const slidesToShow = slider.slick("slickGetOption", "slidesToShow");
      return Math.ceil(totalSlides / slidesToShow);
    }

    // Update progress bar for testimonials
    function updateTestimonialsProgress(currentSlide, nextSlide) {
      const slidesToShow = testimonialsSlider.slick(
        "slickGetOption",
        "slidesToShow"
      );
      const slidesToScroll = testimonialsSlider.slick(
        "slickGetOption",
        "slidesToScroll"
      );
      const totalGroups = calculateTotalGroups(
        testimonialsSlider,
        totalTestimonialsSlides
      );
      const currentGroup = Math.ceil(
        (nextSlide + slidesToScroll) / slidesToShow
      );
      const completedPercentage = (currentGroup / totalGroups) * 100;

      testimonialsProgress.css("width", completedPercentage);

testimonialsProgress.attr("data-progress", Math.round(completedPercentage));


    }

    // Initial progress bar state for testimonials
    updateTestimonialsProgress(0, 0);

    // Update progress during slide change (beforeChange)
    testimonialsSlider.on(
      "beforeChange",
      function (event, slick, currentSlide, nextSlide) {
        updateTestimonialsProgress(currentSlide, nextSlide);
      }
    );

    // Recalculate progress after slide change (afterChange)
    testimonialsSlider.on(
      "afterChange",
      function (event, slick, currentSlide) {
        updateTestimonialsProgress(currentSlide, currentSlide);
      }
    );

    // Handle window resize to recalculate progress
    $(window).on("resize", function () {
      totalTestimonialsSlides =
        testimonialsSlider.slick("getSlick").slideCount;
      updateTestimonialsProgress(
        testimonialsSlider.slick("slickCurrentSlide"),
        testimonialsSlider.slick("slickCurrentSlide")
      );
    });

    // ===================================================
    // Main Slider with Progress Bar
    // ===================================================
    const mainSlider = $(".slider-with-progress-bar-main-slider");
    const mainProgress = $("#slider-progress");

    mainSlider.slick({
      dots: false,
      infinite: false,
      slidesToShow: 4,
      slidesToScroll: 4,
      rtl: true,
      nextArrow: $(".slider-with-progress-bar--controllers-arrow-next"),
      prevArrow: $(".slider-with-progress-bar--controllers-arrow-prev"),
      responsive: [
        {
          breakpoint: 1200,
          settings: {
            slidesToShow: 3,
            slidesToScroll: 3,
          },
        },
        {
          breakpoint: 991,
          settings: {
            slidesToShow: 2,
            slidesToScroll: 2,
          },
        },
        {
          breakpoint: 500,
          settings: {
            slidesToShow: 1,
            slidesToScroll: 1,
          },
        },
      ],
    });

    let totalMainSlides = mainSlider.slick("getSlick").slideCount;

    // Update progress bar for main slider
    function updateMainProgress(currentSlide, nextSlide) {
      const slidesToShow = mainSlider.slick(
        "slickGetOption",
        "slidesToShow"
      );
      const slidesToScroll = mainSlider.slick(
        "slickGetOption",
        "slidesToScroll"
      );
      const totalGroups = calculateTotalGroups(mainSlider, totalMainSlides);
      const currentGroup = Math.ceil(
        (nextSlide + slidesToScroll) / slidesToShow
      );
      const completedPercentage = (currentGroup / totalGroups) * 100;

      mainProgress.css("width", completedPercentage + "%");

      // Update the data-progress attribute with the rounded percentage
      mainProgress.attr("data-progress", Math.round(completedPercentage));
          
    }

    // Initial progress bar state for main slider
    updateMainProgress(0, 0);

    // Update progress during slide change (beforeChange)
    mainSlider.on(
      "beforeChange",
      function (event, slick, currentSlide, nextSlide) {
        updateMainProgress(currentSlide, nextSlide);
      }
    );

    // Recalculate progress after slide change (afterChange)
    mainSlider.on("afterChange", function (event, slick, currentSlide) {
      updateMainProgress(currentSlide, currentSlide);
    });

    // Handle window resize to recalculate progress
    $(window).on("resize", function () {
      totalMainSlides = mainSlider.slick("getSlick").slideCount;
      updateMainProgress(
        mainSlider.slick("slickCurrentSlide"),
        mainSlider.slick("slickCurrentSlide")
      );
    });


    $(document).ready(function () {
      $(".impact-slider").slick({
        infinite: true,
        slidesToShow: 3,
        slidesToScroll: 1,
        rtl: true,
        centerMode: true,
        centerPadding: "200px",
        speed: 1000,
        autoplay: true,
        autoplaySpeed: 2000,
        responsive: [
          {
            breakpoint: 1300,
            settings: {
              centerPadding: "100px",
            },
          },
          {
            breakpoint: 992,
            settings: {
              centerPadding: "100px",
              slidesToShow: 2,
            },
          },
          {
            breakpoint: 767,
            settings: {
              centerPadding: "100px",
              slidesToShow: 1,
            },
          },
          {
            breakpoint: 450,
            settings: {
              centerPadding: "50px",
              slidesToShow: 1,
            },
          },
          {
            breakpoint: 400,
            settings: {
              centerPadding: "30px",
              slidesToShow: 1,
            },
          },
        ],
      });
    });

    $(document).ready(function () {
      let direction = $("main").hasClass("arabic-version") ? "yes" : "no";
      $(".colored-slider").each(function (index, element) {
        let slider = $(element);

        slider.slick({
          rtl: direction,
          dots: true,
          infinite: true,
          rtl: true,
          slidesToShow: 4,
          slidesToScroll: 4,
          nextArrow: slider.closest(".slider-wrapper").find(".colored-slider-next"),
          prevArrow: slider.closest(".slider-wrapper").find(".colored-slider-prev"),
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

    $(document).ready(function () {
      // Hero Slider
      $(".home-hero-slider").slick({
        dots: true,
        infinite: true,
        slidesToShow: 1,
        slidesToScroll: 1,
        speed: 1000,
        autoplay: true,
        autoplaySpeed: 2000,
        fade: true,
        asNavFor: '.hero-content-md-container',
        // nextArrow: $(".home-hero-slider-arrows-next"),
        // prevArrow: $(".home-hero-slider-arrows-prev"),
        appendDots: $(".hero-dots-container"),
        customPaging: function (slider, i) {
          return '<span class="custom-dot"></span>';
        },
      });
    });

  

JS;
$this->registerJs($script);
?>

<?php endif; ?>