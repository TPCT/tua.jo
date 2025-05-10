<?php

use frontend\widgets\header_image_2\HeaderImage2;
use ruskid\jssocials\JsSocials;
use kartik\helpers\Html;
use common\helpers\Utility;
use frontend\widgets\general_menu\GeneralMenu;
use frontend\widgets\share_button\ShareButton;

$this->title = $page->title;
$this->params['mainIdName'] = "AboutTheKing";
$lng = Yii::$app->language;

?>


<section class="Header-section">
  <?= HeaderImage2::widget() ?>
  <div class="blue-sub-header">
    <div class="container d-flex flex-column justify-content-center h-100 gap-4">
      <h2><?= $page ? $page->title : '' ?></h2>
    </div>
  </div>
</section>



<section class="about-king-section my-5 py-5 container">
  <div class="container">
    <div class="row g-sm-5">
      <div class="col-lg-<?= $page->image ? '6' : '9' ?> mb-5">
        <div class="about-king-content h-100 d-flex flex-column justify-content-center gap-2">
          <?php if ($page->country || $page->city): ?>
            <span>
              <?= $page->city ?>
              <?php if ($page->city): ?>     <?= $lng == 'en' ? ' , ' : ' ، ' ?>   <?php endif; ?>
              <?= $page->country ?>
            </span>
          <?php endif; ?>
          <?php if ($page->second_title): ?>
            <h2><?= $page->second_title ?></h2>
          <?php endif; ?>
          <?php if ($page->brief): ?>
            <p><?= $page->brief ?></p>
          <?php endif; ?>
        </div>
      </div>
      <?php if($page->image): ?>
        <div class="col-lg-6 d-flex align-items-center mb-5">
          <picture>
            <img src="<?= $page->image ?>" alt="" class="mw-100 w-100" />
          </picture>
        </div>
      <?php endif; ?>

    </div>

    <?php if($page->content): ?>
      <?= $this->render('//common_parts/_display_content_in_two_columns_bootstrap.php', ['content'=>$page->content]) ?>
    <?php endif; ?>

  </div>
</section>
<?php if ($page->firstSections): ?>
  <section class="Initiatives-section">
    <?php foreach ($page->firstSections as $section): ?>
      <div class="container Initiatives-container">
        <div>
          <h3><?= $section->title ?></h3>
          <?= $section->brief ?>
          <?php if($section->url): ?>
            <a class="read-more-btn" <?= Utility::PrintAllUrl($section->url) ?> > <?= Yii::t("site","READ_MORE") ?> </a>
          <?php endif; ?>
        </div>
        <picture>
          <img src="<?= $section->image ?>" alt="">
        </picture>
      </div>
    <?php endforeach; ?>
  </section>
<?php endif; ?>

<?= ShareButton::widget() ?>