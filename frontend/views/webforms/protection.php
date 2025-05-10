<?php

use frontend\widgets\HeaderImage;
use borales\extensions\phoneInput\PhoneInput;
use kartik\widgets\DatePicker;

use kartik\form\ActiveForm;


$this->title = Yii::t('site', 'PROTECTION');
$this->description = Yii::t('site', 'PROTECTION_DESCRIPTION');

$this->registerCssFile("/theme/css/protection-from-exploitation-and-abuse.css", ['depends' => [\frontend\assets\AppAsset::className()],]);

$lng = Yii::$app->language;

?>



<?= HeaderImage::widget(['is_inner'=> true , 'path'=>'/protection' ]) ?>







<section class="protection-main-section">
<?php if($protectionFirstSection): ?>

        <div class="container centerd-section-topic">
            <h3> <?= $protectionFirstSection->title ?></h3>
            <?= $protectionFirstSection->content ?>
        </div>
        
        <?php endif; ?>

   
        
        <div>
          <div class="container">
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
                        'class' => 'contact-us-form',
                    ],
                    //'enableAjaxValidation' => true,
                    //'enableClientValidation' => true,
                ]);
                ?>
              <ul>
                <li> <?= Yii::t("site", "FILL_OUT_THE_FORM") ?> </li>
                <li> <?= Yii::t("site", "SUBMIITE_THE_FORM") ?></li>
              </ul>
                <div class="d-flex flex-column w-100  align-items-start justify-content-start">
                  <div class="row w-100 px-0 g-4 pt-3 pb-5">
                    <h4> 1- <?= Yii::t("site", "YOUR_INFORMATION") ?>  <span><?= Yii::t("site", "OPTIONAL") ?></span></h4>
                    <div class="col-lg-6 col-12 d-flex flex-column gap-3">

                      <?= $form->field($model, 'name')->textInput([  'class' => false, 'maxlength' => true,'placeholder' => Yii::t("site", "PROTECTION_NAME")])->label(); ?>

                    </div>
                    <div class="col-lg-6 col-12 d-flex flex-column gap-3">
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
                    <div class="col-lg-6 col-12 d-flex flex-column gap-3">

                      <?= $form->field($model, 'email')->textInput([  'class' => false, 'maxlength' => true,'placeholder' => Yii::t("site", "EMAIL")])->label(); ?>

                    </div>
                    <div class="col-lg-6 col-12 d-flex flex-column gap-3">

                    <?= $form->field($model, 'contact_method_id')->dropDownList($model->getProtectionContactMethodList(), ["prompt" => Yii::t("site", "PURPOSE_OF_CONTACT"), "class" => 'form-select'])
                        ->label(); ?>
                    </div>
                    <h4>2- <?= Yii::t("site", "INCIDENT_DETAIL") ?>  </h4>
                    <div class="col-lg-6 col-12 d-flex flex-column gap-3">
                      <label for="date">  <?= Yii::t("site", "DATE_OF_INCIDEN") ?> <span class="red-astrik"> * </span> </label>
                   
                      <input type="date" name="ProtectionWebform[inciden_date]" id="date" placeholder=" DD/MM/YYYY ">
                      <?php $form->field($model, 'inciden_date')->widget(DatePicker::classname(), [
                                            'options' => [
                                                'class' => '',
                                                'placeholder' => 'yyyy-mm-dd',
                                            ],
                                            'pluginOptions' => [
                                                'format' => 'yyyy-mm-dd',
                                                'autoclose' => true
                                            ],
                                            'type' => DatePicker::TYPE_INPUT,
                                        ])->label(); ?>

                    </div>
                    <div class="col-lg-6 col-12 d-flex flex-column gap-3">
                      <label for="date">  <?= Yii::t("site", "LOCATION_OF_INCIDEN") ?> <span class="red-astrik"> * </span> </label>

                      <?= $form->field($model, 'location')->textInput([  'class' => false, 'maxlength' => true,'placeholder' => Yii::t("site", "LOCATION_PLACEHOLDER")])->label(false); ?>

                    </div>
                    <div class=" col-12 d-flex flex-column gap-3">

                      <?= $form->field($model, 'description')->textarea([ 'maxlength' => true, 'id' => "exampleFormControlTextarea1", 'placeholder' => Yii::t("site", "TYPE_HERE"), 'rows' => 5])->label() ?>

                    </div>
                    <h4>3- <?= Yii::t("site", "SURVIVOR_INFORMATION") ?> </h4>
                    <div class="col-lg-6 col-12 d-flex flex-column gap-3">
                      <label for="name">  <?=  Yii::t("site", "NAME") ?> <span class="optional"> (<?= Yii::t('site','OPTIONAL') ?>) </span> </label>

                      <?= $form->field($model, 'survivor_name')->textInput([  'class' => false, 'maxlength' => true,'placeholder' => Yii::t("site", "SURVIVOR_NAME")])->label(false); ?>

                    </div>
                    <div class="col-lg-6 col-12 d-flex flex-column gap-3">
                      <label for="name"> <?=  Yii::t("site", "POSITION_ORGANIZATION") ?> <span class="optional"> (<?= Yii::t('site','OPTIONAL') ?>) </span> </label>
                      <?= $form->field($model, 'survivor_position')->textInput([  'class' => false, 'maxlength' => true,'placeholder' => Yii::t("site", "SURVIVOR_POSITION")])->label(false); ?>

                    </div>
                    <h4> 4- <?= Yii::t("site", "ALLEGED_PREPETRATOR") ?>  <span>( <?= Yii::t("site", "IF_KNOWN") ?>)</span> </h4>
                    <div class="col-lg-6 col-12 d-flex flex-column gap-3">
                      <label for="name">  <?=  Yii::t("site", "ALLEGED_NAME_LABEL") ?><span class="optional"> (<?= Yii::t("site", "OPTIONAL") ?>) </span> </label>

                      <?= $form->field($model, 'alleged_name')->textInput([  'class' => false, 'maxlength' => true,'placeholder' => Yii::t("site", "ALLEGED_NAME_PLACEHOLDER")])->label(false); ?>

                    </div>
                    <div class="col-lg-6 col-12 d-flex flex-column gap-3">
                      <label for="name"> <?=  Yii::t("site", "POSITION_ORGANIZATION") ?> <span class="optional"> (<?= Yii::t("site", "OPTIONAL") ?>) </span> </label>

                      <?= $form->field($model, 'alleged_position')->textInput([  'class' => false, 'maxlength' => true,'placeholder' => Yii::t("site", "ALLEGED_POSITION_PLACEHOLDER")])->label(false); ?>

                    </div>
                    <h4>5-  <?=  Yii::t("site", "WITNESSES") ?> : <span>(<?= Yii::t("site", "IF_ANY") ?>)</span></h4>
                    <div class="col-lg-12 col-12 d-flex flex-column gap-3">
                      <label for="name">  <?=  Yii::t("site", "WITNESSES_NAME") ?><span class="optional"> (<?= Yii::t("site", "OPTIONAL") ?>) </span> </label>

                      <?= $form->field($model, 'witness_name')->textInput([  'class' => false, 'maxlength' => true,'placeholder' => Yii::t("site", "WITNESS_NAME")])->label(false); ?>

                    </div>
                    <div class=" col-12 d-flex flex-column gap-3">

                    <?= $form->field($model, 'additional_information')->textarea([ 'maxlength' => true, 'id' => "exampleFormControlTextarea2", 'placeholder' => Yii::t("site", "TYPE_HERE"), 'rows' => 5])->label() ?>

                    </div>
                  </div>
                </div>

                <div class="d-flex flex-column gap-2 col-12 mt-2">
                                    <?= $form->field($model, 'reCaptcha', [])->widget(\himiklab\yii2\recaptcha\ReCaptcha::className())->label(false); ?>
                                </div>

                                <button class="type-4-btn m-auto mt-3">
                            <span> <?= Yii::t('site', 'SUBMITE')  ?>  </span>
                        </button>

                <?php ActiveForm::end(); ?>
          </div>
        </div>
    </section>





