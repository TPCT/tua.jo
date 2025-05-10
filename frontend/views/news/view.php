<?php
$this->registerCssFile("/theme/css/LatestNews.css", ['depends' => [\frontend\assets\AppAsset::className()],]);
$this->registerCssFile("/theme/css/LatestNewsInner.css", ['depends' => [\frontend\assets\AppAsset::className()],]);
$this->registerCssFile("/theme/css/Blogs.css", ['depends' => [\frontend\assets\AppAsset::className()],]);


use yii\helpers\Url;
use frontend\widgets\HeaderImage;


$this->title =  $targetNew->title ;
$this->description = $targetNew->content;
$this->og_image =  $targetNew->image   ;
$this->type = "article";

$lng = Yii::$app->language;

?>
      <!-- End Navbar -->
      <!-- Start Header Section -->

      <?= HeaderImage::widget(['is_inner'=> true , 'path'=>'/news' , 'bread_crumb_slug'=>$targetNew->slug , 'bread_crumb_title'=>$this->title ]) ?>


      <!-- End Header Section -->
      <!-- Start Latest News Inner -->
      <section class="latest-news-inner-section my-5">
        <div class="container">
          <div class="latest-news-inner-container d-flex flex-column gap-3">
            <h3 class="text-center">
                <?= $targetNew->title ?>
            </h3>

            <?php
                $objectFit = $targetNew->object_fit?: 'contain';
                $css = <<<CSS
                    .targetNew-inner-image{
                    object-fit: $objectFit !important;
                    object-position: $targetNew->object_position !important;
                    }
                CSS;
                $this->registerCss($css);
            ?>


              <?= \frontend\widgets\WebpImage::widget(["src" => $targetNew->image, "alt" => $targetNew->title, "loading" => "lazy", 'css' => "targetNew-inner-image mw-100 latest-news-inner-main-img"]) ?>


            <div class="latest-news-inner-content">
              <div class="date d-flex align-items-center gap-2 mb-3">
                <picture>
                  <img
                    src="/theme/assets/Icons/CalendarDot.svg"
                    alt=""
                    class="mw-100"
                  />
                </picture>
                <h5 class="date-content"> <?= $targetNew->getPublishedAtFullDate($targetNew->published_at) ?>  </h5>
              </div>

              <?= $targetNew->content ?>

            </div>

            <?= frontend\widgets\share_button\ShareButton::widget() ?>


          </div>
        </div>
      </section>
      <!-- End Latest News Inner -->
      <!-- Start Latest Added Section -->
      <section class="latest-added-section py-5">
        <h3 class="text-center"> <?=  Yii::t('site', 'STAUED_INFORMED_OF_THE_LATEST_NEWS') ?> </h3>
        <div class="container">
          <div class="latest-added-container mt-5">

          <?php foreach($latestNews as $latestNew) : ?>

            <div class="latest-added-card mb-4">
              <div
                class="box-latest-news-added d-flex align-items-center flex-column justify-content-between h-100"
              >


                <?= \frontend\widgets\WebpImage::widget(["src" => $latestNew->image, "alt" => $latestNew->title, "loading" => "lazy", 'css' => "mw-100 "]) ?>

                <div
                  class="latest-news-added-content d-flex flex-column justify-content-between px-3 pb-4 mt-2 gap-2 h-100"
                >
                  <div class="date d-flex align-items-center gap-2">
                    <picture>
                      <img
                        src="/theme/assets/Icons/CalendarDot.svg"
                        alt=""
                        class="mw-100"
                      />
                    </picture>
                    <h5 class="date-content"> <?= $latestNew->getPublishedAtFullDate($latestNew->published_at) ?> </h5>
                  </div>
                  <div
                    class="latest-news-added-info d-flex flex-column justify-content-between h-100"
                  >
                    <h4 class="h-100">
                        <?= $latestNew->title ?>
                    </h4>
                    <div class="buttons">
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
        </div>
      </section>