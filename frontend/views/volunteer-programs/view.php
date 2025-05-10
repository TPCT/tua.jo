<?php

use yii\helpers\Url;
use kartik\form\ActiveForm;
use frontend\widgets\breadcrumbs\BreadCrumbs;
use yeesoft\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\depdrop\DepDrop;

use backend\modules\countries\models\Country;
use borales\extensions\phoneInput\PhoneInput;


$this->registerCssFile("/theme/css/ContactUs.css", ['depends' => [\frontend\assets\AppAsset::className()],]);
$this->registerCssFile("/theme/css/VolunteeringProgramsApply.css", ['depends' => [\frontend\assets\AppAsset::className()],]);


$lng = Yii::$app->language;

$this->title =  $targetVolunteers->title ;
$this->description =$targetVolunteers->content;
$this->og_image =  $targetVolunteers->image   ;
$this->type = "article";

?>

<?= BreadCrumbs::widget(['is_inner'=> false , 'bread_crumb_slug'=>  $targetVolunteers->slug, 'bread_crumb_title'=>  $targetVolunteers->title  ]) ?>

      <!-- End Header Section -->
      <!-- Start Contact Us Section -->
      <section class="contact-us-section py-5">
        <div class="container">
          <div class="row">
          <?php if ($targetVolunteers != 'other'): ?>

            <div class="col-lg-6 mb-4">

              <div class="VolunteeringProgramsApply-content-container">
                <div
                  class="VolunteeringProgramsApply-head d-flex align-items-center justify-content-between"
                >
                  <h3 class="mb-0"> <?= $targetVolunteers->title ?> </h3>
                <div class="share-button-section align-items-center d-flex justify-content-start position-relative">
                    <div class="share-btn p-0" id="share">
                      <div class="shareicoon">
                        <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path
                            d="M18.0697 17.0455C18.0698 17.4933 17.9718 17.9358 17.7827 18.3417C17.5935 18.7476 17.3178 19.1072 16.9749 19.3952C16.632 19.6833 16.2302 19.8928 15.7978 20.009C15.3653 20.1252 14.9126 20.1453 14.4715 20.068C14.0304 19.9906 13.6116 19.8177 13.2445 19.5612C12.8774 19.3048 12.5708 18.971 12.3464 18.5835C12.122 18.196 11.9851 17.764 11.9454 17.318C11.9057 16.8719 11.9641 16.4226 12.1166 16.0015L7.59952 13.0995C7.16811 13.5227 6.62134 13.809 6.0278 13.9226C5.43427 14.0362 4.8204 13.972 4.26321 13.7381C3.70602 13.5041 3.23032 13.1109 2.89579 12.6076C2.56127 12.1043 2.38281 11.5135 2.38281 10.9092C2.38281 10.3048 2.56127 9.71399 2.89579 9.21072C3.23032 8.70745 3.70602 8.31417 4.26321 8.08022C4.8204 7.84627 5.43427 7.78207 6.0278 7.89568C6.62134 8.00929 7.16811 8.29564 7.59952 8.71882L12.1166 5.82109C11.8579 5.11033 11.8702 4.32919 12.1511 3.62692C12.432 2.92466 12.9618 2.35051 13.6393 2.01418C14.3167 1.67786 15.0944 1.60294 15.8236 1.80374C16.5528 2.00455 17.1825 2.46699 17.5923 3.10272C18.002 3.73845 18.1632 4.50287 18.045 5.24994C17.9268 5.997 17.5375 6.67432 16.9514 7.15247C16.3654 7.63062 15.6237 7.87608 14.8681 7.84193C14.1125 7.80779 13.396 7.49645 12.8555 6.96739L8.33844 9.86938C8.58257 10.544 8.58257 11.2828 8.33844 11.9575L12.8555 14.8594C13.2868 14.4374 13.8329 14.1518 14.4256 14.0386C15.0184 13.9253 15.6313 13.9893 16.1878 14.2227C16.7443 14.456 17.2197 14.8482 17.5544 15.3503C17.8891 15.8524 18.0684 16.4421 18.0697 17.0455Z"
                            fill="#FAFAFA" />
                        </svg>
                      </div>
                      <?= Yii::t('site','SHARE') ?>
                    </div>
                      <div class="share-overlay align-items-center gap-3 p-0" id="share-overlay">
                      <a href="#" id="copy-link"><i class="fa-regular fa-copy"></i></a>
                      <a href="#" id="twitter"><i class="fa-brands fa-x-twitter"></i></a>
                      <a href="#" id="linkedin"><i class="fa-brands fa-linkedin-in"></i></a>
                      <a href="#" id="whatsapp"><i class="fa-brands fa-whatsapp"></i></a>
                      <a href="#" id="facebook"><i class="fa-brands fa-facebook"></i></a>
                        <div id="closeButton">
                          <i class="fa-solid fa-xmark"></i>
                        </div>
                      </div>
                    </div>
                </div>
                <picture>

                  <?= \frontend\widgets\WebpImage::widget(["src" => $targetVolunteers->image, "alt" => $targetVolunteers->title, "loading" => "lazy", 'css' => "mw-100 w-100"]) ?>

                </picture>
  
                <div class="VolunteeringProgramsApply-content py-3">
                  <h3> <?= Yii::t('site', 'VOLUNTEERING_CONDITION') ?> :</h3>
                  <ul>

                      <?= $targetVolunteers->content ?>
                  </ul>
                <?php if($targetVolunteers->file_label ): ?>
                  <ul>
                    <li>                  

                        <a  href="<?= $targetVolunteers->file; ?>" target="_blank"> <?= $targetVolunteers->file_label ?> </a>
                    </li>
                  </ul>
   
                <?php endif; ?> 

                </div>
              </div>
              
            </div>
            <?php endif ; ?>

            <div class="col-lg-6 mb-4">
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
                        'class' => 'mb-5 contact-us-form customize-recaptcha volunteer-program',
                    ],
                    //'enableAjaxValidation' => true,
                    //'enableClientValidation' => true,
                ]);
                ?>
                <div
                  class="d-flex flex-column w-100 align-items-start justify-content-start"
                >
                  <div class="row w-100 px-0 g-4 pt-3 pb-5">
                    <p> <?= Yii::t('site', 'TO_APPLY_FILL_THE_FIELDS') ?> </p>
                    <div class="col-lg-6 col-12 d-flex flex-column gap-2">

                      <?= $form->field($model, 'name')->textInput([  'class' => false, 'maxlength' => true,'placeholder' => Yii::t("site", "VOLUNTEER_NAME")])->label(); ?>

                    </div>
                    <div class="col-lg-6 col-12 d-flex flex-column gap-2">

                      <label for="date">  <?= Yii::t("site", "VOLUNTEER_DATE_OF_BIRTH") ?> <span class="red-astrik"> * </span> </label>
                   
                        <input type="date" name="VolunteerWebform[volunteer_date]" id="date" placeholder=" DD/MM/YYYY ">
                    </div>
       

                                      
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
                    ])->label(false);
                    ?>

