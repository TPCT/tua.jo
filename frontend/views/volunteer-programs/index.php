<?php

use yii\helpers\Url;
use kartik\form\ActiveForm;
use frontend\widgets\HeaderImage;


$this->title = Yii::t('site', 'VOLUNTEER_PROGRAMS');
$this->description = Yii::t('site', 'VOLUNTEER_PROGRAMS_DESCRIPTION');


$this->registerCssFile("/theme/css/LatestNews.css", ['depends' => [\frontend\assets\AppAsset::className()],]);
$this->registerCssFile("/theme/css/VolunteeringPrograms.css", ['depends' => [\frontend\assets\AppAsset::className()],]);
$this->registerCssFile("/theme/css/Blogs.css", ['depends' => [\frontend\assets\AppAsset::className()],]);


$lng = Yii::$app->language;
?>




<?= HeaderImage::widget(['is_inner'=> true , 'path'=>'/volunteer-programs' ]) ?>

      <!-- End Header Section -->
      <!-- Start Latest Added Section -->
      <section class="latest-added-section volunteering-programs pt-5">
        <div class="container">
          <div class="latest-added-container volunteer-program-main-container mt-5">

          <?php foreach($volunteerPrograms as $volunteerProgram) : ?>

          
          <?php
                $objectFit = $volunteerProgram->object_fit?: 'contain';
                $css = <<<CSS
                    .volunteerProgram-image-$volunteerProgram->id{
                    object-fit: $objectFit !important;
                    object-position: $volunteerProgram->object_position !important;
                    }
                CSS;
                $this->registerCss($css);
            ?>

            <div class="latest-added-card mb-4">
              <div
                class="box-latest-news-added d-flex align-items-center flex-column justify-content-between h-100"
              >

                <?= \frontend\widgets\WebpImage::widget(["src" => $volunteerProgram->image, "alt" => $volunteerProgram->title, "loading" => "lazy", 'css' => "volunteerProgram-image-$volunteerProgram->id  mw-100"]) ?>


                <div
                  class="latest-news-added-content d-flex flex-column justify-content-between px-3 pb-4 mt-2 gap-2 h-100"
                >
                  <h4> <?= $volunteerProgram->title ?></h4>
                  <div
                    class="latest-news-added-info d-flex flex-column justify-content-between h-100"
                  >
                    <p class="h-100 volunteering-programs-brief">
                    <?= $volunteerProgram->brief ?>
                    </p>
                    <div class="buttons">
                      <a href="<?= Url::to(["/volunteer-programs/view", "slug" => $volunteerProgram->slug]) ?>" class="type-4-btn">
                        <span>  <?= Yii::t('site', 'APPLY_NOW') ?>  </span>
                        <i class="fa-solid fa-arrow-right"></i>
                      </a>
                      <?= frontend\widgets\cards_share_box_button\CardsShareBoxButton::widget([
                                'url' =>   $volunteerProgram->slug
                            ]); ?>

                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php endforeach; ?>

          </div>
        </div>
      </section>
      <!-- End Latest Added Section -->
      <?php if($pagination->pageCount > 1): ?>

      <div class="see-more-container pb-4">
        <a href="#" class="MoreNews"> <?= Yii::t('site', 'LOAD_MORE') ?>  </a>
      </div>
      <?php endif; ?>

      <div class="see-more-container pb-4">
          <a href="" class="load-more-btn see-less" id="see-less"> <?= Yii::t('site', 'SEE_LESS') ?> </a>
        </div>




    
      <?php
$url = \yii\helpers\Url::to(['volunteer-programs/next']);
$noMore = Yii::t('site', 'No More');

$script = <<< JS

$(document).ready(function () {
          
          
          var page = 2;//Number($('#row').val());
          var allcount = {$pagination->pageCount};//Number($('#all').val());
            
            
          $('.see-less').hide()
      // Load more data
      $('.MoreNews').click(function (event) {
  
          event.preventDefault();
 
          console.log(page, allcount);
          if (page <= allcount) {
            var csrfToken = $('meta[name="csrf-token"]').attr('content'); // Get CSRF token from meta tag

            var formData = new FormData();
            formData.append('_csrf', csrfToken); // Append CSRF token
            formData.append('page', page); // Append current page number
  
              $.ajax({
                  url: '$url' + '?page=' + page,
                  type: 'post',
                  data: formData,
                  async: false, // to make js wait unitl ajax finish
                  processData: false,
                  contentType: false,
                  beforeSend: function () {
                      // $(".MoreNews").text("Loading...");
                  },
                  success: function (response) {

  
                      // Setting little delay while displaying new content
                          // appending posts after last post with class="post"
                          $(".volunteer-program-main-container").append(response).show().fadeIn("slow");
                          page++;

                          if (page > allcount) {
                              $('.MoreNews').hide();
                              $('.see-less').show();
                          }
                  
                                    
                  },
               
                  
              });
          } 
 
               
            
      
  
      });
      $('.see-less').click(function (event) {
                                  event.preventDefault();

                                  // Hide the additional content (you can customize this logic based on your structure)
                                  $(".volunteer-program-main-container").find('.extra-content').hide(); // Example: hide the extra content added dynamically
        page = 2;
                                  // Show the "See More" button again
                                  $('.MoreNews').show();

                                  // Hide the "See Less" button
                                  $('.see-less').hide();
                              });

        
      });
JS;
$this->registerJs($script);
?>


    
