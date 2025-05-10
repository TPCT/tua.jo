<?php

use yii\helpers\Url;
use kartik\form\ActiveForm;
use frontend\widgets\HeaderImage;


$this->title = Yii::t('site', 'OFFER-TENDERS');
$this->description = Yii::t('site', 'OFFER-TENDERS_DESCRIPTION');

$this->registerCssFile("/theme/css/our-value.css", ['depends' => [\frontend\assets\AppAsset::className()],]);
$this->registerCssFile("/theme/css/offered-tenders.css", ['depends' => [\frontend\assets\AppAsset::className()],]);
$this->registerCssFile("/theme/css/Blogs.css", ['depends' => [\frontend\assets\AppAsset::className()],]);


$lng = Yii::$app->language;
?>
<?php

?>
      <?= HeaderImage::widget(['is_inner'=> true , 'path'=>'/offer-tenders' ]) ?>

 <section>
 <?php if($offerTendersFirstsection): ?>

    <div class="container centerd-section-topic">
        <h3><?= $offerTendersFirstsection->title ?></h3>
        <p>  <?= $offerTendersFirstsection->brief ?> </p>
    </div>
    <?php endif; ?>

    <?php if($offerTendersSecondsections): ?>


    <div class="container value-cards-container">
    <?php foreach ($offerTendersSecondsections as $offetTendersSecondsection): ?>


        <div class="value-card">

          <?= \frontend\widgets\WebpImage::widget(["src" => $offetTendersSecondsection->image, "alt" => $offetTendersSecondsection->title, "loading" => "lazy", 'css' => ""]) ?>


            <div class="value-card-content">
              <h4> <?= $offetTendersSecondsection->title ?> </h4>
              <p><?= $offetTendersSecondsection->brief ?> </p>
            </div>
        </div>
        <?php endforeach; ?>

    </div>
    <?php endif; ?>


   </section>
   <section class="offered-tenders-last-section">
    <div class="container">
      <h3 class="text-center"> <?=  Yii::t('site', 'OFFERED_TENDERS_LIST') ?> </h3>
        
      <ul class="nav custom-panel nav-pills mb-3" id="pills-tab" role="tablist">
      <?php foreach ($categories as $key => $category): ?>

        <li class="nav-item" role="presentation">
          <button class="nav-link <?= $key == 0 ? 'active' : '' ?>" id="pills-<?= $category->slug ?>-tab" data-bs-toggle="pill"
            data-bs-target="#pills-<?= $category->slug ?>" type="button" role="tab" aria-controls="pills-<?= $category->slug ?>"
            aria-selected="false">
            <?= $category->title ?>
          </button>
        </li>

        <?php endforeach; ?>


      </ul>

      <div class="tab-content" id="pills-tabContent">
      <?php foreach ($categories as $key => $category): ?>

        <div class="tab-pane fade   <?= $key == 0 ? ' show active' : '' ?>" id="pills-<?= $category->slug ?>" role="tabpanel"
          aria-labelledby="pills-<?= $category->slug ?>-tab">
          <div class="container effective-container">

          <?php foreach ($OfferedTenders as $key => $OfferedTender): ?>

          <?php if ($OfferedTender->category_id == $category->id): ?> 

            <div class="effective-card">

                <?= \frontend\widgets\WebpImage::widget(["src" => $OfferedTender->image, "alt" => $OfferedTender->title, "loading" => "lazy", 'css' => "mw-100"]) ?>

                <div class="overflow-hidden">
                    <div class="effective-card-date">
                        <picture><img src="/theme/assets/Icons/CalendarDot.svg" alt=""></picture>
                        <h5> <?= Yii::t('site', 'APPLICATION_DATE')  ?> : <?= $OfferedTender->getPublishedAtFullDate($OfferedTender->published_at) ?></h5>
                    </div>
                    <div class="effective-card-content">
                        <h4> <?= $OfferedTender->title ?> .</h4>
                            <div class="d-flex justify-start gap-2 buttons ">

                                <a href="<?= Url::to(["/offer-tenders/view", "slug" => $OfferedTender->slug]) ?>" class="type-4-btn">
                                  <span>  <?=  Yii::t('site', 'MORE_DETAILS') ?> </span>
                                  <svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                      d="M18.4152 11.1969L12.5089 17.1031C12.324 17.288 12.0732 17.3919 11.8117 17.3919C11.5502 17.3919 11.2993 17.288 11.1144 17.1031C10.9295 16.9182 10.8256 16.6674 10.8256 16.4058C10.8256 16.1443 10.9295 15.8935 11.1144 15.7086L15.3398 11.4848H3.28125C3.02018 11.4848 2.7698 11.3811 2.58519 11.1965C2.40059 11.0119 2.29688 10.7615 2.29688 10.5004C2.29688 10.2393 2.40059 9.98897 2.58519 9.80436C2.7698 9.61975 3.02018 9.51604 3.28125 9.51604H15.3398L11.1161 5.28979C10.9311 5.10487 10.8272 4.85405 10.8272 4.59253C10.8272 4.331 10.9311 4.08019 11.1161 3.89526C11.301 3.71034 11.5518 3.60645 11.8133 3.60645C12.0748 3.60645 12.3257 3.71034 12.5106 3.89526L18.4168 9.80151C18.5086 9.89309 18.5814 10.0019 18.631 10.1217C18.6806 10.2415 18.7061 10.3699 18.706 10.4995C18.7058 10.6292 18.68 10.7575 18.6301 10.8772C18.5802 10.9969 18.5072 11.1055 18.4152 11.1969Z"
                                   />
                                  </svg>
                                </a>

                                <?= frontend\widgets\cards_share_box_button\CardsShareBoxButton::widget([
                                'url' => $OfferedTender->slug
                            ]); ?>

                            </div>
                    </div>
                </div>
            </div>   
            <?php endif; ?>

            <?php endforeach; ?>
         
        </div>
    
        </div>
        <?php endforeach; ?>


        <!-- <div class="tab-pane fade" id="corporate" role="tabpanel" aria-labelledby="corporate-tab">
            
        </div> -->
      </div>
    </div>
   </section>