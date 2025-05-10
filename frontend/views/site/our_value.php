<?php

use frontend\widgets\HeaderImage;

use common\helpers\Utility;
use yii\helpers\Url;

$this->title = Yii::t('site', 'OUR_VALUE');
$this->description = Yii::t('site', 'OUR_VALUE_DESCRIPTION');

$this->registerCssFile("/theme/css/our-value.css", ['depends' => [\frontend\assets\AppAsset::className()],]);

$lng = Yii::$app->language;

?>
<?= HeaderImage::widget(['is_inner'=> true , 'path'=>'/our-value' ]) ?>


    <section>
    <?php if($ourValuesFirstSection): ?>
        <div class="container centerd-section-topic">
            <h3> <?= $ourValuesFirstSection->title ?> </h3>
            <p><?= $ourValuesFirstSection->brief ?></p>
        </div>
        <?php endif; ?>

        <?php if($ourValuesBlocks): ?>

        <div class="container value-cards-container">


        <?php foreach ($ourValuesBlocks as $ourValuesBlock): ?>

            <div class="value-card">
                <picture>
                    <img src=" <?= \frontend\widgets\WebpImage::widget(["src" => $ourValuesBlock->image, "alt" =>$ourValuesBlock->title ,"loading" => "lazy",'css' => "", "just_image" => true]); ?>"  alt="<?= $ourValuesBlock->title ?>" />

                </picture>
                <div class="value-card-content">
                  <h4> <?= $ourValuesBlock->title ?> </h4>
                  <p><?= $ourValuesBlock->second_title ?></p>
                
              </div>
            </div>
            <?php endforeach; ?>

        </div>
        <?php endif; ?>
    </section>
    
    <?php if($ourValuesLastSection): ?>

    <section class="values-last-section d-flex flex-column justify-content-center align-items-center">
      <picture>
        <source srcset="/theme/assets/Images/AboutTUA/phone.png" media="(max-width:575px)">
        <source srcset="/theme/assets/Images/AboutTUA/iPad.png" media="(max-width:991px)">
        <source srcset="/theme/assets/Images/AboutTUA/banner.png" media="(max-width:1440px)">

          <img class="mw-100 w-100 values-last-section-image-129" src="<?= \frontend\widgets\WebpImage::widget(["src" => $ourValuesLastSection->image, "alt" => '', "loading" => "lazy", 'css' => "", "just_image" => true]); ?>"
                                            alt="" />
      </picture>


    
      <div class="content-values-last-section container">
        <h3>  <?= $ourValuesLastSection->title ?> </h3>
          <p><?= $ourValuesLastSection->brief ?></p>

          <?php if($ourValuesLastSection->url_1): ?>

            <a <?= Utility::PrintAllUrl($ourValuesLastSection->url_1) ?> class="type-4-btn">
              <span>
                <?=  $ourValuesLastSection->button_text ?>
              </span>
            </a>
          <?php endif; ?>

      </div>
    </section>
    <?php endif; ?>






