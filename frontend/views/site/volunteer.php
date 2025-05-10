<?php

use frontend\widgets\HeaderImage;
use common\components\custom_base_html\CustomBaseHtml;
use borales\extensions\phoneInput\PhoneInput;
use common\helpers\Utility;

use yii\helpers\Url;

$this->title = Yii::t('site', 'VOLUNTEER');
$this->description = Yii::t('site', 'VOLUNTEER_DESCRIPTION');

$this->registerCssFile("/theme/css/LatestNews.css", ['depends' => [\frontend\assets\AppAsset::className()],]);
$this->registerCssFile("/theme/css/Volunteer.css", ['depends' => [\frontend\assets\AppAsset::className()],]);
$this->registerCssFile("/theme/css/Blogs.css", ['depends' => [\frontend\assets\AppAsset::className()],]);

$lng = Yii::$app->language;

?>


<?= HeaderImage::widget(['is_inner'=> true , 'path'=>'/volunteer' ]) ?>




      <!-- End Navbar -->
      <!-- Start Header Section -->

      <!-- End Header Section -->
      <!-- Start About Volunteering -->
      <?php if($AboutVolunteerFirstSection): ?>
      <section class="about-volunteering my-5">
        <div class="container">
          <div class="row">
            <div class="col-lg-6 mb-4">
              <div class="about-volunteering-head">
                <h3> <?= $AboutVolunteerFirstSection->title ?> </h3>
                <p><?= $AboutVolunteerFirstSection->second_title ?></p>
              </div>
              <div class="about-volunteering-content">
              <?= $AboutVolunteerFirstSection->content ?>
   
              </div>
            </div>
            <div
              class="col-lg-6 mb-4 d-flex align-items-center justify-content-center"
            >
              <picture>
                <img
                  src=" <?= \frontend\widgets\WebpImage::widget(["src" => $AboutVolunteerFirstSection->image, "alt" =>"" ,"loading" => "lazy",'css' => "", "just_image" => true]); ?>"
                  alt="<?= $AboutVolunteerFirstSection->title ?>"
                  class="mw-100 w-100"
                />
              </picture>
            </div>
          </div>
        </div>
      </section>
      <?php endif; ?>


      <!-- End  About Volunteering -->
      <!-- Start Latest Added Section -->
      <section class="latest-added-section volunteer pt-5">
        <div class="container">
          <h3 class="text-center"> <?= Yii::t('site', 'VOLUNTEER_PROGRAMS') ?> </h3>
          <div class="latest-added-container mt-4">


          <?php foreach($volunteers as $volunteer) : ?>
            <div class="latest-added-card mb-4">
              <div
                class="box-latest-news-added d-flex align-items-center flex-column justify-content-between h-100"
              >
                <picture>
                  <img
                    src="<?= \frontend\widgets\WebpImage::widget(["src" => $volunteer->image, "alt" =>"" ,"loading" => "lazy",'css' => "", "just_image" => true]); ?>"
                    class="mw-100"
                    alt="<?= $volunteer->title ?>"
                  />
                </picture>
                <div
                  class="latest-news-added-content d-flex flex-column justify-content-between px-3 pb-4 mt-2 gap-2 h-100"
                >
                  <h4> <?= $volunteer->title ?> </h4>
                  <div
                    class="latest-news-added-info d-flex flex-column justify-content-between h-100"
                  >
                    <p class="h-100 volunteering-programs-brief">
                    <?= $volunteer->brief ?>
                    </p>
                    <div class="buttons">
                      <a href="<?= Url::to(["/volunteer-programs/view", "slug" => $volunteer->slug]) ?>" class="type-4-btn">
                        <span> <?= Yii::t('site', 'APPLY_NOW') ?> </span>
                        <i class="fa-solid fa-arrow-right"></i>
                      </a>


                      <div
                      class="share-button-section1   align-items-center d-flex justify-content-start position-relative">
                      <div class="share-btn1" id="share">
                        <a class="secondary-share-btn">
                          <svg width="18" height="21" viewBox="0 0 18 21" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                              d="M17.2712 17.1491C17.2713 17.6417 17.1635 18.1283 16.9554 18.5749C16.7474 19.0214 16.4441 19.417 16.067 19.7338C15.6898 20.0506 15.2478 20.2811 14.7721 20.4089C14.2963 20.5367 13.7984 20.5589 13.3132 20.4738C12.828 20.3887 12.3673 20.1984 11.9635 19.9163C11.5596 19.6342 11.2224 19.2672 10.9756 18.8409C10.7287 18.4146 10.5782 17.9395 10.5345 17.4488C10.4908 16.9581 10.5551 16.4638 10.7228 16.0007L5.754 12.8085C5.27945 13.274 4.678 13.5889 4.02511 13.7139C3.37222 13.8389 2.69697 13.7683 2.08406 13.5109C1.47115 13.2536 0.947884 12.821 0.579906 12.2674C0.211928 11.7138 0.015625 11.0638 0.015625 10.3991C0.015625 9.73435 0.211928 9.08441 0.579906 8.53081C0.947884 7.97721 1.47115 7.5446 2.08406 7.28726C2.69697 7.02992 3.37222 6.9593 4.02511 7.08427C4.678 7.20924 5.27945 7.52423 5.754 7.98972L10.7228 4.80222C10.4382 4.02039 10.4517 3.16113 10.7607 2.38864C11.0697 1.61614 11.6525 0.98458 12.3977 0.614623C13.1429 0.244665 13.9983 0.162256 14.8005 0.383141C15.6026 0.604026 16.2952 1.11272 16.746 1.81202C17.1968 2.51131 17.3741 3.35218 17.2441 4.17396C17.114 4.99573 16.6858 5.74078 16.0411 6.26674C15.3965 6.7927 14.5806 7.06271 13.7495 7.02515C12.9183 6.98759 12.1302 6.64512 11.5356 6.06316L6.56681 9.25535C6.83535 9.99742 6.83535 10.8101 6.56681 11.5522L11.5356 14.7444C12.01 14.2801 12.6107 13.966 13.2627 13.8415C13.9147 13.7169 14.589 13.7873 15.2011 14.044C15.8133 14.3006 16.3362 14.7321 16.7044 15.2844C17.0726 15.8367 17.2697 16.4853 17.2712 17.1491Z"
                              fill="#FAFAFA" />
                          </svg>
                        </a>
                      </div>
                      <div class="share-overlay1 align-items-center gap-2" id="share-overlay1">
                        <div id="close" class="secondary-share-btn">
                          <i class="fa-solid fa-xmark"></i>
                        </div>
                        <div class="share-container">
                          <a href="#" id="copy-link-box" data-slug="<?= $volunteer->slug ?>" ><i class="fa-regular fa-copy"></i></a>
                          <a href="#" id="twitter-box" data-slug="<?= $volunteer->slug ?>" ><i class="fa-brands fa-x-twitter"></i></a>
                          <a href="#" id="whatsapp-box" data-slug="<?= $volunteer->slug ?>" ><i class="fa-brands fa-whatsapp"></i></a>
                          <a href="#" id="facebook-box" data-slug="<?= $volunteer->slug ?>" ><i class="fa-brands fa-facebook"></i></a>
                        </div>
                      </div>
                    </div>


                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php endforeach; ?>

          </div>
          <a href="<?= Url::to(['/volunteer-programs/index']); ?>" class="type-4-btn m-auto">
            <span>
              <?= Yii::t('site', 'VIEW__ALL') ?>
            </span> </a>
        </div>
      </section>
      <!-- End Latest Added Section -->
      <!-- Start Volunteering Conditions -->

      <?php if($AboutVolunteerThirdSection): ?>




      <?php $background =  $AboutVolunteerThirdSection->image?>
      <?= CustomBaseHtml::style(".OurHistory-section-image { background: url( " . ($background ) . ") !important ; }") ?>



      <section class="OurHistory-section-image volunteering-conditions-section  my-5">
        <div
          class="container d-flex align-items-center justify-content-center flex-column text-center gap-2"
        >
          <div class="volunteering-conditions-content">
            <h3> <?= $AboutVolunteerThirdSection->title ?> </h3>
            <p>
            <?= $AboutVolunteerThirdSection->brief ?> 
            </p>
          </div>
          <div class="buttons d-flex align-items-center gap-3">
          <?php if($AboutVolunteerThirdSection->url_1): ?>

            <a href="<?= $AboutVolunteerThirdSection->button_image_1; ?>" target="_blank" class="download-btn">
              <svg
                width="20"
                height="20"
                viewBox="0 0 20 20"
                fill="none"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  d="M19.375 12.5V18.5C19.375 18.7984 19.2565 19.0845 19.0455 19.2955C18.8345 19.5065 18.5484 19.625 18.25 19.625H1.75C1.45163 19.625 1.16548 19.5065 0.954505 19.2955C0.743526 19.0845 0.625 18.7984 0.625 18.5V12.5C0.625 12.2016 0.743526 11.9155 0.954505 11.7045C1.16548 11.4935 1.45163 11.375 1.75 11.375C2.04837 11.375 2.33452 11.4935 2.5455 11.7045C2.75647 11.9155 2.875 12.2016 2.875 12.5V17.375H17.125V12.5C17.125 12.2016 17.2435 11.9155 17.4545 11.7045C17.6655 11.4935 17.9516 11.375 18.25 11.375C18.5484 11.375 18.8345 11.4935 19.0455 11.7045C19.2565 11.9155 19.375 12.2016 19.375 12.5ZM9.20406 13.2959C9.30858 13.4008 9.43277 13.484 9.56952 13.5408C9.70626 13.5976 9.85287 13.6268 10.0009 13.6268C10.149 13.6268 10.2956 13.5976 10.4324 13.5408C10.5691 13.484 10.6933 13.4008 10.7978 13.2959L14.5478 9.54594C14.7592 9.33459 14.8779 9.04795 14.8779 8.74906C14.8779 8.45018 14.7592 8.16353 14.5478 7.95219C14.3365 7.74084 14.0498 7.62211 13.7509 7.62211C13.4521 7.62211 13.1654 7.74084 12.9541 7.95219L11.125 9.78125V2C11.125 1.70163 11.0065 1.41548 10.7955 1.2045C10.5845 0.993526 10.2984 0.875 10 0.875C9.70163 0.875 9.41548 0.993526 9.2045 1.2045C8.99353 1.41548 8.875 1.70163 8.875 2V9.78125L7.04594 7.95406C6.94129 7.84942 6.81706 7.7664 6.68033 7.70977C6.5436 7.65314 6.39706 7.62399 6.24906 7.62399C5.95018 7.62399 5.66353 7.74272 5.45219 7.95406C5.34754 8.05871 5.26453 8.18294 5.2079 8.31967C5.15126 8.4564 5.12211 8.60294 5.12211 8.75094C5.12211 9.04982 5.24084 9.33647 5.45219 9.54781L9.20406 13.2959Z"
                  fill="#041E42"
                />
              </svg>
              <span> <?=  $AboutVolunteerThirdSection->button_text ?> </span>
            </a>
            <?php endif; ?>

            <?php if($AboutVolunteerThirdSection->url_2 ): ?>

            <a   <?= Utility::PrintAllUrl($AboutVolunteerThirdSection->url_2) ?>  class="apply-btn">
              <span> <?=  $AboutVolunteerThirdSection->button_2_text ?>  </span>
              <i class="fa-solid fa-arrow-right"></i>
            </a>
            <?php endif; ?>

          </div>
        </div>
      </section>
      <?php endif; ?>

      <?php
