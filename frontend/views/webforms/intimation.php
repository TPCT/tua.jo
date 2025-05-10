<?php

use frontend\widgets\HeaderImage;
use borales\extensions\phoneInput\PhoneInput;

use kartik\form\ActiveForm;



$this->title = Yii::t('site', 'INTIMATION_FORM');
$this->description = Yii::t('site', 'INTIMATION_FORM_DESCRIPTION');


$this->registerCssFile("/theme/css/intimation.css", ['depends' => [\frontend\assets\AppAsset::className()],]);

$lng = Yii::$app->language;

?>


<?= HeaderImage::widget(['is_inner'=> true , 'path'=>'/intimation' ]) ?>



    <section class="protection-main-section">
    <?php if($intimationSection): ?>

        <div class="container centerd-section-topic">
            <h3> <?= $intimationSection->title ?> </h3>
            <p><?= $intimationSection->brief ?>
            </p>
        </div>
        <?php endif; ?>

        <div class="container ">
        <?php if($intimationSection): ?>

        <div class="assembly-accordion mb-5">
                <div
                  class=" accordion accordion-flush custom-accordion"
                  id="faqsFlushExample"
                >
                <?php foreach ($intimationSection->bmsFeatures as $key => $item): ?>

                    <div class="accordion-item">
                      <h2 class="accordion-header" id="flush-heading<?= $key ?>">
                        <button
                          class="accordion-button collapsed"
                          type="button"
                          data-bs-toggle="collapse"
                          data-bs-target="#flush-collapse<?= $key ?>"
                          aria-expanded="false"
                          aria-controls="flush-collapse<?= $key ?>"
                        >
                        <?= $item["title_" . $lng] ?>
                          <span class="accordion-btn">
                            <i class="fa-solid fa-plus"></i>
                            <i class="fa-solid fa-minus"></i>
                          </span>
                        </button>
                      </h2>
                      <div
                        id="flush-collapse<?= $key ?>"
                        class="accordion-collapse collapse"
                        aria-labelledby="flush-heading<?= $key ?>"
                        data-bs-parent="#faqsFlushExample"
                      >
                        <div class="accordion-body">
                          
                        <?= $item["content_" . $lng] ?>
                        </div>
                      </div>
                    </div>
                    <?php endforeach ?>

                </div>
        </div>
        <?php endif; ?>

        <?php if (Yii::$app->session->hasFlash('success')) : ?>
              <div class="alert alert-success alert-dismissable">
                  <button aria-hidden="true" data-bs-dismiss="alert" class="close btn" type="button">×</button>
                  <?= Yii::$app->session->getFlash('success')[0] ?>
              </div>
              <?php endif; ?>

        <?php $form = \kartik\form\ActiveForm::begin([
                    //'action' => ['site/news'],
                    'id' => 'contact-form',
                    'method' => 'post',
                    'options' => [
                        'class' => '',
                    ],
                    //'enableAjaxValidation' => true,
                    //'enableClientValidation' => true,
                ]);
                ?>            <div class=" col-12 d-flex flex-column gap-3">
                <?= $form->field($model, 'inimation_webform')->textarea([ 'maxlength' => true, 'id' => "exampleFormControlTextarea1", 'placeholder' => Yii::t("site", "TYPE_HERE"), 'rows' => 5])->label() ?>

              </div>
              <?= $form->field($model, 'reCaptcha', [])->widget(\himiklab\yii2\recaptcha\ReCaptcha::className())->label(false); ?>

              <button type="submit" class="type-4-btn m-auto my-3">
              <span><?= Yii::t('site', 'SUBMIT')  ?> </span>
              </button>
              <?php ActiveForm::end(); ?>
          </div>
    </section>
    