<?php
$this->registerCssFile("/theme/css/our-value.css", ['depends' => [\frontend\assets\AppAsset::className()],]);
$this->registerCssFile("/theme/css/offered-tenders-inner.css", ['depends' => [\frontend\assets\AppAsset::className()],]);
use yeesoft\helpers\Html;


use yii\helpers\Url;
use frontend\widgets\HeaderImage;

$this->title =  $targetOfferedTender->title ;
$this->description = $targetOfferedTender->brief;
$this->og_image =  $targetOfferedTender->image   ;
$this->type = "article";

$lng = Yii::$app->language;

?>


<?= HeaderImage::widget(['is_inner'=> true , 'path'=>'/offer-tenders', 'bread_crumb_slug'=>$targetOfferedTender->slug , 'bread_crumb_title'=>$this->title  ]) ?>



   <section>
    <div class="container offered-tenders-inner-container">
        <div class="offered-tenders-inner-content">
            <div class="effective-card-date">
                <picture>
                    <img src="/theme/assets/Icons/CalendarDot.svg" alt="">
                </picture>
                <h5> <?=  Yii::t('site', 'APPLICATION_DATE') ?> :<?=  $targetOfferedTender->getPublishedAtFullDate($targetOfferedTender->published_at)  ?></h5>
            </div>
            <h3>
                <?= $targetOfferedTender->title ?>
            </h3>
            <h4> <?=  Yii::t('site', 'PARCEL_COMPONENTS') ?></h4>
            <p><?= $targetOfferedTender->brief ?></p>
            
            <h4>  <?=  Yii::t('site', 'LOGISTICS_PARTNERS') ?> :</h4>
            <p><?= $targetOfferedTender->second_title ?></p>
            <h4>  <?=  Yii::t('site', 'SUPPLY_DETAILS_POLICY') ?>  :</h4>
            <?= $targetOfferedTender->content ?>

            <h4>  <?=  Yii::t('site', 'GENERAL_STATISTICS_AND_REPORTS') ?> </h4>
            <a  href="<?= $targetOfferedTender->file; ?>" target="_blank" class="type-4-btn ">
                <span><?=  Yii::t('site', 'DOWNLOAD_FROM_HERE') ?> </span></a>

            <h4> <?=  Yii::t('site', 'SUBMITTING_A_TENDER') ?> :</h4>
            <div class="offered-tenders-inner-blue-box">
                <p><?= $targetOfferedTender->submitting_title ?></p>
            </div>
            <a class="type-3-btn">
                <span> <?=  Yii::t('site', 'PAY_AND_SUBMISSION') ?> </span>
                <svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M18.4152 11.1969L12.5089 17.1031C12.324 17.288 12.0732 17.3919 11.8117 17.3919C11.5502 17.3919 11.2993 17.288 11.1144 17.1031C10.9295 16.9182 10.8256 16.6674 10.8256 16.4058C10.8256 16.1443 10.9295 15.8935 11.1144 15.7086L15.3398 11.4848H3.28125C3.02018 11.4848 2.7698 11.3811 2.58519 11.1965C2.40059 11.0119 2.29688 10.7615 2.29688 10.5004C2.29688 10.2393 2.40059 9.98897 2.58519 9.80436C2.7698 9.61975 3.02018 9.51604 3.28125 9.51604H15.3398L11.1161 5.28979C10.9311 5.10487 10.8272 4.85405 10.8272 4.59253C10.8272 4.331 10.9311 4.08019 11.1161 3.89526C11.301 3.71034 11.5518 3.60645 11.8133 3.60645C12.0748 3.60645 12.3257 3.71034 12.5106 3.89526L18.4168 9.80151C18.5086 9.89309 18.5814 10.0019 18.631 10.1217C18.6806 10.2415 18.7061 10.3699 18.706 10.4995C18.7058 10.6292 18.68 10.7575 18.6301 10.8772C18.5802 10.9969 18.5072 11.1055 18.4152 11.1969Z"
                 />
                </svg>
              </a>
        </div>
        <div class="offered-tenders-inner-sliders">
            <div class="swiper-container main-slider">
                <div class="swiper-wrapper">
     
     
                <?php foreach ($images as $index => $image): ?>

   
                  <div class="swiper-slide">
                    <picture>
                        <img src="<?= Html::encode($image->media->url)?>" alt="<?= Html::encode($image->media->title)?>" />
                    </picture>
                  </div>
                  <?php endforeach; ?>

                  
                  <!-- Add more slides -->
                </div>
                <!-- Navigation buttons -->
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
              </div>
              
              <div class="swiper-container thumbs-slider">
                <div class="swiper-wrapper">
  

                <?php foreach ($images as $index => $image): ?>
              
                      <div class="swiper-slide">
                        <picture>
                          <img src="<?= Html::encode($image->media->url)?>" alt="<?= Html::encode($image->media->title)?>" />
                        </picture>
                      </div>
                      <?php endforeach; ?>

                  <!-- Add more thumbnails -->
                </div>
              </div>
              
        </div>
    </div>
   </section>

   
   <?php if($lng=="en"): ?>

<?php
    $script = <<< JS
 const thumbsSwiper = new Swiper(".thumbs-slider", {
  loop: false, // Thumbnails should not loop
  slidesPerView: 7, // Number of thumbnails visible
  spaceBetween: 5, // Spacing between thumbnails
  watchSlidesProgress: true, // Highlight active thumb
  breakpoints: {
  300.8888: {
    slidesPerView: 4,
  },
  767.8888: {
    slidesPerView: 5,
  },
  991.8888: {
    slidesPerView: 4,
  },
  1400.8888: {
    slidesPerView: 7,
  },
  
},
});

const mainSwiper = new Swiper(".main-slider", {
  loop: true, // Enable looping
  spaceBetween: 10,
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
  thumbs: {
    swiper: thumbsSwiper, // Link to thumbs slider
  },
});

JS;
$this->registerJs($script);
?>

<?php else: ?>

<?php
    $script = <<< JS
    const thumbsSwiper = new Swiper(".thumbs-slider", {
  loop: false, // Thumbnails should not loop
  slidesPerView: 7, // Number of thumbnails visible
  spaceBetween: 5, // Spacing between thumbnails
  watchSlidesProgress: true, // Highlight active thumb
  breakpoints: {
  300.8888: {
    slidesPerView: 4,
  },
  767.8888: {
    slidesPerView: 5,
  },
  991.8888: {
    slidesPerView: 4,
  },
  1400.8888: {
    slidesPerView: 7,
  },
  
},
});

const mainSwiper = new Swiper(".main-slider", {
  loop: true, // Enable looping
  spaceBetween: 10,
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
  thumbs: {
    swiper: thumbsSwiper, // Link to thumbs slider
  },
});

JS;
$this->registerJs($script);
?>

<?php endif; ?>