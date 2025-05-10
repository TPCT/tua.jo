<?php

use frontend\widgets\HeaderImage;
use frontend\assets\SlickAsset;

$this->title = Yii::t("site", 'ANNUAL_REPORT');
$this->description = Yii::t("site", 'ANNUAL_REPORT_DESCRIPTION');


$this->registerCssFile("/theme/css/AnnualReports.css",[ 'depends' => [\frontend\assets\AppAsset::className()], ]);
SlickAsset::register($this);

$lng = Yii::$app->language;

?>




<?= HeaderImage::widget(['is_inner'=> true , 'path'=>'/annual-report' ]) ?>


    <section class="row g-4 container mx-auto">
      <div class="container mt-5">
        <div class="row g-4 home-books-slider-container pt-1 pt-md-5 py-5 justify-content-center">
          <div class="col-lg-8 col-12 px-lg-0">
            <div class="book-cover-slider" dir="ltr">
            <?php foreach ($firstThreeReports as $index => $firstThreeReport): ?>

              <div class="book-single-cover-slide">

                <?= \frontend\widgets\WebpImage::widget(["src" => $firstThreeReport->image, "alt" => $firstThreeReport->title, "loading" => "lazy", 'css' => ""]) ?>

              </div>
              <?php endforeach; ?>


    
            </div>
          </div>
        </div>
        <div class="row g-4 book-content-slider-container pt-1 py-5 justify-content-center">
          <div class="col-lg-4 col-6 px-lg-0 position-relative">
            <div class="book-content-slider" dir="ltr">
            <?php foreach ($firstThreeReports as $index => $firstThreeReport): ?>

              <div class="book-single-content-slide">
                <h4> <?= $firstThreeReport->title ?> </h4>
                <a class="downlad-btn" href="<?= $firstThreeReport->file; ?>" target="_blank">
                  <p> <?= Yii::t("site", 'DOWNLOAD') ?> </p>
                  <svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                      d="M18.75 11.625V17.625C18.75 17.9234 18.6315 18.2095 18.4205 18.4205C18.2095 18.6315 17.9234 18.75 17.625 18.75H1.125C0.826631 18.75 0.540483 18.6315 0.329505 18.4205C0.118526 18.2095 0 17.9234 0 17.625V11.625C0 11.3266 0.118526 11.0405 0.329505 10.8295C0.540483 10.6185 0.826631 10.5 1.125 10.5C1.42337 10.5 1.70952 10.6185 1.9205 10.8295C2.13147 11.0405 2.25 11.3266 2.25 11.625V16.5H16.5V11.625C16.5 11.3266 16.6185 11.0405 16.8295 10.8295C17.0405 10.6185 17.3266 10.5 17.625 10.5C17.9234 10.5 18.2095 10.6185 18.4205 10.8295C18.6315 11.0405 18.75 11.3266 18.75 11.625ZM8.57906 12.4209C8.68358 12.5258 8.80777 12.609 8.94452 12.6658C9.08126 12.7226 9.22787 12.7518 9.37594 12.7518C9.524 12.7518 9.67061 12.7226 9.80736 12.6658C9.9441 12.609 10.0683 12.5258 10.1728 12.4209L13.9228 8.67094C14.1342 8.45959 14.2529 8.17295 14.2529 7.87406C14.2529 7.57518 14.1342 7.28853 13.9228 7.07719C13.7115 6.86584 13.4248 6.74711 13.1259 6.74711C12.8271 6.74711 12.5404 6.86584 12.3291 7.07719L10.5 8.90625V1.125C10.5 0.826631 10.3815 0.540483 10.1705 0.329505C9.95952 0.118526 9.67337 0 9.375 0C9.07663 0 8.79048 0.118526 8.5795 0.329505C8.36853 0.540483 8.25 0.826631 8.25 1.125V8.90625L6.42094 7.07906C6.31629 6.97442 6.19206 6.8914 6.05533 6.83477C5.9186 6.77814 5.77206 6.74899 5.62406 6.74899C5.32518 6.74899 5.03853 6.86772 4.82719 7.07906C4.72254 7.18371 4.63953 7.30794 4.5829 7.44467C4.52626 7.5814 4.49711 7.72794 4.49711 7.87594C4.49711 8.17482 4.61584 8.46147 4.82719 8.67281L8.57906 12.4209Z" />
                  </svg>
                </a>
              </div>
              <?php endforeach; ?>

            </div>

            <div id="next" class="home-books-arrow">
              <p> <?= Yii::t("site", 'NEXT') ?> </p>
              <div class="type-8-btn">
                <i class="fa-solid fa-chevron-left"></i>
              </div>
            </div>
            <div id="prev" class="home-books-arrow">
              <div class="type-8-btn">
                <i class="fa-solid fa-chevron-right"></i>
              </div>
              <p><?= Yii::t("site", 'PREV') ?></p>
            </div>
          </div>
        </div>
      </div>
    </section>





    <section>
      <div class="AnnualReports-container container">


      <?php foreach ($remainingReports as $index => $remainingReport): ?>

        <div class="AnnualReports-card">

                <?= \frontend\widgets\WebpImage::widget(["src" => $remainingReport->image, "alt" => $remainingReport->title, "loading" => "lazy", 'css' => ""]) ?>


          <div>
            <h4> <?= $remainingReport->title ?> </h4>
            <a class="downlad-btn"  href="<?= $remainingReport->file; ?>" target="_blank">
              <p><?= Yii::t("site", 'DOWNLOAD') ?></p>
              <svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                  d="M18.75 11.625V17.625C18.75 17.9234 18.6315 18.2095 18.4205 18.4205C18.2095 18.6315 17.9234 18.75 17.625 18.75H1.125C0.826631 18.75 0.540483 18.6315 0.329505 18.4205C0.118526 18.2095 0 17.9234 0 17.625V11.625C0 11.3266 0.118526 11.0405 0.329505 10.8295C0.540483 10.6185 0.826631 10.5 1.125 10.5C1.42337 10.5 1.70952 10.6185 1.9205 10.8295C2.13147 11.0405 2.25 11.3266 2.25 11.625V16.5H16.5V11.625C16.5 11.3266 16.6185 11.0405 16.8295 10.8295C17.0405 10.6185 17.3266 10.5 17.625 10.5C17.9234 10.5 18.2095 10.6185 18.4205 10.8295C18.6315 11.0405 18.75 11.3266 18.75 11.625ZM8.57906 12.4209C8.68358 12.5258 8.80777 12.609 8.94452 12.6658C9.08126 12.7226 9.22787 12.7518 9.37594 12.7518C9.524 12.7518 9.67061 12.7226 9.80736 12.6658C9.9441 12.609 10.0683 12.5258 10.1728 12.4209L13.9228 8.67094C14.1342 8.45959 14.2529 8.17295 14.2529 7.87406C14.2529 7.57518 14.1342 7.28853 13.9228 7.07719C13.7115 6.86584 13.4248 6.74711 13.1259 6.74711C12.8271 6.74711 12.5404 6.86584 12.3291 7.07719L10.5 8.90625V1.125C10.5 0.826631 10.3815 0.540483 10.1705 0.329505C9.95952 0.118526 9.67337 0 9.375 0C9.07663 0 8.79048 0.118526 8.5795 0.329505C8.36853 0.540483 8.25 0.826631 8.25 1.125V8.90625L6.42094 7.07906C6.31629 6.97442 6.19206 6.8914 6.05533 6.83477C5.9186 6.77814 5.77206 6.74899 5.62406 6.74899C5.32518 6.74899 5.03853 6.86772 4.82719 7.07906C4.72254 7.18371 4.63953 7.30794 4.5829 7.44467C4.52626 7.5814 4.49711 7.72794 4.49711 7.87594C4.49711 8.17482 4.61584 8.46147 4.82719 8.67281L8.57906 12.4209Z" />
              </svg>
            </a>
          </div>
        </div>
        <?php endforeach; ?>

      </div>
    </section>


