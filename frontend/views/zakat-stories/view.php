<?php
$this->registerCssFile("/theme/css/LatestNews.css", ['depends' => [\frontend\assets\AppAsset::className()],]);
$this->registerCssFile("/theme/css/Blogs.css", ['depends' => [\frontend\assets\AppAsset::className()],]);

$this->registerCssFile("/theme/css/LatestNewsInner.css", ['depends' => [\frontend\assets\AppAsset::className()],]);
$this->registerCssFile("/theme/css/ZakatStoriesInner.css", ['depends' => [\frontend\assets\AppAsset::className()],]);


use yii\helpers\Url;
use frontend\widgets\HeaderImage;

$this->title = $targetZakatStory->title;
$this->description = $targetZakatStory->content ;
$this->og_image = $targetZakatStory->image;
$this->type = "article";

$lng = Yii::$app->language;

?>
      <!-- End Navbar -->
      <!-- Start Header Section -->

      <?= HeaderImage::widget(['is_inner'=> true , 'path'=>'/zakat-stories', 'bread_crumb_slug'=>$targetZakatStory->slug , 'bread_crumb_title'=>$this->title ]) ?>



      <section class="latest-news-inner-section my-5">
        <div class="container">
          <div class="latest-news-inner-container d-flex flex-column gap-3">
            <h3 class="text-center"> <?= $targetZakatStory->title ?></h3>

            <?php
                $objectFit = $targetZakatStory->object_fit?: 'contain';
                $css = <<<CSS
                    .targetZakatStory-inner-image{
                    object-fit: $objectFit !important;
                    object-position: $targetZakatStory->object_position !important;
                    }
                CSS;
                $this->registerCss($css);
            ?>

            <?= \frontend\widgets\WebpImage::widget(["src" => $targetZakatStory->image, "alt" => $targetZakatStory->title, "loading" => "lazy", 'css' => "targetZakatStory-inner-image mw-100 ZakatStoriesInner-main-pic"]) ?>

            <div
              class="latest-news-inner-content d-flex flex-column align-items-start"
            >
              <div class="date d-flex align-items-center gap-2 mb-3">
                <picture>
                  <img
                    src="/theme/assets/Icons/CalendarDot.svg"
                    alt=""
                    class="mw-100"
                  />
                </picture>
                <h5 class="date-content"><?= $targetZakatStory->getPublishedAtFullDate($targetZakatStory->published_at) ?></h5>
              </div>

              <h3><?= $targetZakatStory->second_title ?></h3>

              <?= $targetZakatStory->content ?>

              <picture>
                <img src="/theme/assets/Icons/quote 1.svg" alt="">
              </picture>
              <h4>
              <?= $targetZakatStory->brief ?>
              </h4>
              <a href="#" class="type-4-btn my-4">
                <span> <?= Yii::t('site', 'GIVE_ZAKAT') ?>  </span>
              </a>
              <span class="disclaimer">
                <?= Yii::t('site', 'BASED_ONE_TRUE_STORY') ?>
              </span>
            </div>
            <div
              class="share-button-section align-items-center d-flex justify-content-start position-relative"
            >
            <?= frontend\widgets\share_button\ShareButton::widget() ?>

            </div>
          </div>
        </div>
      </section>
      <!-- End Latest News Inner -->
      <!-- Start Latest Added Section -->
      <section class="latest-added-section py-5">
        <h3 class="text-center"><?=  Yii::t('site', 'STAY_INFORMED_OF_THE_LATEST_ZAKAT_STORIES') ?></h3>
        <div class="container">
          <div class="latest-added-container mt-5">
     
    
          <?php foreach($latestZakatStories as $latestZakatStorieyItem) : ?>

            <div class="latest-added-card mb-4">
              <div
                class="box-latest-news-added d-flex align-items-center flex-column justify-content-between h-100"
              >

                <?= \frontend\widgets\WebpImage::widget(["src" => $latestZakatStorieyItem->image, "alt" => $latestZakatStorieyItem->title, "loading" => "lazy", 'css' => "mw-100"]) ?>

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
                    <h5 class="date-content"> <?= $latestZakatStorieyItem->getPublishedAtFullDate($latestZakatStorieyItem->published_at) ?></h5>
                  </div>
                  <div
                    class="latest-news-added-info d-flex flex-column justify-content-between h-100"
                  >
                    <h4 class="h-100">
                      <?= $latestZakatStorieyItem->title ?>
                    </h4>
                    <div class="buttons">
                      <a href="<?= Url::to(["/zakat-stories/view", "slug" => $latestZakatStorieyItem->slug]) ?>" class="type-4-btn">
                        <span>  <?= Yii::t('site', 'READ_MORE') ?> </span>
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