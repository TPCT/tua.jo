<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */

/* @var $exception Exception */

use yii\helpers\Html;
use frontend\widgets\HeaderImage;
use yii\helpers\Url;
use backend\modules\news\models\News;
use backend\modules\blogs\models\Blogs;
use backend\modules\testimonials\models\Testimonials;
use backend\modules\zakat_stories\models\ZakatStories;


$this->title = Yii::t('site', 'ERROR_PAGE_TITLE');
$this->description = Yii::t('site', 'ERROR_PAGE_DESCRIPTION');


$lng = Yii::$app->language;

?>


<?php $this->beginBlock('top-title'); ?>
<h1><?= $this->title ?></h1>
<?php $this->endBlock(); ?>


<section id="MainContant">
    <div class="PageContant">
    <div class="error py-5">
            <div class="container">
                <div class="searh-error d-flex align-items-center flex-column justify-content-center ">
                    <h2>
                      <?= Yii::t('site','PAGE_NOT_FOUND_TITLE') ?>  
                    </h2>
              
                    <form class="form-inline d-flex align-items-center my-2 my-lg-0">
                        <input class="form-control mr-sm-2" type="search" placeholder="<?= Yii::t('site','SEARCH')  ?>" aria-label="Search">
                        <button class="btn  my-2 my-sm-0" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </form>
                    <div class="search-content d-flex align-items-center gap-4 flex-wrap pt-3">
                        <a href="<?= Url::to($lng . '/') ?>" class="type-3-btn">
                           <span>
                           <?= Yii::t('site','HOME_PAGE') ?> 
                           </span>
                        </a>
                        <?php if(News::find()->active()->count() != 0 ) : ?>
                          <a href="<?= Url::to($lng . '/news') ?>" class="type-3-btn">
                            <span>
                            <?=  Yii::t('site','NEWS_PAGE') ?> 
                            </span>
                          </a>
                        <?php endif ; ?>

                        <?php if(Blogs::find()->active()->count() != 0 ) : ?>

                          <a href="<?= Url::to($lng . '/blogs') ?>" class="type-3-btn">
                            <span>
                            <?= Yii::t('site','BLOGS_PAGE') ?> 
                            </span>
                          </a>
                        <?php endif ; ?>

                        <?php if(Testimonials::find()->active()->count() != 0 ) : ?>

                          <a href="<?= Url::to($lng . '/testimonials') ?>" class="type-3-btn">
                            <span>
                            <?= Yii::t('site','TESTIMONIAL') ?> 
                            </span>
                          </a>
                        <?php endif ; ?>

                        <?php if(ZakatStories::find()->active()->count() != 0 ) : ?>

                          <a href="<?= Url::to($lng . '/zakat-stories') ?>" class="type-3-btn">
                            <span>
                            <?= Yii::t('site','ZAKAT_PAGE') ?> 
                            </span>
                          </a>
                        <?php endif ; ?>
                    </div>
                </div>
                <div class="discover">
                <?php if(News::find()->active()->count() != 0 ) : ?>

                  <h3 class="py-3">  <?= Yii::t('site','LATEST_NEWS') ?> </h3>
                  <?php endif ; ?>

                  <div class="discover-links d-flex align-items-center flex-wrap gap-3 ">
                    <div class="row">
                    <?php foreach ( News::find()->active()->orderBy(['published_at' => SORT_DESC])->limit(4)->all() as $news => $item): ?>
                      <div class="col-md-4 col-lg-3 mb-4">
                        <a href="<?= Url::to(["/news/view", "slug" => $item->slug]) ?>" class="discover-link">
                          <h4>
                            <?= $item->title ?>
                          </h4>
                        </a>
                      </div>
                      <?php endforeach; ?>

                    </div>
                  </div>
                </div>
                <div class="discover">
                <?php if(Blogs::find()->active()->count() != 0 ) : ?>

                  <h3 class="py-3">  <?= Yii::t('site','LATEST_BLOGS') ?> </h3>
                  <?php endif ; ?>

                  <div class="discover-links d-flex align-items-center flex-wrap gap-3 ">
                    <div class="row">
                    <?php foreach ( Blogs::find()->active()->orderBy(['published_at' => SORT_DESC])->limit(4)->all() as $news => $item): ?>
                      <div class="col-md-4 col-lg-3 mb-4">
                        <a href="<?= Url::to(["/blogs/view", "slug" => $item->slug]) ?>" class="discover-link">
                          <h4>
                            <?= $item->title ?>
                          </h4>
                        </a>
                      </div>
                      <?php endforeach; ?>

                    </div>
                  </div>
                </div>
                <div class="discover">
                <?php if(Testimonials::find()->active()->count() != 0 ) : ?>

                  <h3 class="py-3">  <?= Yii::t('site','LATEST_TESTIMONIAL') ?> </h3>
                  <?php endif ; ?>

                  <div class="discover-links d-flex align-items-center flex-wrap gap-3 ">
                    <div class="row">
                    <?php foreach ( Testimonials::find()->active()->orderBy(['published_at' => SORT_DESC])->limit(4)->all() as $news => $item): ?>
                      <div class="col-md-4 col-lg-3 mb-4">
                        <a href="#" class="discover-link">
                          <h4>
                            <?= $item->title ?>
                          </h4>
                        </a>
                      </div>
                      <?php endforeach; ?>

                    </div>
                  </div>
                </div>
                <div class="discover">
                  <?php if(ZakatStories::find()->active()->count() != 0 ) : ?>

                    <h3 class="py-3">  <?= Yii::t('site','LATEST_ZAKAT') ?> </h3>
                  <?php endif ; ?>
                  <div class="discover-links d-flex align-items-center flex-wrap gap-3 ">
                    <div class="row">
                    <?php foreach ( ZakatStories::find()->active()->orderBy(['published_at' => SORT_DESC])->limit(4)->all() as $news => $item): ?>
                      <div class="col-md-4 col-lg-3 mb-4">
                        <a href="<?= Url::to(["/zakat-stories/view", "slug" => $item->slug]) ?>" class="discover-link">
                          <h4>
                            <?= $item->title ?>
                          </h4>
                        </a>
                      </div>
                      <?php endforeach; ?>

                    </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
</section>

