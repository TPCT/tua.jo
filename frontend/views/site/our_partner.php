<?php

use frontend\widgets\HeaderImage;
use yii\helpers\Url;
use kartik\form\ActiveForm;
use common\helpers\Utility;

$this->title = Yii::t('site', 'OUR_PARTNER');
$this->description = Yii::t('site', 'OUR_PARTNER_DESCRIPTION');



$this->registerCssFile("/theme/css/our-partners.css", ['depends' => [\frontend\assets\AppAsset::className()],]);

$lng = Yii::$app->language;

?>


<?= HeaderImage::widget(['is_inner'=> true , 'path'=>'/our-partner' ]) ?>



    <section>

    <div class="container p-5">

    
    <div class="filter d-flex flex-column gap-3 align-items-start">
            <h3> <?= Yii::t('site', 'CHOOSE_THE_METHOD') ?> </h3>
            <?php
            $form = ActiveForm::begin([
                'action' => Url::to(['/news/index']),

                'id' => 'news-search',
                'method' => 'post',
                
                'formConfig' => [
                    'showHints' => false,
                ],
                'fieldConfig' => [
                    'options' => [
                        'tag' => false,
                    ],
                ],
                'options' => [
                    'autocomplete' => 'off',
                    'class'=>'official-announcements-wrapper ajax-scroll-filter module-search-post',
                    'data-section'=>'#items-section',
                    'data-contanier'=>'#items-container',
                    'data-model' => "our-partner",
                    'data-pjax' => true

                ],
                
            ])
        ?>

            <?= $form->field($searchModel, "ourPartnerTitle")->dropDownList($searchModel->getOurPartnerFrontList(),['class' => 'form-select input-submit',"prompt"=> Yii::t('site', 'SELECT_TITLE'), 'data-url-name' => "title" ])->label(false) ?>
            <?php \kartik\form\ActiveForm::end(); ?>
          </div>
          </div>
          <?php if($ourPartners): ?>
        <div class="container our-partner-main-container">



        <?php foreach ($ourPartners as $ourPartner): ?>

            <div>
            <?php if($ourPartner->url): ?>
                <a  <?= Utility::PrintAllUrl($ourPartner->url) ?>>   
                    <picture>
                        <img src="<?= \frontend\widgets\WebpImage::widget(["src" => $ourPartner->image, "alt" =>"" ,"loading" => "lazy",'css' => "", "just_image" => true]); ?>"  alt="<?= $ourPartner->title ?>" />
                    </picture>

                        <h4> <?= $ourPartner->title ?></h4>
                </a> 
                <?php else: ?>
                <picture>
                        <img src="<?= \frontend\widgets\WebpImage::widget(["src" => $ourPartner->image, "alt" =>"" ,"loading" => "lazy",'css' => "", "just_image" => true]); ?>"  alt="<?= $ourPartner->title ?>" />
                    </picture>
                    <h4> <?= $ourPartner->title ?> </h4>

                <?php endif; ?>

            </div>
            <?php endforeach; ?>


            
        </div>
        <?php endif; ?>

        <?php if($pagination->pageCount > 1): ?>

        <div class="d-flex ">
          <a href="" class="load-more-btn MoreNews"> <?= Yii::t('site', 'LOAD_MORE') ?> </a>
        </div>
        <?php endif; ?>
        <div class="d-flex ">
          <a href="" class="load-more-btn see-less" id="see-less"> <?= Yii::t('site', 'SEE_LESS') ?> </a>
        </div>

    </section>

    
<?php
$url = \yii\helpers\Url::to(['our-partner/next']);
$noMore = Yii::t('site', 'No More');

$script = <<< JS

$(document).ready(function () {

    const urlParts = window.location.pathname.split('/');
    const titleSlug = urlParts[urlParts.length - 1];


          
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
            formData.append('ourPartnerTitle',titleSlug);
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
                          $(".our-partner-main-container").append(response).show().fadeIn("slow");
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
                                  $(".our-partner-main-container").find('.extra-content').hide(); // Example: hide the extra content added dynamically
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