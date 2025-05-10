<?php

use frontend\widgets\HeaderImage;
use borales\extensions\phoneInput\PhoneInput;
use yeesoft\helpers\Html;
use yii\helpers\Url;
use common\components\TuaClient;



use kartik\form\ActiveForm;



$this->title = Yii::t('site', 'COMPLAINT');
$this->description = Yii::t('site', 'COMPLAINT_DESCRIPTION');


$this->registerCssFile("/theme/css/ContactUs.css", ['depends' => [\frontend\assets\AppAsset::className()],]);
$this->registerCssFile("/theme/css/Complaints.css", ['depends' => [\frontend\assets\AppAsset::className()],]);

$lng = Yii::$app->language;

?>






<?= HeaderImage::widget(['is_inner'=> true , 'path'=>'/contact-us/complaint' ]) ?>





<section class="contact-us-section py-5">
        <div class="container">
          <div class="row align-items-center">
            <div class="col-lg-6 ">
              <h3> <?= Yii::t('site', 'COMPLAINT_UNIT_TITLE') ?> </h3>
              <h5 class="mb-4 Complaints-intro">
              <?= Yii::t('site', 'COMPLAINT_UNIT_BRIEF') ?> 
              </h5>

              <?php $form = \kartik\form\ActiveForm::begin([
                    //'action' => ['site/news'],
                    'id' => 'contact-form',
                    'method' => 'post',
                    'options' => [
                        'class' => 'customize-recaptcha contact-us-form',
                    ],
                    //'enableAjaxValidation' => true,
                    //'enableClientValidation' => true,
                ]);
                ?>

                <div
                  class="d-flex flex-column w-100 align-items-start justify-content-start"
                >
                  <div class="row w-100 px-0 g-4 pt-3 pb-5">
                    <p>*
                    <?= Yii::t('site', 'FIELDS_MARKED_WITH_ASTERISK') ?> 

                    </p>
                    <?php if (Yii::$app->session->hasFlash('success')) : ?>
                      <div class="alert alert-success alert-dismissable">
                        <button aria-hidden="true" data-bs-dismiss="alert" class="close btn" type="button">×</button>
                        <?= Yii::$app->session->getFlash('success')[0] ?>
                    </div>
                  <?php endif; ?>

                    <div class="col-lg-6 col-12 d-flex flex-column gap-2">
                      <label for=""> <?= Yii::t('site','SELECT_SERVEY') ?> </label>
                    <select name="ComplaintWebform[survey_type]" class="form-select form-control" id="">
                    <option > <?= Yii::t('site', 'SELECT_OPTION' ) ?> </option>
                    <?php foreach (array_keys(TuaClient::CompliantType) as $index => $key) : ?>
                      <option value="<?= $key ?>" > <?= Yii::t('site', TuaClient::CompliantType[$key]) ?> </option>
                    <?php endforeach; ?>

                      
                    </select>


            

                    </div>
                    <div class="col-lg-6 col-12 d-flex flex-column gap-2">
                    <?= $form->field($model, 'name')->textInput([  'class' => false, 'maxlength' => true,'placeholder' => Yii::t("site", "SENDER_NAME")])->label(); ?>

                    </div>
                    <div class="col-lg-6 col-12 d-flex flex-column gap-2">
                      
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
                    <?= $form->field($model, 'email')->textInput([  'class' => false, 'maxlength' => true,'placeholder' => Yii::t("site", "EMAIL")])->label(); ?>

                    </div>
                    <div class="col-12 d-flex flex-column gap-2">
                      <?= $form->field($model, 'message')->textarea([ 'maxlength' => true, 'id' => "exampleFormControlTextarea1", 'placeholder' => Yii::t("site", "TYPE_HERE"), 'rows' => 5])->label() ?>

                    </div>
                    <div class="col-12">
                      <p for=""> <?=  Yii::t('site', 'PREFERRED_METHOD_TO_CONTACT') ?> </p>

                      <div class="d-flex flex-column flex-md-row gap-4 mt-2 Complaints-radio-box flex-wrap ">
  
       
      
                      <div class="form-check">
                          <input
                            class="form-check-input"
                            type="checkbox"
                            value="1"
                            name="ComplaintWebform[by_phone]"
                            id="flexRadioDefault3"
                    
                          />
                          <label
                            class="form-check-label"
                            for="flexRadioDefault3"
                          >
                           <?= Yii::t('site', 'BY_PHONE') ?>
                          </label>
                        </div>
       
      
                      <div class="form-check">
                          <input
                            class="form-check-input"
                            type="checkbox"
                            value="1"
                            name="ComplaintWebform[by_email]"
                            id="flexRadioDefault3"
                      
                          />
                          <label
                            class="form-check-label"
                            for="flexRadioDefault3"
                          >
                          <?= Yii::t('site', 'BY_EMAIL') ?>
                          </label>
                        </div>
       
      
                      <div class="form-check">
                          <input
                            class="form-check-input"
                            type="checkbox"
                            value="1"
                            name="ComplaintWebform[prefer_not_to_communicate]"
                            id="flexRadioDefault3"
                       
                          />
                          <label
                            class="form-check-label"
                            for="flexRadioDefault3"
                          >
                          <?= Yii::t('site', 'PREFER_NOT_TO_COMMUNICATE') ?>
                          </label>
                        </div>


                      </div>
                    </div>
                    <div class="col-12 d-flex flex-column gap-2">
                    <?= $form->field($model, 'another_way')->textInput([  'class' => false, 'maxlength' => true,'placeholder' => Yii::t("site", "ANOTHER_WAY")])->label(false); ?>

                    </div>
                    <div class="col-12">
                    <?= $form->field($model, 'reCaptcha', [])->widget(\himiklab\yii2\recaptcha\ReCaptcha::className())->label(false); ?>

                    </div>
     
                    <button type="submit" class="type-4-btn ms-2" >
                    <span><?= Yii::t('site', 'SUBMIT')  ?> </span>
                    </button>
                  </div>
                </div>
                      <?php ActiveForm::end(); ?>

            </div>
            <div class="col-lg-6  d-flex align-items-center">
              <div class="contact-us-info">
              <?php if($complaintRightSection): ?>

                <div class="head-contact-us-info">
                  <h3> <?= $complaintRightSection->title ?> </h3>
                  <h2><?= $complaintRightSection->second_title ?> </h2>
                    <h5>
                    <?= $complaintRightSection->brief ?> 
                    </h5>
                </div>
                <?php endif; ?>

                <div class="contact-us-communication mt-5">
                  <div class="contact-us-communication-card">
                    <div class="card-communication d-flex gap-3">
                      <picture>
                        <img
                          src="/theme/assets/Icons/Headset white.svg"
                          alt=""
                          class="mw-100 w-100"
                        />
                      </picture>
                      <div class="communication-content">
                        <h4><?= Yii::t('site', 'PHONE')  ?></h4>
                        <h5 class="phone-number"> <?= Yii::$app->settings->get('site.phone') ?></h5>
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
                        
                        <h4><?= Yii::t('site', 'CMPLAINT_OEMAIL')  ?></h4>
                        <h5>  <?= Yii::$app->settings->get('site.complaint_page_email') ?> </h5>
                        <a href="mailto:<?= Yii::$app->settings->get('site.complaint_page_email') ?> " class="type-4-btn mt-3"><span>  <?= Yii::t('site', 'SEND_EMAIL')  ?>  </span></a>

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
                      <a href="<?= Yii::$app->settings->get('site.address_url') ?>" class="type-4-btn mt-3"><span> <?= Yii::t('site', 'GET_DIRECTION')  ?>  </span></a>
                      </div>
                    </div>
                  </div>
                  <div class="contact-us-communication-card">
                    <div class="card-communication d-flex gap-3">
                      <picture>
                      <img src="/theme/assets/Icons/complaints-form.svg" alt="" class="mw-100 w-100" />
                      </picture>
                      <div class="communication-content">
                        <h4><?=  Yii::t('site', 'COMPLAINT_TITLE')  ?></h4>
                        <h5><?=  Yii::t('site', 'COMPLAINT_BRIEF')  ?>.</h5>
                        <a href="<?= Url::to(['/contact-us']); ?>" class="type-4-btn mt-3"
                          ><span> <?= Yii::t('site', 'KNOW_MORE')  ?></span></a
                        >
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>