$this->registerJsVar('lng', $lng );
    $script = <<< JS
$(document).ready(function () {
  function buildShareUrl(slug) {
    let url = window.location.href;
    
    // Remove /volunteer if it exists
    url = url.replace(/\/volunteer\/?$/, '');

    return url + '/volunteer-programs/' + slug;
  }

  $(document).on("click", "#whatsapp-box", function (event) {
    event.preventDefault();
    const slug = $(this).attr('data-slug');
    const totalUrl = buildShareUrl(slug);
    const text = "Check this out!";
    window.open('https://wa.me/?text=' + encodeURIComponent(text) + '%20' + encodeURIComponent(totalUrl), '_blank');
  });

  $(document).on("click", "#twitter-box", function (event) {
    event.preventDefault();
    const slug = $(this).attr('data-slug');
    const totalUrl = buildShareUrl(slug);
    const text = "Check this out!";
    window.open('https://twitter.com/intent/tweet?text=' + encodeURIComponent(text) + '&url=' + encodeURIComponent(totalUrl), '_blank');
  });

  $(document).on("click", "#facebook-box", function (event) {
    event.preventDefault();
    const slug = $(this).attr('data-slug');
    const totalUrl = buildShareUrl(slug);
    window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(totalUrl), '_blank');
  });

  $(document).on("click", "#copy-link-box", function (event) {
    event.preventDefault();
    const slug = $(this).attr('data-slug');
    const totalUrl = buildShareUrl(slug);
    navigator.clipboard.writeText(totalUrl).then(() => {
      alert('Link copied to clipboard!');
    });
  });
});
JS;
$this->registerJs($script);
?>
