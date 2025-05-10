<?php

use frontend\widgets\HeaderImage;

$this->title = Yii::t('site', 'BLOGS');
$this->registerCssFile("/theme/css/LatestNews.css", ['depends' => [\frontend\assets\AppAsset::className()],]);
$this->registerCssFile("/theme/css/Blogs.css", ['depends' => [\frontend\assets\AppAsset::className()],]);
use yii\helpers\Url;
use kartik\form\ActiveForm;

$this->title =Yii::t('site', 'BLOGS');
$this->description =Yii::t('site', 'BLOGS_DESCRIPTION');

$lng = Yii::$app->language;
?>
<?php




?>


    
    <!-- End Navbar -->
    <!-- Start Header Section -->
    <?= HeaderImage::widget(['is_inner'=> true , 'path'=>'/blogs' ]) ?>


    <!-- End Header Section -->
    <!-- Start Latest Added Section -->
    <section class="latest-added-section py-5">
      <div class="container">
        
      <?php
            $form = ActiveForm::begin([
                'action' => Url::to(['/blogs/index']),
                'id' => 'blogs-search',
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
                    'data-model' => "blogs",
                    'data-pjax' => true

                ],
                
            ])
        ?>

        <div class="head-latest-news d-flex align-items-center justify-content-between">
          <h2> <?=  Yii::t('site', 'FILTERS_BY_YEAR') ?></h2>

          <?= $form->field($searchModel, "year")->dropDownList($searchModel->getYearsList(),['class' => 'form-select input-submit',"prompt"=> Yii::t('site', 'SELECT_YEAR'), 'data-url-name' => "year" ])->label(false) ?>
 
        </div>
          <?php \kartik\form\ActiveForm::end(); ?>

        <div class="latest-added-container mt-5">
        <?php foreach($latestBlogs as $latestBlog) : ?>


      
          <div class="latest-added-card mb-4">
            <div class="box-latest-news-added d-flex align-items-center flex-column justify-content-between h-100">
 
              <?= \frontend\widgets\WebpImage::widget(["src" => $latestBlog->image, "alt" => $latestBlog->title, "loading" => "lazy", 'css' => "mw-100 "]) ?>

              <div
                class="latest-news-added-content d-flex flex-column justify-content-between px-3 pb-4 mt-2 gap-2 h-100">
                <div class="date d-flex align-items-center gap-2">
                  <picture>
                    <img src="/theme/assets/Icons/CalendarDot.svg" alt="" class="mw-100" />
                  </picture>
                  <h5 class="date-content"><?= $latestBlog->getPublishedAtFullDate($latestBlog->published_at) ?></h5>
                </div>
                <div class="latest-news-added-info d-flex flex-column justify-content-between h-100">
                  <h3 class="h-100">
                    <?= $latestBlog->title ?>
                  </h3>
                  <div class="buttons">
                    <a href="<?= Url::to(["/blogs/view", "slug" => $latestBlog->slug]) ?>" class="type-4-btn">
                      <span> <?= Yii::t('site', 'READ_MORE') ?> </span>
                      <i class="fa-solid fa-arrow-right"></i>
                    </a>

                    <?= frontend\widgets\cards_share_box_button\CardsShareBoxButton::widget([
                                'url' =>   $latestBlog->slug
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
    <!-- Start Latest News Section -->
    <div id="items-section">
      <div id="items-container">
    <section class="latest-news-section my-5 pb-4">
      <div class="container">
        <div class="see-more-container py-5">
          <h2> <?= Yii::t('site', 'MORE_BLOGS') ?> </h2>
        </div>
        <div class="latest-news-container">

        <?php foreach($blogs as $blog) : ?>


        
        <?php
                $objectFit = $blog->object_fit?: 'contain';
                $css = <<<CSS
                    .blog-image-$blog->id{
                    object-fit: $objectFit !important;
                    object-position: $blog->object_position !important;
                    }
                CSS;
                $this->registerCss($css);
            ?>

          <div class="lastest-news-card mb-4">

            <div class="box-latest-news d-flex align-items-center justify-content-between h-100">

              <?= \frontend\widgets\WebpImage::widget(["src" => $blog->image, "alt" => $blog->title, "loading" => "lazy", 'css' => "mw-100 blog-image-$blog->id"]) ?>

              <div class="latest-news-content d-flex flex-column justify-content-between py-3 px-3 gap-2 h-100">
                <div class="date d-flex align-items-center gap-2">
                  <picture>
                    <img src="/theme/assets/Icons/CalendarDot.svg" alt="" class="mw-100" />
                  </picture>
                  <h5 class="date-content"><?= $blog->getPublishedAtFullDate($blog->published_at) ?></h5>
                </div>
                <div class="latest-news-info d-flex flex-column justify-content-between gap-3 h-100">
                  <h3 >
                   <?= $blog->title ?>
                  </h3>
                  <div class="buttons">
                    <a href="<?= Url::to(["/blogs/view", "slug" => $blog->slug]) ?>" class="type-4-btn">
                      <span> <?= Yii::t('site', 'READ_MORE') ?> </span>
                      <i class="fa-solid fa-arrow-right"></i>
                    </a>
                    <?= frontend\widgets\cards_share_box_button\CardsShareBoxButton::widget([
                                'url' =>   $blog->slug
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
    <!-- End Latest News Section -->
      <div class="pagination by-ajax"  data-section="#items-section" data-container="#items-container">
             <?= \frontend\widgets\Pager::widget(['pagination' => $pagination]); ?>
      </div>


      </div>
    </div>