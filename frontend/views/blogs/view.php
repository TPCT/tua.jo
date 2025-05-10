<?php
$this->registerCssFile("/theme/css/LatestNews.css", ['depends' => [\frontend\assets\AppAsset::className()],]);
$this->registerCssFile("/theme/css/LatestNewsInner.css", ['depends' => [\frontend\assets\AppAsset::className()],]);
$this->registerCssFile("/theme/css/Blogs.css", ['depends' => [\frontend\assets\AppAsset::className()],]);
use frontend\widgets\HeaderImage;


use yii\helpers\Url;

$this->title = $targetBlog->title;
$this->description = $targetBlog->content;
$this->og_image = $targetBlog->image;
$this->type = "article";

$lng = Yii::$app->language;

?>
      <!-- End Navbar -->
      <!-- Start Header Section -->
      <?= HeaderImage::widget(['is_inner'=> true , 'path'=>'/blogs' , 'bread_crumb_slug'=>$targetBlog->slug , 'bread_crumb_title'=>$this->title  ]) ?>

      <!-- End Header Section -->
      <!-- Start Latest News Inner -->
      <section class="latest-news-inner-section my-5">
        <div class="container">
          <div class="latest-news-inner-container d-flex flex-column gap-3">
            <h2 class="text-center">
              <?= $targetBlog->title ?>
            </h2>

            <?php
                $objectFit = $targetBlog->object_fit?: 'contain';
                $css = <<<CSS
                    .targetBlog-inner-image{
                    object-fit: $objectFit !important;
                    object-position: $targetBlog->object_position !important;
                    }
                CSS;
                $this->registerCss($css);
            ?>

              <?= \frontend\widgets\WebpImage::widget(["src" => $targetBlog->image, "alt" => $targetBlog->title, "loading" => "lazy", 'css' => "targetBlog-inner-image mw-100 latest-news-inner-main-img"]) ?>

            <div class="latest-news-inner-content">
              <div class="date d-flex align-items-center gap-2 mb-3">
                <picture>
                  <img
                    src="/theme/assets/Icons/CalendarDot.svg"
                    alt=""
                    class="mw-100"
                  />
                </picture>
                <h5 class="date-content"><?= $targetBlog->getPublishedAtFullDate($targetBlog->published_at) ?></h5>
              </div>
                <?=  $targetBlog->content ?>
            </div>
            <?= frontend\widgets\share_button\ShareButton::widget() ?>


          </div>
        </div>
      </section>
      <!-- End Latest News Inner -->
      <!-- Start Latest Added Section -->

      <section class="latest-added-section py-5">
        <h3 class="text-center">  <?=  Yii::t('site', 'STAUED_INFORMED_OF_THE_LATEST_BLOGS_STORIES') ?> </h3>
        <div class="container">
          <div class="latest-added-container mt-5">
          <?php foreach($latestBlogs as $latestBlog) : ?>

            <div class="latest-added-card mb-4">
              <div
                class="box-latest-news-added d-flex align-items-center flex-column justify-content-between h-100"
              >
 
                <?= \frontend\widgets\WebpImage::widget(["src" => $latestBlog->image, "alt" => $latestBlog->title, "loading" => "lazy", 'css' => "mw-10"]) ?>


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
                    <h5 class="date-content"><?= $latestBlog->getPublishedAtFullDate($latestBlog->published_at) ?></h5>
                  </div>
                  <div
                    class="latest-news-added-info d-flex flex-column justify-content-between h-100"
                  >
                    <h3 class="h-100">
                        <?= $latestBlog->title ?>
                    </h3>
                    <div class="buttons">
                      <a href="<?= Url::to(["/blogs/view", "slug" => $latestBlog->slug]) ?>" class="type-4-btn">
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