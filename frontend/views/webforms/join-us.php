<?php

use frontend\widgets\HeaderImage;
use borales\extensions\phoneInput\PhoneInput;
use kartik\form\ActiveForm;



$this->title = Yii::t('site', 'JOIN_US');
$this->description = Yii::t('site', 'JOIN_US_DESCRIPTION');

$this->registerCssFile("/theme/css/join-us.css", ['depends' => [\frontend\assets\AppAsset::className()],]);

$lng = Yii::$app->language;

?>






<?= HeaderImage::widget(['is_inner'=> true , 'path'=>'/join-us' ]) ?>


<section>
        <div class="container join-us-topic">
            <h3> <?= Yii::t('site', 'JOIN_US_TITLE') ?>  </h3>
            <p><?= Yii::t('site', 'JOIN_US_BRIEF') ?> <p>

            <?php if (Yii::$app->session->hasFlash('success')) : ?>
              <div class="alert alert-success alert-dismissable">
                  <button aria-hidden="true" data-bs-dismiss="alert" class="close btn" type="button">×</button>
                  <?= Yii::$app->session->getFlash('success')[0] ?>
              </div>
              <?php endif; ?>
        </div>

        <div class="container join-us-form mb-5">

            <?php $form = \kartik\form\ActiveForm::begin([
                                //'action' => ['site/news'],
                                'id' => 'contact-form',
                                'method' => 'post',
                                'options' => [
                                    'class' => 'row d-flex contact-us-form',
                                ],
                                //'enableAjaxValidation' => true,
                                //'enableClientValidation' => true,
                            ]);
                            ?>

                <div class="col-lg-4 col-12 d-flex flex-column gap-1 mt-4">

                    <?= $form->field($model, 'name')->textInput([ 'maxlength' => true,'placeholder' => Yii::t("site", "DONOR_NAME")])->label(); ?>

                  </div>
                  <div class="col-lg-4 col-12 d-flex flex-column gap-1 mt-4">

                  

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
                           // 'id'=>'mobile-number-input'
                        ],
                    ])->label();
                    ?>

                  </div>
                  <div class="col-lg-4 col-12 d-flex flex-column gap-1 mt-4">

                    <?= $form->field($model, 'email')->textInput([ 'maxlength' => true,'placeholder' => Yii::t("site", "EMAIL_PLACE_HOLDER")])->label(); ?>

                  </div>
                  <div class="col-lg-4 col-12 d-flex flex-column gap-1 mt-4">

                    <?= $form->field($model, 'qualification')->textInput([ 'maxlength' => true,'placeholder' => Yii::t("site", "ENTER_QUALIFICTION")])->label(); ?>

                  </div>
                  <div class="col-lg-4 col-12 d-flex flex-column gap-1 mt-4">

                    <?= $form->field($model, 'scientific_expertise')->textInput([ 'maxlength' => true,'placeholder' => Yii::t("site", "SCIENTIFIC_EXPERTICE")])->label(); ?>

                  </div>
                  <div class="col-lg-4 col-12 d-flex flex-column gap-1 mt-4">
                    <?= $form->field($model, 'experience_year')->textInput([ 'maxlength' => true,'placeholder' => Yii::t("site", "ENTER_YOUR_SCIENTIFIC_YEAR")])->label(); ?>

                  </div>







                  <div class="col-12 d-flex flex-column gap-1 mt-4">
                    <label for="cv" class="form-label"><?= Yii::t('site', 'CV') ?><span class="red-astrik">*</span></label>
                    <div
                      class="cv-upload-input"
                    >
            



                      <label for="cv" class="upload-label" style="cursor: pointer;">
                        <picture>
                            <img src="/theme/assets/Icons/UploadSimple.svg" alt="">
                        </picture>
                        <p> <?= Yii::t('site', 'DROP_YOUR_CV_HERE') ?> </p>
                        <span> <?= Yii::t('site', 'MAXIMUM_UPLOAD') ?> </span>

                        <span class="file-name-display d-block">  </span>

                      </label>
                      <?= $form->field($model, 'cv')->fileInput([
    'id' => 'cv',
    'class' => 'd-none custom-file-input', // Prevent Yii2 from adding 'form-control'
    'accept' => '.jpg, .png, .pdf, .doc, .docx'
])->label(false); ?>
                    </div>
                  </div>
                  <div class=" col-12 d-flex flex-column gap-1 mt-4">
                  <div class="d-flex flex-column gap-2 col-12 mt-2">
                                    <?= $form->field($model, 'reCaptcha', [])->widget(\himiklab\yii2\recaptcha\ReCaptcha::className())->label(false); ?>
                                </div>

                        <button class="type-4-btn m-auto mt-3">
                            <span> <?= Yii::t('site', 'SUBMITE')  ?>  </span>
                        </button>
                      </div>
                      <?php ActiveForm::end(); ?>
            
        </div>
    </section>