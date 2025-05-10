<?php

use frontend\widgets\HeaderImage;
use borales\extensions\phoneInput\PhoneInput;
use yii\helpers\Url;
use common\helpers\Utility;
use kartik\form\ActiveForm;


$this->title = Yii::t('site', 'CONTACT_US');
$this->description = Yii::t('site', 'CONTACT_US_DESCRIPTION');


$this->registerCssFile("/theme/css/ContactUs.css", ['depends' => [\frontend\assets\AppAsset::className()],]);

$lng = Yii::$app->language;

?>






<?= HeaderImage::widget(['is_inner'=> true , 'path'=>'/contact-us' ]) ?>



<section class="contact-us-section py-5">
      <div class="container">
      <?php if (Yii::$app->session->hasFlash('success')) : ?>
              <div class="alert alert-success alert-dismissable">
                  <button aria-hidden="true" data-bs-dismiss="alert" class="close btn" type="button">×</button>
                  <?= Yii::$app->session->getFlash('success')[0] ?>
              </div>
              <?php endif; ?>
        <div class="row align-items-center">
          <div class="col-lg-6 ">
            <h3 class="mb-4"> <?= Yii::t('site', 'GET_IN_TOUCH_WITH_US') ?> </h3>

                    <?php $form = \kartik\form\ActiveForm::begin([
                    //'action' => ['site/news'],
                    'id' => 'contact-form',
                    'method' => 'post',
                    'options' => [
                        'class' => 'contact-us-form customize-recaptcha',
                    ],
                    //'enableAjaxValidation' => true,
                    //'enableClientValidation' => true,
                ]);
                ?>


              <div class="d-flex flex-column w-100 align-items-start justify-content-start">
                <div class="row w-100 px-0 g-4 pt-3 pb-5">
                  <p> <?= Yii::t('site', 'WE_WOULD_LOVE_TO_HEAR') ?> </p>
                  <div class="col-lg-6 col-12 d-flex flex-column gap-2">

                    <?php $form->field($model, 'name')->textInput([  'class' => false, 'maxlength' => true,'placeholder' => Yii::t("site", "SENDER_NAME")])->label(); ?>

                  </div>
                  <div class="col-lg-12 col-12 d-flex flex-column gap-2">
          

                    <?= $form->field($model, 'mobile_number')->widget(PhoneInput::className(), [
                        'jsOptions' => [
                            'initialCountry' => 'JO', // auto not working
                            'placeholderNumberType' => false,
                            'nationalMode' => false,
                            'separateDialCode' => true,
                            'excludeCountries' => ['IL'], //unknown fucken country
                        ],
                        'options' => [
                            'class' => 'w-100',
                        ],
                    ])->label();
                    ?>

                  </div>
                  <div class="col-lg-6 col-12 d-flex flex-column gap-2">

                  <?= $form->field($model, 'purpose_id')->dropDownList($model->getContactPurposeList(), ["prompt" => Yii::t("site", "PURPOSE_OF_CONTACT"), "class" => 'form-select'])
                        ->label(); ?>


                  </div>
                  <div class="col-lg-6 col-12 d-flex flex-column gap-2">

                    <?= $form->field($model, 'email')->textInput([  'class' => false, 'maxlength' => true,'placeholder' => Yii::t("site", "EMAIL")])->label(); ?>

                  </div>
                  <div class="col-12 d-flex flex-column gap-2">

                    <?= $form->field($model, 'message')->textarea([ 'maxlength' => true, 'id' => "exampleFormControlTextarea1", 'placeholder' => Yii::t("site", "TYPE_HERE"), 'rows' => 5])->label() ?>

                  </div>
              
                  <?= $form->field($model, 'reCaptcha', [])->widget(\himiklab\yii2\recaptcha\ReCaptcha::className())->label(false); ?>
             
                  <button class="type-4-btn ms-2">
                    <span><?= Yii::t('site', 'SUBMIT')  ?> </span>
                  </button>
                </div>
              </div>
          <?php ActiveForm::end(); ?>
          </div>
          <div class="col-lg-6  d-flex align-items-center">

            <div class="contact-us-info">
            <?php if($contactUSRightSection): ?>

              <div class="head-contact-us-info">
                <h3> <?= $contactUSRightSection->title ?> </h3>
                <h2><?= $contactUSRightSection->second_title ?> </h2>
                <h5>
                <?= $contactUSRightSection->brief ?> 
                </h5>
              </div>
              <?php endif; ?>

              <div class="contact-us-communication mt-5">
                <div class="contact-us-communication-card">
                  <div class="card-communication d-flex gap-3">
                    <picture>
                      <img src="/theme/assets/Icons/Headset white.svg" alt="" class="mw-100 w-100" />
                    </picture>
                    <div class="communication-content">
                      <h4> <?= Yii::t('site', 'PHONE')  ?> </h4>
                      <h5 class="phone-number">   <?= Yii::$app->settings->get('site.phone') ?> </h5>
                      <a  href="tel:<?= Yii::$app->settings->get('site.phone') ?> " class="type-4-btn mt-3"><span> <?= Yii::t('site', 'CALL_NOW')  ?> </span></a>
                    </div>
                  </div>
                </div>
                <div class="contact-us-communication-card">
                  <div class="card-communication d-flex gap-3">
                    <picture>
                      <img src="/theme/assets/Icons/email-form.svg" alt="" class="mw-100 w-100" />
                    </picture>
                    <div class="communication-content">
                    
                      <h4><?= Yii::t('site', 'CONTACT_EMAIL')  ?></h4>
                      <h5>  <?= Yii::$app->settings->get('site.email') ?> </h5>
                      <a href="mailto:<?= Yii::$app->settings->get('site.email') ?> " class="type-4-btn mt-3"><span>  <?= Yii::t('site', 'SEND_EMAIL')  ?>  </span></a>
              
                    </div>
                  </div>
                </div>
                <div class="contact-us-communication-card">
                  <div class="card-communication d-flex gap-3">
                    <picture>
                      <img src="/theme/assets/Icons/location-form.svg" alt="" class="mw-100 w-100" />
                    </picture>
                    <div class="communication-content">
                      <h4><?= Yii::t('site', 'LOCATION')  ?></h4>
                      <h5>  <?= Yii::$app->settings->get('site.address', null, $lng) ?> </h5>
                      <a <?=Utility::PrintAllUrl(Yii::$app->settings->get('site.address_url'))?> class="type-4-btn mt-3"><span> <?= Yii::t('site', 'GET_DIRECTION')  ?>  </span></a>
                    </div>
                  </div>
                </div>
                <div class="contact-us-communication-card">
                  <div class="card-communication d-flex gap-3">
                    <picture>
                      <img src="/theme/assets/Icons/complaints-form.svg" alt="" class="mw-100 w-100" />
                    </picture>
                    <div class="communication-content">
                      <h4><?= Yii::t('site', 'COMPLAINT')  ?></h4>
                      <h5> <?=  Yii::t('site', 'COMPLAINT_BRIEF')  ?> </h5>
                      <a href="<?= Url::to(['/contact-us/complaint']); ?>" class="type-4-btn mt-3"><span>  <?= Yii::t('site', 'KNOW_MORE')  ?>  </span></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- End Contact Us Section -->
    <!-- Start Map -->
    <section class="map">
      <iframe
        src=" <?= Yii::$app->settings->get('site.google_map_url') ?>"
        width="100%" height="511" style="border: 0" allowfullscreen="" loading="lazy"
        referrerpolicy="no-referrer-when-downgrade"></iframe>
    </section>











