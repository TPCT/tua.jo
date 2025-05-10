<?php

use frontend\widgets\HeaderImage;
use borales\extensions\phoneInput\PhoneInput;
use yeesoft\helpers\Html;
use yii\helpers\Url;


use kartik\form\ActiveForm;


$this->title = Yii::t('site', 'DONATION_CAMPAIN');
$this->description = Yii::t('site', 'DONATION_CAMPAIN_DESCRIPTION');


$this->registerCssFile("/theme/css/VolunteeringProgramsApply.css", ['depends' => [\frontend\assets\AppAsset::className()],]);
$this->registerCssFile("/theme/css/CreateYourDonationCampaign.css", ['depends' => [\frontend\assets\AppAsset::className()],]);

$lng = Yii::$app->language;

?>






<?= HeaderImage::widget(['is_inner'=> true , 'path'=>'/donation-campaign' ]) ?>


<section class="CreateYourDonationCampaign-section">
      <div class="container">
        <div class="main-head-form text-center">
          <h3> <?= Yii::t('site', 'DONATION_CAMPAIN') ?> </h3>
          <p>
          <?= Yii::t('site', 'DONATION_CAMPAIN_BRIEF') ?>
          </p>
        </div>
        <div class="row">
          <div class="col-lg-12 mb-4">
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
                        'class' => 'contact-us-form mb-5 radio-check',
                    ],
                    //'enableAjaxValidation' => true,
                    //'enableClientValidation' => true,
                ]);
                ?>

              <div class="d-flex flex-column w-100 align-items-center justify-content-center">
                <div class="row d-flex align-items-center justify-content-center w-100 px-0 g-4 pt-3 pb-5">
                  <div class="col-lg-4 col-md-6 col-12 d-flex flex-column gap-2">


                    <?= $form->field($model, 'name')->textInput([  'class' => false, 'maxlength' => true,'placeholder' => Yii::t("site", "VOLUNTEER_NAME")])->label(); ?>


                  </div>
                  <div class="col-lg-4 col-md-6 col-12 d-flex flex-column gap-2">

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
                  <div class="col-lg-4 col-md-6 col-12 d-flex flex-column gap-2">

                    <?= $form->field($model, 'email')->textInput([  'class' => false, 'maxlength' => true,'placeholder' => Yii::t("site", "VOLUNTEER_FORM_EMAIL")])->label(); ?>

                  </div>
                  <div class="col-lg-6 col-md-6 col-12 d-flex flex-column gap-2">


                    <?= $form->field($model, 'campaing_name')->textInput([  'class' => false, 'maxlength' => true,'placeholder' => Yii::t("site", "VOLUNTEER_EX")])->label(); ?>

                  </div>
                       
                    <?php $form->field($model, 'reason_id')->dropDownList($model->getReasonList(), ["prompt" => Yii::t("site", "SELECT_OPTION"), "class" => 'form-select'])
                        ->label(); ?>

         
              
                  <div class="col-lg-6 col-md-6 col-12 d-flex flex-column gap-2">
                  <?= $form->field($model, 'donation_goal')->textInput([  'class' => false, 'maxlength' => true,'placeholder' => Yii::t("site", "DONATION_GOAL_OPTION_PLACEHOLDER")])->label(); ?>

                  </div>
                  <div class="col-lg-4 col-md-6 col-12 d-flex flex-column gap-2 mb-3">
                    <label for="name"> <?= Yii::t('site', 'START_DATE') ?> <span class="red-astrik">*</span>
                    </label>
                    <input type="date" name="DonationCampainWebform[start_date]" class="customization_date_class" id="date" placeholder=" DD/MM/YYYY ">

                  </div>
                  <div class="col-lg-4 col-md-6 col-12 d-flex flex-column gap-2 mb-3">
                  <label for="name"> <?= Yii::t('site', 'END_DATE') ?> <span class="red-astrik">*</span>
                    </label>
                    <input type="date" name="DonationCampainWebform[end_date]" class="customization_date_class" id="date" placeholder=" DD/MM/YYYY ">

                  </div>
                  <div class="col-lg-4 col-12 d-flex flex-column gap-2">
                  <?= $form->field($model, 'donation_type_id')->dropDownList($model->getDonationTypesList(), ["prompt" => Yii::t("site", "SELECT_OPTION"), "class" => 'form-select'])
                        ->label(); ?>
                  </div>
                  <div class="ecard-design-container">
                  <p class="add-card-label">
                      Add card design <span>(Optional)</span>
                    </p>
                    <div class="e-card-design">
                    <?php foreach($cards as $key=> $card) : ?>
  
                      <div class="ecard">
                        <input type="radio" name="DonationCampainWebform[e_card_id]" value="<?= $card->id ?>" />
  
                        <?= \frontend\widgets\WebpImage::widget(["src" => $card->image, "alt" => $card->title, "loading" => "lazy", 'css' => ""]) ?>
  
                      </div>
                      <?php endforeach; ?>
  
                    </div>
                  </div>
                  <div class="col-12 d-flex flex-column gap-2">

                    <?= $form->field($model, 'message')->textarea([ 'maxlength' => true, 'id' => "exampleFormControlTextarea1", 'placeholder' => Yii::t("site", "TYPE_HERE"), 'rows' => 5])->label() ?>

                  </div>
                  <div>
                    <div class="CreateYourDonationCampaign-yellowbox">
                      <p> <?= Yii::t('site', 'YOUR_CAMPAING_WILL_BE_LAUNCHED') ?>  </p>
                    </div>
                  </div>
                  <div class="col-12">
                    <?= $form->field($model, 'reCaptcha', [])->widget(\himiklab\yii2\recaptcha\ReCaptcha::className())->label(false); ?>

                    </div>
                  <div class="col-12 d-flex justify-content-center mt-4">
                    <button class="type-4-btn ms-2">
                      <span> <?= Yii::t('site','SUBMIT') ?>  </span>
                    </button>
                  </div>
                </div>
              </div>
            
              <?php ActiveForm::end(); ?>
          </div>
        </div>
      </div>
    </section>




    <?php
    $script = <<< JS
    $(document).ready(function () {
        $(".ecard input[type='radio']").each(function() {
        $(this).on("mousedown", function() {
          this.wasChecked = this.checked;
        });
        $(this).on("click", function() {
          if (this.wasChecked) {
            this.checked = false;
            this.wasChecked = false;
            $(this).closest('.ecard').removeClass('selected');
          } else {
            $('.ecard').removeClass('selected');
            $(this).closest('.ecard').addClass('selected');
          }
        });
      });
    });
JS;
$this->registerJs($script);
?>




