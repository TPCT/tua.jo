<?php
use common\components\custom_base_html\CustomBaseHtml;

use frontend\widgets\HeaderImage;

use frontend\assets\SlickAsset;
SlickAsset::register($this);

$this->title = Yii::t('site', 'OUR_STORY');
$this->description = Yii::t('site', 'OUR_STORY_DESCRIPTION');


$this->registerCssFile("/theme/css/our-story.css", ['depends' => [\frontend\assets\AppAsset::className()],]);


$lng = Yii::$app->language;

?>


<?= HeaderImage::widget(['is_inner'=> true , 'path'=>'/our-story' ]) ?>


    <?php if($ourStoryFirstSectionWithBackgroundImage): ?>

    <section>
      <div class="container text-center mt-5">
        <h3 class="mb-0"> <?= $ourStoryFirstSectionWithBackgroundImage->title ?> </h3>
        <p><?= $ourStoryFirstSectionWithBackgroundImage->brief ?> </p>
      </div>
    </section>

    <?php $background =  $ourStoryFirstSectionWithBackgroundImage->image?>
      <?= CustomBaseHtml::style(".OurStory-section-image { background-image: url( " . ($background ) . "); }") ?>


    <?php endif; ?>

    <section class="history-sliders-section ">
      <div class="container history-sliders-container OurStory-section-image">
        <div class="position-relative history-slider-wrapper">
          <div class=" history-slider">
    
          <?php foreach ($ourStoryBlocks as $ourStoryBlock) : ?>

            <div class="history-slide">
              <picture>
                <?= \frontend\widgets\WebpImage::widget(["src" => $ourStoryBlock->image, "alt" => $ourStoryBlock->title, "loading" => "lazy", 'css' => ""]) ?>

              </picture>
              <div class="history-slide-content">
                <h2><?= $ourStoryBlock->title ?></h2>

                <p>
                  <?= $ourStoryBlock->brief ?>
                </p>
              </div>
            </div>
            <?php endforeach; ?>




          </div>
          <div class="history-slider-arrows container">
            <span class="history-prev slick-arrow">
              <i class="fa-solid fa-chevron-left "></i>
            </span>
            <span class="history-next slick-arrow">
              <i class="fa-solid fa-chevron-right "></i>
            </span>
          </div>
        </div>
        <div class="position-relative  timline-slider-wrapper">
          <div class="history-timline-subslider">



          <?php foreach ($ourStoryBlocks as $ourStoryBlock) : ?>

            <div class="history-timline-slide">
              <div class="timeline-dot">
                <div class="timeline-inner-dot"></div>
              </div>
              <h4>  <?= $ourStoryBlock->title ?> </h4>
              <span> <?= $ourStoryBlock->second_title ?> </span>
            </div>
            <?php endforeach; ?>

          </div>
          <div class="geyHistory-line"></div>
        </div>
      </div>
    </section>

    <?php if($lng=="en"): ?>

<?php
    $script = <<< JS

$(document).ready(function () {
  let timelineSlider = $(".history-timline-subslider"); // Timeline slider
  let historySlides = $(".history-timline-slide"); // Timeline slides (original)

  // Function to update active class
  function updateActiveSlide(currentIndex) {
    historySlides.removeClass("active"); // Remove active class from all slides

    let realSlides = timelineSlider.find(".slick-slide:not(.slick-cloned)"); // Get real slides

    let targetIndex = currentIndex - 1; // Target previous slide
    if (targetIndex < 0) targetIndex = realSlides.length - 1; // Loop back to the last slide

    realSlides.eq(targetIndex).addClass("active"); // Add active class to previous slide
  }

  // Initialize sliders
  let mainSlider = $(".history-slider").slick({
    dots: false,
    infinite: false,
    speed: 300,
    slidesToShow: 1,
    slidesToScroll: 1,
    prevArrow: $(".history-prev"),
    nextArrow: $(".history-next"),
    asNavFor: ".history-timline-subslider",
  });

  let timelineSlick = timelineSlider.slick({
    focusOnSelect: true,
    dots: false,
    infinite: false,
    speed: 300,
    slidesToShow: 10.01,
    slidesToScroll: 1,
    asNavFor: ".history-slider",
    arrows: false,
    responsive: [
      {
        breakpoint: 1400.88888,
        settings: {
          slidesToShow: 6.01,
          slidesToScroll: 1,
        },
      },
      {
        breakpoint: 991.88888,
        settings: {
          slidesToShow: 3.01,
          slidesToScroll: 1,
        },
      },
    ],
  });

  // When Slick changes slides, update the active class
  timelineSlider.on("afterChange", function (event, slick, currentSlide) {
    updateActiveSlide(currentSlide);
  });

  // Set the initial active class
  setTimeout(() => {
    updateActiveSlide(1);
  }, 100);
});

JS;
$this->registerJs($script);
?>

<?php else: ?>

<?php
    $script = <<< JS

$(document).ready(function () {
       let timelineSlider = $(".history-timline-subslider"); // Timeline slider
       let historySlides = $(".history-timline-slide"); // Timeline slides (original)
     
       // Function to update active class
       function updateActiveSlide(currentIndex) {
         historySlides.removeClass("active"); // Remove active class from all slides
     
         let realSlides = timelineSlider.find(".slick-slide:not(.slick-cloned)"); // Get real slides
     
         let targetIndex = currentIndex - 1; // Target previous slide
         if (targetIndex < 0) targetIndex = realSlides.length - 1; // Loop back to the last slide
     
         realSlides.eq(targetIndex).addClass("active"); // Add active class to previous slide
       }
     
       // Initialize sliders
       let mainSlider = $(".history-slider").slick({
         dots: false,
         infinite: false,
         speed: 300,
         slidesToShow: 1,
         slidesToScroll: 1,
         rtl:true,
         prevArrow: $(".history-prev"),
         nextArrow: $(".history-next"),
         asNavFor: ".history-timline-subslider",
       });
     
       let timelineSlick = timelineSlider.slick({
         focusOnSelect: true,
         dots: false,
         infinite: false,
         speed: 300,
         slidesToShow: 10.3,
         slidesToScroll: 1,
         asNavFor: ".history-slider",
         arrows: false,
         rtl:true,
         responsive: [
           {
             breakpoint: 1400.88888,
             settings: {
               slidesToShow: 6.3,
               slidesToScroll: 1,
             },
           },
           {
             breakpoint: 991.88888,
             settings: {
               slidesToShow: 3.3,
               slidesToScroll: 1,
             },
           },
         ],
       });
     
       // When Slick changes slides, update the active class
       timelineSlider.on("afterChange", function (event, slick, currentSlide) {
         updateActiveSlide(currentSlide);
       });
     
       // Set the initial active class
       setTimeout(() => {
         updateActiveSlide(1);
       }, 100);
     });
     

JS;
$this->registerJs($script);
?>

<?php endif; ?>