<?php if($lng=="en"): ?>
<?php
    $script = <<< JS
    $(document).ready(function () {
      const carousel = $(".book-cover-slider");
      const carousel2 = $(".book-content-slider");
      const minSlides = 6;

      // Function to clone slides if needed
      function cloneSlidesIfNeeded(carousel, minSlides) {
        let slideCount = carousel.children().length;

        if (slideCount < minSlides) {
          const slides = carousel.children();
          const neededSlides = minSlides - slideCount;
          const fragment = $(document.createDocumentFragment()); // Create a document fragment

          // Append the necessary number of slides to the document fragment
          for (let i = 0; i < neededSlides; i++) {
            fragment.append(slides.eq(i % slideCount).clone());
          }

          // Append the fragment to the carousel in a single DOM operation
          carousel.append(fragment);
        }
      }

      // Clone slides for both carousels
      cloneSlidesIfNeeded(carousel, minSlides);
      cloneSlidesIfNeeded(carousel2, minSlides);

      // Initialize slick for book cover slider
      carousel.slick({
        centerPadding: "0px",
        slidesToShow: 3,
        infinite: true,
        nav: false,
        arrows: false,
        asNavFor: ".book-content-slider",
        initialSlide: 2,
        responsive: [
          {
            breakpoint: 767.8888888,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1,
              infinite: true,
            },
          },
        ],
      });

      // Initialize slick for book content slider
      carousel2.slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        infinite: true,
        swipe: true,
        prevArrow: $("#prev"),
        nextArrow: $("#next"),
        asNavFor: ".book-cover-slider",
        initialSlide: 2,
      });
    });
JS;
$this->registerJs($script);
?>

<?php else: ?>

<?php
    $script = <<< JS
    $(document).ready(function () {
      const carousel = $(".book-cover-slider");
      const carousel2 = $(".book-content-slider");
      const minSlides = 6;

      // Function to clone slides if needed
      function cloneSlidesIfNeeded(carousel, minSlides) {
        let slideCount =carousel.children().length;

        if (slideCount < minSlides) {
          const slides = carousel.children();
          const neededSlides = minSlides - slideCount;
          const fragment = $(document.createDocumentFragment()); // Create a document fragment

          // Append the necessary number of slides to the document fragment
          for (let i = 0; i < neededSlides; i++) {
            fragment.append(slides.eq(i % slideCount).clone());
          }

          // Append the fragment to the carousel in a single DOM operation
          carousel.append(fragment);
        }
      }

      // Clone slides for both carousels
      cloneSlidesIfNeeded(carousel, minSlides);
      cloneSlidesIfNeeded(carousel2, minSlides);

      // Initialize slick for book cover slider
      carousel.slick({
        centerPadding: "0px",
        slidesToShow: 3,
        infinite: true,
        nav: false,
        arrows: false,
        asNavFor: ".book-content-slider",
        initialSlide: 2,
        responsive: [
          {
            breakpoint: 767.8888888,
            settings: {
              slidesToShow: 1,
              slidesToScroll: 1,
              infinite: true,
            },
          },
        ],
      });

      // Initialize slick for book content slider
      carousel2.slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        infinite: true,
        swipe: true,
        prevArrow: $("#prev"),
        nextArrow: $("#next"),
        asNavFor: ".book-cover-slider",
        initialSlide: 2,
      });
    });

JS;
$this->registerJs($script);
?>

<?php endif; ?>