<?php

use frontend\widgets\HeaderImage;

$this->title = Yii::t('site', 'FAQs');
$this->registerCssFile("/theme/css/FAQs.css", ['depends' => [\frontend\assets\AppAsset::className()],]);
use yii\helpers\Url;
use kartik\form\ActiveForm;

$this->title = Yii::t('site', 'FAQ');
$this->description = Yii::t('site', 'FAQ_DESCRIPTION');

$lng = Yii::$app->language;
?>
<?php


?>
      <?= HeaderImage::widget(['is_inner'=> true , 'path'=>'/faq' ]) ?>


      <section class="faqs-section py-5">
      <div class="container">
        <div class="row">
          <div class="col-lg-4 mb-4">
            <!-- Tabs navs -->
            <?php if(count($categories) > 1 ) : ?>
            <ul class="nav nav-tabs mb-4 flex-column justify-content-start gap-1" role="tablist">
              <h3> <?= Yii::t('site', 'TABLE_OF_CONTETN') ?> </h3>

              <?php foreach($categories as $key => $category) : ?>

              <li class="nav-item" role="presentation">
                <a class="nav-link <?= $key === 0 ? 'active' : ''  ?> " id="simple-tab-<?= $category->id ?>" data-bs-toggle="tab" href="#simple-tabpanel-<?= $category->id ?>" role="tab"
                  aria-controls="simple-tabpanel-<?= $category->id ?>" aria-selected="true"><?= $category->title ?></a>
              </li>
              <?php endforeach; ?>

        
            </ul>
      <?php endif; ?>
          </div>
          <div class="col-lg-8">
            <div class="tab-content pt-3" id="tab-content">

            <?php foreach($categories as $key => $category) : ?>

              <div class="tab-pane <?= $key === 0 ? 'active' : '' ?> " id="simple-tabpanel-<?= $category->id ?>" role="tabpanel" aria-labelledby="simple-tab-<?= $key ?>">
                <section class="faqs-section">
                  <div class="container accordion accordion-flush custom-accordion" id="faqsFlushExample<?= $category->id ?>">
                    <div class="Faqs-acc-splited-div">
                     
                    <?php foreach($category->faqs as $key => $faq) : ?>
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="flush-heading<?= $faq->slug ?>">
                          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#flush-collapse<?= $faq->slug ?>" aria-expanded="false" aria-controls="flush-collapse<?= $faq->slug ?>">
                            <?= $faq->title ?>
                            <span class="accordion-btn">
                              <i class="fa-solid fa-plus"></i>
                              <i class="fa-solid fa-minus"></i>
                            </span>
                          </button>
                        </h2>
                        <div id="flush-collapse<?= $faq->slug ?>" class="accordion-collapse collapse"
                          aria-labelledby="flush-heading<?= $faq->slug ?>" data-bs-parent="#faqsFlushExample<?= $faq->category_id ?>">
                          <div class="accordion-body">
                          <?= $faq->content ?>
                          </div>
                        </div>
                      </div>
                      <?php endforeach; ?>

  
        
      
         
                    </div>
                  </div>
                </section>
              </div>
              <?php endforeach; ?>

        
            </div>
          </div>
        </div>
      </div>
    </section>