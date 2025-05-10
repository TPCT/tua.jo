<?php


use frontend\widgets\footer_menu\FooterMenu;
use frontend\widgets\social_links\SocialLinks;
use backend\modules\bms\models\Bms;
use common\helpers\Utility;

$lng = Yii::$app->language;

$footerLinks =  Bms::getDb()->cache(function ($db) {
  return Bms::find()->activeWithCategory("footer-links")->all();
}, 3600);

?>

<footer class="main-footer-container">
      <div class="container footer-section">
        <div class="footer-item">
          <div class="footer-item-header">
            <a href="#" class="logo-img">

              <img src="<?= \frontend\widgets\WebpImage::widget(["src" => Yii::$app->settings->get('site.logo', null, $lng)??'', "alt" =>"" ,"loading" => "lazy",'css' => "mw-100", "just_image" => true]); ?>" 
                 alt="" />
            </a>
          </div>
          <p class="desc-footer">
          <?= Yii::t('site', 'FOOTER_DESCRIPTION') ?>
          </p>
          <div class="mt-3">
              
          <a  <?= Utility::PrintAllUrl( Yii::$app->settings->get('site.footer_url', null) ?? ''  ) ?>>
              <img src="<?= \frontend\widgets\WebpImage::widget(["src" => Yii::$app->settings->get('site.footer_logo', null, $lng)??'', "alt" =>"" ,"loading" => "lazy",'css' => "mw-100", "just_image" => true]); ?>" 
                   alt="" />
              </a>
            </div>
        </div>


        <?= FooterMenu::widget() ?>


        <div class="footer-item">
          <div class="footer-item-header">
            <h3> <?= Yii::t('site', 'DOWNLOAD_APP') ?>  </h3>
            <button class="toggleButton mobile-responsive" data-target="about">
              <i class="fa-solid fa-plus"></i>
              <i class="fa-solid fa-minus" style="display: none"></i>
            </button>
          </div>
          <ul id="about">
 
            <li>
            <?php if( Yii::$app->settings->get('site.google_store_url', null) ): ?>
              <a <?= Utility::PrintAllUrl( Yii::$app->settings->get('site.google_store_url', null) ?? ''  ) ?>>
                <picture class="app">
                  <img class="mw-100" src="<?= Yii::$app->settings->get('site.google_store_logo', null, $lng) ?? '' ?>" alt="" />
                </picture>
              </a>
              <?php endif; ?>
            </li>
            <li>
            <?php if( Yii::$app->settings->get('site.app_store_url', null) ): ?>
              <a <?= Utility::PrintAllUrl( Yii::$app->settings->get('site.app_store_url', null) ?? ''  ) ?> >
                <picture class="app">
                  <img class="mw-100" src="<?= Yii::$app->settings->get('site.app_store_logo', null, $lng) ?? '' ?>" alt="" />

                </picture>
              </a>
              <?php endif; ?>
            </li>
          </ul>
        </div>
        <div class="footer-item">
          <div class="footer-item-header">
            <h3> <?= Yii::t('site', 'STAY_UPDATED')   ?></h3>
            <button class="toggleButton mobile-responsive" data-target="about">
              <i class="fa-solid fa-plus"></i>
              <i class="fa-solid fa-minus" style="display: none"></i>
            </button>
      
          </div>
          <ul id="about">

            <?= SocialLinks::widget() ?>

          </ul>
        </div>
      </div>
      <div class="footer-copyright-container">
        <div class="footer-copyright-container-centered">
          <div class="">
          <p>  © <?= date('Y') ?>   <?=Yii::t("site", "DEVELOPED_BY")?>  <a target="blank" rel='noopener noreferrer nofollow' href="https://dot.jo/" class="color-main dotjo-color"> dot.jo  </a>  <?=Yii::t("site", "COPY_RIGHT")?> </p>
          </div>
          <div class="">
          <?php foreach($footerLinks as $footerLink): ?>

                <a <?= Utility::PrintAllUrl($footerLink->url) ?> > <?= $footerLink->title ?> </a>
            <?php endforeach; ?>

         
          </div>
        </div>
      </div>
    </footer>