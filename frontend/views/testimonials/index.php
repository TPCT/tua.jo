<?php

use frontend\widgets\HeaderImage;



$this->title = Yii::t('site', 'Testimonials');
$this->description = Yii::t('site', 'Testimonials_DESCRIPTION');

$this->registerCssFile("/theme/css/offered-tenders.css", ['depends' => [\frontend\assets\AppAsset::className()],]);

$lng = Yii::$app->language;

?>






<?= HeaderImage::widget(['is_inner'=> true , 'path'=>'/testimonials' ]) ?>



    <div id="items-section">
      <div id="items-container">
        <section>
        <div class="container effective-container my-5">

            <?php foreach($Testimonials as $Testimonial) : ?>
              <div class="effective-card">

              <?php if ($Testimonial->image): ?>

                  <picture class="effective-card-main-pic"><img src="<?=$Testimonial->image?>" alt="<?=$Testimonial->title?>"></picture>
                  <?php else: ?>
                  <iframe class="effective-card-main-video"  src="<?=$Testimonial->video_url?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>

                  <?php endif; ?>
                  <div>
                      <div class="effective-card-date">
                          <picture><img src="/theme/assets/Icons/CalendarDot.svg" alt=""></picture>
                          <h5> <?=  Yii::t('site', 'APPLICATION_DATE') ?> :<?=  $Testimonial->getPublishedAtFullDate($Testimonial->published_at)  ?></h5>
                      </div>
                      <div class="effective-card-content">
                          <h2> <?= $Testimonial->title ?> </h2>     
                      </div>
                  </div>
              </div>
            <?php endforeach; ?>

    



          </div>
        </section>

        
        <div class="pagination by-ajax"  data-section="#items-section" data-container="#items-container">
             <?= \frontend\widgets\Pager::widget(['pagination' => $pagination]); ?>
      </div>


      </div>
    </div>













