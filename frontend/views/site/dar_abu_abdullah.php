<?php

use frontend\widgets\HeaderImage;

$this->title = Yii::t('site', 'Dar_Abu_Abdullah');
$this->description = Yii::t('site', 'Dar_Abu_Abdullah_DESCRIPTION');


$this->registerCssFile("/theme/css/LatestNews.css", ['depends' => [\frontend\assets\AppAsset::className()],]);
$this->registerCssFile("/theme/css/LatestNewsInner.css", ['depends' => [\frontend\assets\AppAsset::className()],]);
$this->registerCssFile("/theme/css/ZakatStoriesInner.css", ['depends' => [\frontend\assets\AppAsset::className()],]);
$this->registerCssFile("/theme/css/DarAbuAbdullah.css", ['depends' => [\frontend\assets\AppAsset::className()],]);

$lng = Yii::$app->language;

?>


<?= HeaderImage::widget(['is_inner'=> true , 'path'=>'/dar-abu-abdullah' ]) ?>

      <!-- End Header Section -->
      <!-- Start Home 8 Section -->

      <section class="home-8th-section">
      <?php if($DarAbuAbdullahFirstSection): ?>
        <div class="container centerd-section-topic">
          <h2> <?= $DarAbuAbdullahFirstSection->title ?> </h2>
          <p>
          <?= $DarAbuAbdullahFirstSection->brief ?>
          </p>
        </div>
        <?php endif; ?>


        <?php if($DarAbuAbdullahBlocks): ?>

        <div class="container home-8th-section-container">

        <?php foreach ($DarAbuAbdullahBlocks as $DarAbuAbdullahBlock): ?>

          <div class="dar-abu-abdalllah-card">

            <?= \frontend\widgets\WebpImage::widget(["src" => $DarAbuAbdullahBlock->image, "alt" => $DarAbuAbdullahBlock->title, "loading" => "lazy", 'css' => ""]) ?>

            <div class="dar-abu-abdalllah-card-content">
              <h3>  <?= $DarAbuAbdullahBlock->title ?> </h3>
              <p>
              <?= $DarAbuAbdullahBlock->brief ?>
              </p>
            </div>
          </div>
        <?php endforeach; ?>

     
        </div>
        <?php endif; ?>

      </section>
      <!-- End Home 8 Section -->
      <!-- Start Latest News Inner -->
      <?php if($DarAbuAbdullahContentSection): ?>

      <section class="latest-news-inner-section my-5">
        <div class="container">
          <div
            class="latest-news-inner-container d-flex flex-column gap-3 mt-5"
          >
            <h3 class="text-center">
              <?= $DarAbuAbdullahContentSection->title ?>
            </h3>
            <picture>

              <img src="<?= \frontend\widgets\WebpImage::widget(["src" => $DarAbuAbdullahContentSection->image, "alt" =>"" ,"loading" => "lazy",'css' => "", "just_image" => true]); ?>" class="mw-100 latest-news-inner-container-main-img"  alt="<?= $DarAbuAbdullahContentSection->title ?>" />

            </picture>
            <div
              class="latest-news-inner-content d-flex flex-column align-items-start"
            >
              
                <?= $DarAbuAbdullahContentSection->content ?>

                <?php if ($DarAbuAbdullahContentSection->url_1): ?>
              <a href="#" class="type-4-btn mb-3 d-flex align-items-center">
                <span>  <?= $DarAbuAbdullahContentSection->button_text ?> </span>
                <i class="fa-solid fa-arrow-right"></i>
              </a>
              <?php endif ?>
            </div>

            <?= frontend\widgets\share_button\ShareButton::widget() ?>



          </div>
        </div>
      </section>
      <?php endif; ?>