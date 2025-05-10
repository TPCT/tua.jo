<?php

use frontend\widgets\HeaderImage;
use common\components\custom_base_html\CustomBaseHtml;


$this->title = Yii::t('site', 'OUR_VISION_MISSION');
$this->description = Yii::t('site', 'OUR_VISION_MISSION_DESCRIPTION');

$this->registerCssFile("/theme/css/our-value.css", ['depends' => [\frontend\assets\AppAsset::className()],]);
$this->registerCssFile("/theme/css/mission-vision.css", ['depends' => [\frontend\assets\AppAsset::className()],]);

$lng = Yii::$app->language;

?>

<?= HeaderImage::widget(['is_inner'=> true , 'path'=>'/vision-mission' ]) ?>

    <section>
         <?php if($missionVissionFirstSection): ?>
            <div class="container centerd-section-topic">
                <h3>  <?= $missionVissionFirstSection->title ?> </h3>
                <p><?= $missionVissionFirstSection->brief ?> </p>
            </div>
        <?php endif; ?>

        <?php if($ourmissionVissionBlocks): ?>
        <div class="container value-cards-container">

            <?php foreach ($ourmissionVissionBlocks as $ourmissionVissionBlock): ?>
            <div class="value-card">
                <picture>
                    <img src=" <?= \frontend\widgets\WebpImage::widget(["src" => $ourmissionVissionBlock->image, "alt" =>'',"loading" => "lazy",'css' => "", "just_image" => true]); ?>"  alt="<?= $ourmissionVissionBlock->title ?>" />

                </picture>
                <div class="value-card-content">
                  <h4> <?= $ourmissionVissionBlock->title ?> </h4>
                  <p><?= $ourmissionVissionBlock->second_title ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </section>


        <?php if($ourmissionVissionThirdSection): ?>


    <?php $background =  $ourmissionVissionThirdSection->image?>
      <?= CustomBaseHtml::style(".Strategic-bachgroung-image { background-image: url( " . ($background ) . ");}") ?>



    <section class="Strategic-Priorities-section  Strategic-bachgroung-image">
        <div class="container">
            <div>
                <h3> <?= $ourmissionVissionThirdSection->title ?> </h3>
                <p> <?= $ourmissionVissionThirdSection->second_title ?></p>
            </div>
            <div></div>
        </div>
        
    </section>
    <?php endif; ?>


    <?php if($ourMissionVissionThirdSectionBlocks): ?>
    <section>
        <div class="container value-cards-container light">


        <?php foreach ($ourMissionVissionThirdSectionBlocks as $ourMissionVissionThirdSectionBlock): ?>

            <div class="value-card">
                <picture>
                    <img src=" <?= \frontend\widgets\WebpImage::widget(["src" => $ourMissionVissionThirdSectionBlock->image, "alt" =>'',"loading" => "lazy",'css' => "", "just_image" => true]); ?>"  alt="<?= $ourMissionVissionThirdSectionBlock->title ?>" />

                </picture>
                <div class="value-card-content">
                  <h4> <?= $ourMissionVissionThirdSectionBlock->title ?> </h4>
                </div>
            </div>
            <?php endforeach; ?>


        </div>
    </section>
    <?php endif; ?>


    <section class="values-accordion-section">
        <div class="container">
        <?php if($ourMissionVissionLeftSection): ?>

            <div class="d-flex flex-column justify-content-center align-items-center">
                <h1> <?= $ourMissionVissionLeftSection->title ?>  <span>

                     <picture>
                     <img src="<?= \frontend\widgets\WebpImage::widget(["src" => $ourMissionVissionLeftSection->image, "alt" =>'',"loading" => "lazy",'css' => "", "just_image" => true]); ?>"  alt="<?= $ourMissionVissionLeftSection->title ?>" />

                    </picture>
                    
                    </span>
                </h1>
     
            </div>
            <?php endif; ?>

            <?php if($ourMissionVissionAccordings): ?>

            <div class="conatiner assembly-accordion">
                <div
                  class="container accordion accordion-flush custom-accordion"
                  id="faqsFlushExample"
                >
 
                  

                <?php foreach ($ourMissionVissionAccordings as $ourMissionVissionAccording): ?>

                  <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-heading<?= $ourMissionVissionAccording->id ?>">
                      <button
                        class="accordion-button collapsed"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#flush-collapse<?= $ourMissionVissionAccording->id ?>"
                        aria-expanded="false"
                        aria-controls="flush-collapse<?= $ourMissionVissionAccording->id ?>"
                      >
                       <?= $ourMissionVissionAccording->title ?>
                        <span class="accordion-btn">
                          <i class="fa-solid fa-plus"></i>
                          <i class="fa-solid fa-minus"></i>
                        </span>
                      </button>
                    </h2>
                    <div
                      id="flush-collapse<?= $ourMissionVissionAccording->id ?>"
                      class="accordion-collapse collapse"
                      aria-labelledby="flush-heading<?= $ourMissionVissionAccording->id ?>"
                      data-bs-parent="#faqsFlushExample"
                    >
                      <div class="accordion-body">
                      <?= $ourMissionVissionAccording->content ?>

                      </div>
                    </div>
                  </div>
                  <?php endforeach; ?>

                  

                </div>
        </div>
        <?php endif; ?>

        </div>
    </section>



    <?php if($ourMissionVissionLastSection): ?>

    <section class="values-last-section d-flex flex-column justify-content-center align-items-center">
      <picture>
        <source srcset="/theme/assets/Images/AboutTUA/phone.webp" media="(max-width:575px)">
        <source srcset="/theme/assets/Images/AboutTUA/iPad.webp" media="(max-width:991px)">
        <source srcset="/theme/assets/Images/AboutTUA/banner.webp" media="(max-width:1440px)">

          <img class="mw-100 w-100 values-last-section-image-129" src="<?= \frontend\widgets\WebpImage::widget(["src" => $ourMissionVissionLastSection->image, "alt" => '', "loading" => "lazy", 'css' => "", "just_image" => true]); ?>"
                                            alt="<?= $ourMissionVissionLastSection->image ?>" />
      </picture>


    
      <div class="content-values-last-section container">
        <h3>  <?= $ourMissionVissionLastSection->title ?> </h3>
          <p><?= $ourMissionVissionLastSection->brief ?></p>
            <a href="" class="type-4-btn">
              <span>
                Read more
              </span></a>
      </div>
    </section>
    <?php endif; ?>