<div class="col-lg-6 col-12 d-flex flex-column gap-2">
                    <?php 
                        $attribute = ($lng === 'ar') ? 'ar_nationality' : 'en_nationality';
                        $countries = Country::find()
                        ->orderBy([$attribute => SORT_ASC])->all();
                        $countriesList = ArrayHelper::map($countries, 'id', $attribute);
                      ?>
                    <?= $form->field($model, 'nationality_id')->dropDownList( $countriesList   , ["prompt" => Yii::t("site", "SELECT_NATIONALITY"), "class" => 'form-select'])
                        ->label(); ?>

                    </div>

                    <div class="col-lg-6 col-12 d-flex flex-column gap-2">
                    <?= $form->field($model, 'gender')->dropDownList($model->getGenderList(), ["prompt" => Yii::t("site", "SELECT_GENDER"), "class" => 'form-select'])
                        ->label(); ?>
                    </div>

                    <div class="col-lg-12 col-12 d-flex flex-column gap-2">
                      <?php 
                        $attribute = ($lng === 'ar') ? 'ar_short_name' : 'en_short_name';
                        $countries = Country::find()
                        ->orderBy([$attribute => SORT_ASC])
                        ->all();
                        $countriesList = ArrayHelper::map($countries, 'id', $attribute);
                      ?>
                    <?= $form->field($model, 'country_id')->dropDownList( $countriesList   , ["prompt" => Yii::t("site", "SELECT_COUNTRY"), "id"=>'country_id' ,"class" => 'form-select'])
                        ->label(); ?>
                    </div>



                    <div class="col-12 d-flex flex-column gap-2">
                      <label for=""> <?= Yii::t('site', 'OCCUPATION') ?>   </label>
                      <div class="payment-method-box">

                      <?php foreach($model->getOccupationTypeList() as $key=> $item) : ?>
                      <div>
                      <label for=""> <?= $item ?> </label>
                          <input
                            type="radio"
                            name="VolunteerWebform[occupation_id]"
                            value="<?= $key ?>"
                          />
                      </div>
         
                      <?php endforeach; ?>


           


        
      
                      </div>
                    </div>
                    <div class="col-12 d-flex flex-column gap-2">

                      <?= $form->field($model, 'university_name')->textInput([  'class' => false, 'maxlength' => true,'placeholder' => Yii::t("site", "VOLUNTEER_UNIVERSITY_NAME")])->label(false); ?>

                    </div>

                    <div class="col-lg-6 col-12 d-flex flex-column gap-2">
                    <?= $form->field($model, 'email')->textInput([  'class' => false, 'maxlength' => true,'placeholder' => Yii::t("site", "VOLUNTEER_EMAIL")])->label(); ?>

                    </div>
                    <div class="col-lg-6 col-12 d-flex flex-column gap-2">
                    <?= $form->field($model, 'volunteer_id')->dropDownList($model->getVolunteersList(), ["prompt" => Yii::t("site", "SELECT_PROGRAM"), "class" => 'form-select'])
                        ->label(); ?>
                    </div>

            
                    <div class="col-12 d-flex flex-column gap-2">
                      <label for=""
                     
                        > <?=  Yii::t('site', 'HAVE_YOU_PARTICIPATED') ?><span>*</span>
                      </label>
                      <div class="payment-method-box">
                      <?php foreach($model->getHaveParticipatedList() as $key=> $item) : ?>
                      <div>
                      <label for=""> <?= $item ?> </label>
                          <input
                            type="radio"
                            name="VolunteerWebform[participated_volunteer_type]"
                            value="<?= $key ?>"
                            id="VolunteerWebform-<?= $key ?>"
                          />
                      </div>
         
                      <?php endforeach; ?>

                               
     
                      </div>
                    </div>

                    <div class="col-12 d-flex flex-column gap-2">
   
                      <?= $form->field($model, 'specify')->textInput([  'class' => false, 'maxlength' => true,'placeholder' => Yii::t("site", "VOLUNTEER_SPECIFY")])->label(false); ?>

                    </div>
                    <div class="col-12 d-flex flex-column gap-2">
      
                 
                      <?= $form->field($model, 'hear_about_volunteer_id')->dropDownList($model->getHearAboutVolunteerTypeList(), ["prompt" => Yii::t("site", "SELECT_HEAR_ABOUT_US"), "class" => 'form-select'])
                        ->label(); ?>

                    </div>
                    <div class="col-12">
                    <?= $form->field($model, 'reCaptcha', [])->widget(\himiklab\yii2\recaptcha\ReCaptcha::className())->label(false); ?>

                    </div>
                    <button type="submit" class="type-4-btn ms-2">
                      <span><?= Yii::t('site', 'SUBMIT')  ?></span>
                    </button>
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
      $('#VolunteerWebform-no').on('click',()=>{
       $('#volunteerwebform-specify').addClass('d-none')
      })
      $('#VolunteerWebform-yes').on('click',()=>{
       $('#volunteerwebform-specify').removeClass('d-none')
      })
   
    });
JS;
$this->registerJs($script);
?>

