<?php

use frontend\widgets\header_image_2\HeaderImage2;
use ruskid\jssocials\JsSocials;
use kartik\helpers\Html;
use common\helpers\Utility;
use frontend\widgets\general_menu\GeneralMenu;
use frontend\widgets\share_button\ShareButton;

$this->title = $bms->title;
$this->params['mainIdName'] = "AboutTheKing";
$lng = Yii::$app->language;

?>


<section class="Header-section">
  <div class="blue-sub-header">
    <div class="container d-flex flex-column justify-content-center h-100 gap-4">
      <h2><?= $bms->title  ?></h2>
    </div>
  </div>
</section>



<section class="about-king-section my-5 py-5 container">
  <div class="container">
    <div class="row g-sm-5">
      <div class="col-lg-<?= $bms->image ? '6' : '9' ?> mb-5">
        <div class="about-king-content h-100 d-flex flex-column justify-content-center gap-2">
          <h2> <?= $bms->title ?> </h2>
        </div>
      </div>
      <div class="col-lg-<?= $bms->image ? '6' : '3' ?> d-flex align-items-center mb-5">
        <picture>
          <img src="<?= $bms->image ?>" alt="" class="mw-100 w-100" />
        </picture>
      </div>
    </div>

    <?= $this->render('//common_parts/_display_content_in_two_columns_bootstrap.php', ['content'=>$bms->brief]) ?>

  </div>
</section>

<?= ShareButton::widget() ?>