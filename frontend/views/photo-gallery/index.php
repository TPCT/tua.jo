<?php


use frontend\widgets\HeaderImage;
use common\components\custom_base_html\CustomBaseHtml;




$this->title = Yii::t('site', 'PHOTO_GALLERY');
$this->description = Yii::t('site', 'PHOTO_GALLERY_DESCRIPTION');
$this->registerCssFile("/theme/css/PhotoGallery.css", ['depends' => [\frontend\assets\AppAsset::className()],]);

$lng = Yii::$app->language;
?>



    <!-- End Navbar -->
    <!-- Start Header Section -->
    <?= HeaderImage::widget(['is_inner'=> true , 'path'=>'/photo-gallery' ]) ?>



    <!-- End Latest Added Section -->
    <!-- Start Latest News Section -->
    <div id="items-section">
      <div id="items-container">



    
    <!-- End Header Section -->
    <!-- Start Photo Gallery -->
    <section class="photo-gallery-section">
      <div class="container">
        <div class="row mt-5">

        <?php foreach($photoGellaries as $photoGellary) : ?>

          <div class="col-md-6 col-lg-3 mb-4">
            <div class="photo-card">
              <div class="photo-thumbs">
                <a data-fancybox="gallery<?= $photoGellary->id ?>" href="<?= $photoGellary->image ?>"
                  data-thumb="<?= $photoGellary->image ?>">
                  <img src="<?= $photoGellary->image ?>" alt="صورة 1" class="mw-100" />
                </a>

                <?php foreach($photoGellary->getAllFiles()->all() as $photo) : ?>

           
                <a class="" data-fancybox="gallery<?= $photoGellary->id ?>" href="<?= $photo->media->url ?>"
                  data-thumb="<?=$photo->media->url?>"></a>
                  <?php endforeach; ?>

              </div>
              <div class="photo-card-content">
                <div class="date d-flex align-items-center gap-2">
                  <picture>
                    <img src="/theme/assets/Icons/CalendarDot.svg" alt="" class="mw-100" />
                  </picture>
                  <h5 class="date-content"> <?= $photoGellary->getPublishedAtFullDate($photoGellary->published_at) ?> </h5>
                </div>
                <h4><?= $photoGellary->title ?></h4>
              </div>
            </div>
          </div>

          <?php endforeach; ?>


     








     
        </div>
      </div>
    </section>

    <!-- End Latest News Section -->
      <div class="pagination by-ajax"  data-section="#items-section" data-container="#items-container">
             <?= \frontend\widgets\Pager::widget(['pagination' => $pagination]); ?>
      </div>


      </div>
    </div>