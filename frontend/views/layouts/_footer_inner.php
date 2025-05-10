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
              <i class="fa-solid fa-minus"></i>
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
            <h3> <?= Yii::t('site', 'STAY_UPDATED') ?></h3>
            <button class="toggleButton mobile-responsive" data-target="about">
              <i class="fa-solid fa-plus"></i>
              <i class="fa-solid fa-minus" ></i>
            </button>
          </div>
          <ul id="about">
<!--          <li>-->
<!--            --><?php //\kartik\form\ActiveForm::begin([
//                  'action' => ['/site/newsletter-subscribe'],
//                  'id' => 'newsletter-form',
//                  'options' => ['class' => 'clearfix'],
//                ]) ?>
<!--              <div class="form-group">-->
<!--                <picture>-->
<!--                  <img src="./assets/Icons/footer-envelop.png" alt="" class="footer-envelop" />-->
<!--                </picture>-->
<!--                <input type="email" class="form-control" name="email" id="newsletter-email" aria-describedby="emailHelp"-->
<!--                  placeholder="info@example.com" />-->
<!--              </div>-->
<!--     -->
<!---->
<!--              <a  href="javascript:void(0);" id="newsletter-submit-btn" class="btn stay-btn">-->
<!--                <span>-->
<!--                --><?php //= Yii::t('site', 'SUBMITE')   ?>
<!--                </span>-->
<!---->
<!--                <svg width="17" height="19" viewBox="0 0 17 19" fill="none" xmlns="http://www.w3.org/2000/svg">-->
<!--                  <path-->
<!--                    d="M16.0206 8.35116L2.23932 0.485183C2.00686 0.354322 1.74005 0.2974 1.47443 0.322C1.2088 0.346601 0.956981 0.451557 0.752511 0.622884C0.54804 0.794212 0.40063 1.02378 0.329918 1.28099C0.259206 1.53821 0.26855 1.81087 0.356705 2.06264L2.86932 9.4996L0.356705 16.9374C0.286779 17.1353 0.265344 17.3471 0.294197 17.555C0.32305 17.7629 0.401349 17.9609 0.522525 18.1323C0.643702 18.3037 0.80422 18.4435 0.990611 18.5401C1.177 18.6366 1.38383 18.687 1.59374 18.6871C1.82178 18.6866 2.04585 18.6273 2.24424 18.5148L16.0189 10.6357C16.2221 10.5219 16.3913 10.3561 16.5093 10.1553C16.6272 9.95446 16.6896 9.72589 16.69 9.493C16.6904 9.26012 16.6289 9.03132 16.5116 8.83009C16.3944 8.62885 16.2258 8.46242 16.023 8.34788L16.0206 8.35116ZM1.59374 17.3746C1.59409 17.3713 1.59409 17.368 1.59374 17.3648L4.03335 10.1558H8.81249C8.98653 10.1558 9.15345 10.0867 9.27652 9.96364C9.3996 9.84057 9.46874 9.67365 9.46874 9.4996C9.46874 9.32555 9.3996 9.15863 9.27652 9.03556C9.15345 8.91249 8.98653 8.84335 8.81249 8.84335H4.03335L1.59866 1.63772C1.59785 1.63308 1.59618 1.62863 1.59374 1.6246L15.375 9.48565L1.59374 17.3746Z" />-->
<!--                </svg>-->
<!--            </a>-->
<!--              --><?php //\kartik\form\ActiveForm::end(); ?>
<!--          </li>-->

            <?= SocialLinks::widget() ?>




          </ul>
        </div>
      </div>
      <div class="footer-copyright-container">
        <div class="footer-copyright-container-centered">
          <div class="">
          <p>  © <?= date('Y') ?> <?=Yii::t("site", "DEVELOPED_BY")?> <a target="blank" rel='noopener noreferrer nofollow' href="https://dot.jo/" class="color-main dotjo-color">dot.jo</a><?=Yii::t("site", "COPY_RIGHT")?> </p>
          </div>
          <div class="">
          <?php foreach($footerLinks as $footerLink): ?>

          <a <?= Utility::PrintAllUrl($footerLink->url) ?> > <?= $footerLink->title ?> </a>
          <?php endforeach; ?>

          </div>
        </div>
      </div>
    </footer>

    <?php
$style = <<<CSS
.fa-solid.fa-minus {
  display :none;
}
CSS;

$this->registerCss($style);

?>