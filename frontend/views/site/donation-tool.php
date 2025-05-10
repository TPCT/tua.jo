<?php

use frontend\widgets\HeaderImage;
use yii\helpers\Url;
use kartik\form\ActiveForm;
use common\helpers\Utility;
use frontend\assets\NiseSelectAsset;
NiseSelectAsset::register($this);


$this->title = Yii::t('site', 'DONATION_TOOLS');
$this->description = Yii::t('site', 'DONATION_TOOLS_DESCRIPTION');


$this->registerCssFile("/theme/css/DonationTools.css", ['depends' => [\frontend\assets\AppAsset::className()],]);

$lng = Yii::$app->language;

?>


<?= HeaderImage::widget(['is_inner'=> true , 'path'=>'/donation-tool' ]) ?>


<?php if($donationTools): ?>

<section class="donation-tools mt-5">
        <div class="container">
          <div class="filter d-flex flex-column gap-3 align-items-start">
            <h3> <?= Yii::t('site', 'CHOOSE_THE_METHOD_OF_DONTATION_TOOLS') ?> </h3>
            <?php
            $form = ActiveForm::begin([
                'action' => Url::to(['/news/index']),

                'id' => 'news-search',
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
                    'data-model' => "donation-tool",
                    'data-pjax' => true

                ],
                
            ])
        ?>

            <?= $form->field($searchModel, "donationTitle")->dropDownList($searchModel->getDonationToolList(),['class' => 'form-select customize-select input-submit',"prompt"=> Yii::t('site', 'SELECT_TITLE'), 'data-url-name' => "title" ])->label(false) ?>

          </div>
          <?php \kartik\form\ActiveForm::end(); ?>

          <?php foreach ($donationTools as $donationTool): ?>

          <div class="row donation-tools-container my-5">
            <div
              class="col-lg-6 d-flex flex-column align-items-center justify-content-center"
            >

              <?= \frontend\widgets\WebpImage::widget(["src" => $donationTool->image, "alt" => $donationTool->title, "loading" => "lazy", 'css' => "mw-100 donationTools-main-img"]) ?>

            </div>
            
            <div
              class="col-lg-6 donation-tools-container d-flex flex-column align-items-center justify-content-center"
            >
              <div class="donation-tools-content-container">
                <h3> <?= $donationTool->title ?> </h3>
                <div class="donation-tools-content">
                <?= $donationTool->content ?>
                  <ul class="d-flex align-items-center list-unstyled gap-3">
                  <?php if($donationTool->url_1) : ?>
                    <li>
                      <a  <?= Utility::PrintAllUrl($donationTool->url_1) ?>>
                      <picture class="app">

                          <?= \frontend\widgets\WebpImage::widget(["src" => $donationTool->button_image_1, "alt" => $donationTool->url_1, "loading" => "lazy", 'css' => "mw-100 "]) ?>
                        </picture>

                      </a>
                    </li>
                    <?php endif; ?>
                    <?php if($donationTool->url_2) : ?>
                    <li>
                      <a <?= Utility::PrintAllUrl($donationTool->url_2) ?> >
                      <picture class="app">

                        <?= \frontend\widgets\WebpImage::widget(["src" => $donationTool->button_image_2, "alt" => $donationTool->url_2, "loading" => "lazy", 'css' => "mw-100 "]) ?>
                      </picture>
                      </a>
                    </li>
                    
                    <?php endif; ?>

                    <?php if($donationTool->pdf_file) : ?>
                    <li>
                      <a class="downlad-btn" href="<?= $donationTool->pdf_file; ?>" target="_blank">
                        <p> <?= $donationTool->title ?> </p>
                        <svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path
                            d="M18.75 11.625V17.625C18.75 17.9234 18.6315 18.2095 18.4205 18.4205C18.2095 18.6315 17.9234 18.75 17.625 18.75H1.125C0.826631 18.75 0.540483 18.6315 0.329505 18.4205C0.118526 18.2095 0 17.9234 0 17.625V11.625C0 11.3266 0.118526 11.0405 0.329505 10.8295C0.540483 10.6185 0.826631 10.5 1.125 10.5C1.42337 10.5 1.70952 10.6185 1.9205 10.8295C2.13147 11.0405 2.25 11.3266 2.25 11.625V16.5H16.5V11.625C16.5 11.3266 16.6185 11.0405 16.8295 10.8295C17.0405 10.6185 17.3266 10.5 17.625 10.5C17.9234 10.5 18.2095 10.6185 18.4205 10.8295C18.6315 11.0405 18.75 11.3266 18.75 11.625ZM8.57906 12.4209C8.68358 12.5258 8.80777 12.609 8.94452 12.6658C9.08126 12.7226 9.22787 12.7518 9.37594 12.7518C9.524 12.7518 9.67061 12.7226 9.80736 12.6658C9.9441 12.609 10.0683 12.5258 10.1728 12.4209L13.9228 8.67094C14.1342 8.45959 14.2529 8.17295 14.2529 7.87406C14.2529 7.57518 14.1342 7.28853 13.9228 7.07719C13.7115 6.86584 13.4248 6.74711 13.1259 6.74711C12.8271 6.74711 12.5404 6.86584 12.3291 7.07719L10.5 8.90625V1.125C10.5 0.826631 10.3815 0.540483 10.1705 0.329505C9.95952 0.118526 9.67337 0 9.375 0C9.07663 0 8.79048 0.118526 8.5795 0.329505C8.36853 0.540483 8.25 0.826631 8.25 1.125V8.90625L6.42094 7.07906C6.31629 6.97442 6.19206 6.8914 6.05533 6.83477C5.9186 6.77814 5.77206 6.74899 5.62406 6.74899C5.32518 6.74899 5.03853 6.86772 4.82719 7.07906C4.72254 7.18371 4.63953 7.30794 4.5829 7.44467C4.52626 7.5814 4.49711 7.72794 4.49711 7.87594C4.49711 8.17482 4.61584 8.46147 4.82719 8.67281L8.57906 12.4209Z" />
                        </svg>
                      </a>
                    </li>

                    <?php endif; ?>
                  </ul>
                </div>
              </div>
            </div>
          </div>
          <?php endforeach; ?>



        </div>
      </section>
      <?php endif; ?>



      <?php
    $script = <<< JS
    $(document).ready(function () {
   
      $('.customize-select').niceSelect();
    });
JS;
$this->registerJs($script);
?>


