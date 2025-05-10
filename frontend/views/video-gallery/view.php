<?php


use frontend\assets\PhotoGalleryAsset;
use frontend\assets\VideoGalleryAsset;
use frontend\widgets\HeaderImage;
use common\helpers\Utility;


$this->registerCssFile("/theme/css/VideoGallery.css", ['depends' => [\frontend\assets\AppAsset::className()],]);
$this->registerCssFile("/theme/css/Blogs.css", ['depends' => [\frontend\assets\AppAsset::className()],]);


$this->title =  $targetCategory->title ;
$this->description = $targetCategory->content ;
$this->og_image =  $targetCategory->image   ;
$this->type = "article";

VideoGalleryAsset::register($this);
$lng = Yii::$app->language;
?>


<?= HeaderImage::widget(['is_inner'=> true , 'is_clickable'=>false , 'path'=>'/video-gallery' , 'model'=>$targetCategory ]) ?>



    <!-- End Header Section -->
    <!-- Start Video Gallery -->
    <div id="items-section">
      <div id="items-container">
    <section class="video-gallery-section">
      <div class="container">
        <ul class="videos-links">
        <?php foreach($categories as $category) : ?>

          <li class="<?= ($targetCategory->slug == $category->slug) ? 'active' : '' ?>">
            <a  href="/<?= $lng ?>/video-gallery/<?= $category->slug ?>">
              <h5> <?= $category->title ?> </h5>
            </a>
          </li>
          <?php endforeach; ?>


        </ul>
        <div class="row mt-5">



        <?php foreach($videos as $key => $video) : ?>

          <div class="col-md-6 col-lg-3 mb-4">
            <div class="video-card">

              <?= \frontend\widgets\WebpImage::widget(["src" => $video->cover_image, "alt" => $video->title, "loading" => "lazy", 'css' => "mw-100 w-100"]) ?>

              <div class="video-card-content">
                <h4>
                  <?= $video->title ?>
                </h4>
                <div class="d-flex justify-start gap-2 buttons">
                  <a href="<?= $video->video_url ?>" class="video-btn" data-fancybox="video">
                    <i class="fa-solid fa-play"></i>
                  </a>
                  <?= frontend\widgets\cards_share_button\CardsShareButton::widget() ?>

                </div>
              </div>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </section>
    <!-- End Video Gallery -->
    <div class="pagination by-ajax"  data-section="#items-section" data-container="#items-container">
             <?= \frontend\widgets\Pager::widget(['pagination' => $pagination]); ?>
      </div>


      </div>
    </div>




<?php

$script = <<<JS

$('[data-fancybox="video"]').fancybox({
      thumbs: false
    });


JS;

$this->registerJs($script);
?>