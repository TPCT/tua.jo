<?php

use frontend\widgets\HeaderImage;
use borales\extensions\phoneInput\PhoneInput;
use kartik\widgets\DatePicker;
use frontend\assets\RepeaterAsset;
use common\components\custom_base_html\CustomBaseHtml;
use common\helpers\Utility;

use kartik\form\ActiveForm;
RepeaterAsset::register($this);



$this->title = Yii::t('site', 'ZAKAT_CALCULATION');
$this->description = Yii::t('site', 'ZAKAT_CALCULATION_DESCRIPTION');


$this->registerCssFile("/theme/css/ContactUs.css", ['depends' => [\frontend\assets\AppAsset::className()],]);
$this->registerCssFile("/theme/css/FAQs.css", ['depends' => [\frontend\assets\AppAsset::className()],]);
$this->registerCssFile("/theme/css/ZakatCalculator.css", ['depends' => [\frontend\assets\AppAsset::className()],]);

$lng = Yii::$app->language;

?>



<?= HeaderImage::widget(['is_inner'=> true , 'path'=>'/zakat-calculation' ]) ?>

<section class="zakat-calculator contact-us-section my-5">
        <div class="container">
          <div class="row">
            <div class="col-lg-6 mb-4">
    
        
                <div
                  class="d-flex flex-column w-100 align-items-start justify-content-start customize-zakat"
                >

                <?= CustomBaseHtml::hiddenInput('nonce', $GLOBALS['nonce']) ?>

                  <div
                    class="row d-flex align-itemsc-center justify-content-center w-100 px-0 g-4 pt-3 pb-5"
                  >
                    <h3 class="text-center"> <?= Yii::t('site', 'ZAKAT_CALCULATION') ?> </h3>
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                      <li class="nav-item" role="presentation">
                        <button
                          class="nav-link active"
                          id="home-tab"
                          data-bs-toggle="tab"
                          data-bs-target="#home-tab-pane"
                          type="button"
                          role="tab"
                          aria-controls="home-tab-pane"
                          aria-selected="true"
                        >
                        <?= Yii::t('site', 'CASHE') ?>
                        </button>
                      </li>
                      <li class="nav-item" role="presentation">
                        <button
                          class="nav-link"
                          id="profile-tab"
                          data-bs-toggle="tab"
                          data-bs-target="#profile-tab-pane"
                          type="button"
                          role="tab"
                          aria-controls="profile-tab-pane"
                          aria-selected="false"
                        >
                         <?= Yii::t('site', 'GOLD') ?>
                        </button>
                      </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                       
                      <div
                        class="tab-pane fade show active"
                        id="home-tab-pane"
                        role="tabpanel"
                        aria-labelledby="home-tab"
                        tabindex="0"
                      >
                  


                      <?php
                                    $form = \kartik\form\ActiveForm::begin([
                                        'id' => 'zaka-form',
                                        'method' => 'post',
                                        'options'=>[
                                            'class'=>'contact-us-form repeater mb-5',
                          
                                            'data-pjax' => true,
                                        ],
                                        'enableAjaxValidation' => false,
                                        'enableClientValidation' => true,
                                        
                                    ]); 
                                ?>
 
                          <?= $form->field($model, 'type')->hiddenInput(['value'=>$model::HAS_CASH])->label(false) ?>
                  
                        

                        <?= $form->field($model, 'calender')->hiddenInput(['value'=>2])->label(false) ?>

                                   
                   
                        <div
                          class="col-12 d-flex flex-column flex-md-row align-items-center justify-content-between gap-2 mb-3"
                        >
         
                        </div>
                        <div class="row" >
                                                <div class="col-md-12">

                                                    <div class="panel panel-default">
                                                        <div class="panel-heading">
                                                        </div>
                                                        <div class="clearfix"></div>
                                                        <div class="clearfix"></div>


                                                        <div data-repeater-list="ZakaFormDynamicAmoutCurrency">
                                                            <div class="container-items_group" data-repeater-item >
                                                                <?php foreach ($model->cashList as $itemKey => $item): ?>
                                                                    <div class="item_group" pk="<?= $itemKey ?>" >
                                                                        <div class="panel-body">
                                                                            <div class="row">
                                                                                
                                                                                
                                                                                <div class="col-md-11">
                                                                                    <div class="row">

                                                                                        <div class="col-md-6">

                                                                                                                <label for="mobile-number-input" class="m-2"><?=Yii::t('site', 'CURRENCY_LABEL')?> <span class="red-astrik"> *</span></label>
                                                                                            <?= $form->field($item, "[$itemKey]currency_with_cash")->dropDownList( $model->getAllCurrencies(),["prompt"=>Yii::t("site","SELECT_CURRENCY"),"class"=>"fancy-select form-select"])->label(false) ?>
                                                                                        </div>
                                                                                        <div class="col-md-6">
                                                                                        <label for="mobile-number-input" class="m-2"><?=Yii::t('site', 'AMOUNT_LABEL')?> <span class="red-astrik"> *</span></label>

                                                                                            <?= $form->field($item, "[$itemKey]amount")->textInput(['maxlength' => true , 'placeholder' => Yii::t("site", "TYPE_THE_AMOUNT")])->label(false) ?>
                                                                                        </div>
                                                                                        
                                                                                    </div>
                                                                                    
                                                                                </div>

                                                                                <div class="col-md-1">
                                                                                    <div class="allignment">
                                                                                        <button data-repeater-delete pk="<?= $itemKey ?>" class="remove-item_group btn btn-danger btn-xs">
                                                                                            <i class="fas fa-minus"></i>
                                                                                        </button>
                                                                                    </div>
                                                                                </div>
                                                                                
                                                                            </div>

                                                                        </div>
                                                                    </div>

                                            
                                                                <?php $itemKey++; endforeach; ?>
                                                            </div>
                                                        </div>
                                                        <div class="pull-right panel-body mt-4">
                                                            <button data-repeater-create type="button" class="add-item_group btn color-main font-bold ">
                                                                <?= yii::t('site', 'ADD_AMOUNT') ?> <i class="fas fa-plus"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                        <?php \yii\widgets\Pjax::begin(["enablePushState"=>true,'enableReplaceState' => true, 'formSelector'=> '#zaka-form'])  ?>
                          
                        <div  id="items-section">
                          <div id="items-container">
                            <button class="type-4-btn mb-3" type="submit">
                            <span>  <?= Yii::t("site","CALCULATOR") ?> </span>
                          </button>
                          </div>
                        </div>
               

                        <div class="col-12 mb-3">
                          <div
                            class="zakat-value d-flex align-items-center justify-content-between"
                          >
                            <h3> <?= Yii::t("site","TOTLA_ZAKAT_RESULT") ?>  </h3>
                            <h3><?= $result ?? 0 ?> <?= (int)$model->type == 1 ? $model->allCurrencies[(int)$model->currency_with_gold] : Yii::t('site', 'JOD') ?> </h3>
                          </div>
                        </div>
                        <?php \yii\widgets\Pjax::end() ?>

                        <?php \kartik\form\ActiveForm::end(); ?>
                        <?php if($zakatCalculationUrl) : ?>

                        <a class="type-2-btn" href="<?= $zakatCalculationUrl->url ?>" >

                          <svg
                            width="24"
                            height="25"
                            viewBox="0 0 24 25"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                          >
                            <g clip-path="url(#clip0_2559_1896)">
                              <path
                                d="M21.5934 13.7245C21.3482 13.5354 21.067 13.3983 20.7671 13.3215C20.4671 13.2446 20.1547 13.2295 19.8488 13.2773C21.6094 11.4998 22.5 9.73259 22.5 8.00009C22.5 5.51853 20.5041 3.50009 18.0506 3.50009C17.3996 3.496 16.7556 3.63445 16.1638 3.90573C15.5721 4.17701 15.0468 4.57454 14.625 5.0704C14.2032 4.57454 13.6779 4.17701 13.0862 3.90573C12.4944 3.63445 11.8504 3.496 11.1994 3.50009C8.74594 3.50009 6.75 5.51853 6.75 8.00009C6.75 9.03134 7.05375 10.0335 7.69312 11.0938C7.16947 11.2265 6.69158 11.4987 6.31031 11.8813L4.18969 14.0001H1.5C1.10218 14.0001 0.720644 14.1581 0.43934 14.4394C0.158035 14.7207 0 15.1023 0 15.5001L0 19.2501C0 19.6479 0.158035 20.0294 0.43934 20.3107C0.720644 20.5921 1.10218 20.7501 1.5 20.7501H11.25C11.3113 20.7501 11.3724 20.7426 11.4319 20.7276L17.4319 19.2276C17.4701 19.2185 17.5075 19.2059 17.5434 19.1901L21.1875 17.6395L21.2288 17.6207C21.579 17.4457 21.8789 17.1844 22.1002 16.8615C22.3215 16.5385 22.457 16.1646 22.4939 15.7748C22.5307 15.385 22.4678 14.9923 22.3109 14.6336C22.154 14.2749 21.9084 13.962 21.5972 13.7245H21.5934ZM11.1994 5.00009C11.7803 4.99159 12.3505 5.15653 12.8371 5.47384C13.3238 5.79114 13.7047 6.24638 13.9313 6.78134C13.9878 6.9189 14.0839 7.03655 14.2074 7.11935C14.3309 7.20215 14.4763 7.24636 14.625 7.24636C14.7737 7.24636 14.9191 7.20215 15.0426 7.11935C15.1661 7.03655 15.2622 6.9189 15.3187 6.78134C15.5453 6.24638 15.9262 5.79114 16.4129 5.47384C16.8995 5.15653 17.4697 4.99159 18.0506 5.00009C19.6491 5.00009 21 6.37353 21 8.00009C21 9.82915 19.5197 11.8982 16.7194 13.9907L15.6797 14.2298C15.7709 13.8443 15.7738 13.4431 15.6879 13.0564C15.6021 12.6696 15.4298 12.3073 15.1841 11.9966C14.9383 11.6859 14.6254 11.4348 14.2688 11.2622C13.9122 11.0897 13.5212 11 13.125 11.0001H9.43875C8.62969 9.90884 8.25 8.94884 8.25 8.00009C8.25 6.37353 9.60094 5.00009 11.1994 5.00009ZM1.5 15.5001H3.75V19.2501H1.5V15.5001ZM20.5716 16.2698L17.0091 17.7866L11.1562 19.2501H5.25V15.0604L7.37156 12.9398C7.51035 12.7999 7.67555 12.689 7.85758 12.6135C8.03961 12.538 8.23482 12.4995 8.43188 12.5001H13.125C13.4234 12.5001 13.7095 12.6186 13.9205 12.8296C14.1315 13.0406 14.25 13.3267 14.25 13.6251C14.25 13.9235 14.1315 14.2096 13.9205 14.4206C13.7095 14.6316 13.4234 14.7501 13.125 14.7501H10.5C10.3011 14.7501 10.1103 14.8291 9.96967 14.9698C9.82902 15.1104 9.75 15.3012 9.75 15.5001C9.75 15.699 9.82902 15.8898 9.96967 16.0304C10.1103 16.1711 10.3011 16.2501 10.5 16.2501H13.5C13.5565 16.2499 13.6127 16.2436 13.6678 16.2313L19.9491 14.7866L19.9781 14.7791C20.1699 14.7259 20.3745 14.7455 20.5527 14.8341C20.7309 14.9227 20.87 15.074 20.9433 15.259C21.0167 15.444 21.0189 15.6496 20.9498 15.8362C20.8806 16.0228 20.7449 16.1772 20.5687 16.2698H20.5716Z"
                              ></path>
                            </g>
                            <defs>
                              <clipPath id="clip0_2559_1896">
                                <rect
                                  width="24"
                                  height="24"
                                  fill="white"
                                  transform="translate(0 0.5)"
                                ></rect>
                              </clipPath>
                            </defs>
                          </svg>

                          <span> <?= $zakatCalculationUrl->title ?> </span>
                        </a>
                        <?php endif; ?>
                      </div>

                      <div
                        class="tab-pane fade "
                        id="profile-tab-pane"
                        role="tabpanel"
                        aria-labelledby="profile-tab"
                        tabindex="0"
                      >
                      <?php
                                    $form = \kartik\form\ActiveForm::begin([
                                        'id' => 'zaka-form-1',
                                        'method' => 'post',
                                        'options'=>[
                                            'class'=>'contact-us-form mb-5',
                          
                                            'data-pjax' => true,
                                        ],
                                        'enableAjaxValidation' => false,
                                        'enableClientValidation' => true,
                                        
                                    ]); 
                                ?>
                                                          <?= $form->field($model, 'type')->hiddenInput(['value'=>1 , 'id'=>'zakaform-type-gold'])->label(false) ?>


                        <?= $form->field($model, 'calender')->hiddenInput(['value'=>2])->label(false) ?>

                        <div class="col-12 d-flex flex-column gap-2 mb-3">
                        <label for="mobile-number-input"><?=Yii::t('site', 'CURRENCY_LABEL')?> <span class="red-astrik"> *</span></label>

                        <?= $form->field($model, 'currency_with_gold')->dropDownList( $model->allCurrencies,[
                                                            "prompt"=>Yii::t("site","SELECT_CURRENCY"),
                                                        "class"=>"fancy-select form-select"
                                                    ])->label(false) ?>
                        </div>
    
    
   
    
                        <div class="col-12 d-flex flex-column gap-2 mb-3">
                        <label for="mobile-number-input"><?=Yii::t('site', 'WEIGHT_GOLD_24')?> </label>

                        <?= $form->field($model, 'weight_gold_24')->textInput(['placeholder' => Yii::t("site", "WEIGHT_GOLD_24_PLACE_HOLDER") ])->label(
                                                            false
                                                    ) ?>
                        </div>
    
    
    
                        <div class="col-12 d-flex flex-column gap-2 mb-3">
                        <label for="mobile-number-input"><?=Yii::t('site', 'WEIGHT_GOLD_21')?> </label>

                        <?= $form->field($model, 'weight_gold_21')->textInput(['placeholder' => Yii::t("site", "WEIGHT_GOLD_21_PLACE_HOLDER") ])->label(false) ?>
                        </div>
    
                        <div class="col-12 d-flex flex-column gap-2 mb-3">
                        <label for="mobile-number-input"><?=Yii::t('site', 'WEIGHT_GOLD_18')?> </label>

                        <?= $form->field($model, 'weight_gold_18')->textInput(['placeholder' => Yii::t("site", "WEIGHT_GOLD_18_PLACE_HOLDER") ])->label(false ) ?>
                        </div>
         
              
                        <?php \yii\widgets\Pjax::begin(["enablePushState"=>true,'enableReplaceState' => true, 'formSelector'=> '#zaka-form-1'])  ?>

       
                        <button class="type-4-btn mb-3" type="submit">
                            <span>  <?= Yii::t("site","CALCULATOR") ?> </span>
                        </button>

                        <div class="col-12 mb-3">
                          <div
                            class="zakat-value d-flex align-items-center justify-content-between"
                          >
                          <h3> <?= Yii::t("site","TOTLA_ZAKAT_RESULT") ?>  </h3>
                            <h3><?= $result ?? 0 ?> <?= (int)$model->type == 1 ? $model->allCurrencies[(int)$model->currency_with_gold] : Yii::t('site', 'JOD') ?> </h3>
                          </div>
                        </div>
                        <?php \yii\widgets\Pjax::end() ?>

                        <?php \kartik\form\ActiveForm::end(); ?>
                        <?php if($zakatCalculationUrl) : ?>

                        <a class="type-2-btn" href="<?= $zakatCalculationUrl->url ?>" >

                          <svg
                            width="24"
                            height="25"
                            viewBox="0 0 24 25"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                          >
                            <g clip-path="url(#clip0_2559_1896)">
                              <path
                                d="M21.5934 13.7245C21.3482 13.5354 21.067 13.3983 20.7671 13.3215C20.4671 13.2446 20.1547 13.2295 19.8488 13.2773C21.6094 11.4998 22.5 9.73259 22.5 8.00009C22.5 5.51853 20.5041 3.50009 18.0506 3.50009C17.3996 3.496 16.7556 3.63445 16.1638 3.90573C15.5721 4.17701 15.0468 4.57454 14.625 5.0704C14.2032 4.57454 13.6779 4.17701 13.0862 3.90573C12.4944 3.63445 11.8504 3.496 11.1994 3.50009C8.74594 3.50009 6.75 5.51853 6.75 8.00009C6.75 9.03134 7.05375 10.0335 7.69312 11.0938C7.16947 11.2265 6.69158 11.4987 6.31031 11.8813L4.18969 14.0001H1.5C1.10218 14.0001 0.720644 14.1581 0.43934 14.4394C0.158035 14.7207 0 15.1023 0 15.5001L0 19.2501C0 19.6479 0.158035 20.0294 0.43934 20.3107C0.720644 20.5921 1.10218 20.7501 1.5 20.7501H11.25C11.3113 20.7501 11.3724 20.7426 11.4319 20.7276L17.4319 19.2276C17.4701 19.2185 17.5075 19.2059 17.5434 19.1901L21.1875 17.6395L21.2288 17.6207C21.579 17.4457 21.8789 17.1844 22.1002 16.8615C22.3215 16.5385 22.457 16.1646 22.4939 15.7748C22.5307 15.385 22.4678 14.9923 22.3109 14.6336C22.154 14.2749 21.9084 13.962 21.5972 13.7245H21.5934ZM11.1994 5.00009C11.7803 4.99159 12.3505 5.15653 12.8371 5.47384C13.3238 5.79114 13.7047 6.24638 13.9313 6.78134C13.9878 6.9189 14.0839 7.03655 14.2074 7.11935C14.3309 7.20215 14.4763 7.24636 14.625 7.24636C14.7737 7.24636 14.9191 7.20215 15.0426 7.11935C15.1661 7.03655 15.2622 6.9189 15.3187 6.78134C15.5453 6.24638 15.9262 5.79114 16.4129 5.47384C16.8995 5.15653 17.4697 4.99159 18.0506 5.00009C19.6491 5.00009 21 6.37353 21 8.00009C21 9.82915 19.5197 11.8982 16.7194 13.9907L15.6797 14.2298C15.7709 13.8443 15.7738 13.4431 15.6879 13.0564C15.6021 12.6696 15.4298 12.3073 15.1841 11.9966C14.9383 11.6859 14.6254 11.4348 14.2688 11.2622C13.9122 11.0897 13.5212 11 13.125 11.0001H9.43875C8.62969 9.90884 8.25 8.94884 8.25 8.00009C8.25 6.37353 9.60094 5.00009 11.1994 5.00009ZM1.5 15.5001H3.75V19.2501H1.5V15.5001ZM20.5716 16.2698L17.0091 17.7866L11.1562 19.2501H5.25V15.0604L7.37156 12.9398C7.51035 12.7999 7.67555 12.689 7.85758 12.6135C8.03961 12.538 8.23482 12.4995 8.43188 12.5001H13.125C13.4234 12.5001 13.7095 12.6186 13.9205 12.8296C14.1315 13.0406 14.25 13.3267 14.25 13.6251C14.25 13.9235 14.1315 14.2096 13.9205 14.4206C13.7095 14.6316 13.4234 14.7501 13.125 14.7501H10.5C10.3011 14.7501 10.1103 14.8291 9.96967 14.9698C9.82902 15.1104 9.75 15.3012 9.75 15.5001C9.75 15.699 9.82902 15.8898 9.96967 16.0304C10.1103 16.1711 10.3011 16.2501 10.5 16.2501H13.5C13.5565 16.2499 13.6127 16.2436 13.6678 16.2313L19.9491 14.7866L19.9781 14.7791C20.1699 14.7259 20.3745 14.7455 20.5527 14.8341C20.7309 14.9227 20.87 15.074 20.9433 15.259C21.0167 15.444 21.0189 15.6496 20.9498 15.8362C20.8806 16.0228 20.7449 16.1772 20.5687 16.2698H20.5716Z"
                              ></path>
                            </g>
                            <defs>
                              <clipPath id="clip0_2559_1896">
                                <rect
                                  width="24"
                                  height="24"
                                  fill="white"
                                  transform="translate(0 0.5)"
                                ></rect>
                              </clipPath>
                            </defs>
                          </svg>

                          <span> <?= $zakatCalculationUrl->title ?> </span>
                        </a>
                        <?php endif; ?>

                      </div>


                    </div>
                  </div>
                </div>
           
              <div class="for-money d-flex flex-column gap-2 p-3">
                <h3><?=Yii::t('site','FOR_MONEY') ?> </h3>
                <p>
                <?=Yii::t('site','FOR_MONEY_BRIEF') ?>
                </p>
              </div>
            </div>
            <div class="col-lg-6 mb-4 nisab-fatwa-container">
            <?php if($calculationSections): ?>
            <?php foreach ($calculationSections as $key => $calculationSection): ?>

              <div class="current d-flex align-items-center gap-3 mb-4">
    
                <?= \frontend\widgets\WebpImage::widget(["src" => $calculationSection->image, "alt" => $calculationSection->title, "loading" => "lazy", 'css' => "mw-100 w-100"]) ?>

                <div class="current-content">
                  <h3 class="m-0"><?= $calculationSection->title ?></h3>
                  <?php if($calculationSection->button_text): ?>
                  <a  href="<?= $calculationSection->button_image_1; ?>" target="_blank" >
                    <h3 class="m-0"> <?= $calculationSection->button_text ?>  </h3>
                  </a>
                  <?php else: ?>

                  <h3 class="m-0"> <?= $calculationSection->second_title ?>  </h3>
                  <?php endif; ?>

                </div>
              </div>
              <?php endforeach; ?>

              <?php endif; ?>


              <h3> <?= Yii::t('site','FAQS_ABOUT_ZAKAT') ?> </h3>
              <div class="faqs-section">
                <div
                  class="accordion accordion-flush custom-accordion"
                  id="faqsFlushExample"
                >
                  <div class="Faqs-acc-splited-div">
                  <?php if($calculationFaqSections): ?>
                  <?php foreach ($calculationFaqSections as $key => $calculationFaqSection): ?>

                    <div class="accordion-item">
                      <h2 class="accordion-header" id="flush-heading<?= $calculationFaqSection->slug ?>">
                        <button
                          class="accordion-button collapsed"
                          type="button"
                          data-bs-toggle="collapse"
                          data-bs-target="#flush-collapse<?= $calculationFaqSection->slug ?>"
                          aria-expanded="false"
                          aria-controls="flush-collapse<?= $calculationFaqSection->slug ?>"
                        >
                          <?= $calculationFaqSection->title ?>
                          <span class="accordion-btn">
                            <i class="fa-solid fa-plus"></i>
                            <i class="fa-solid fa-minus"></i>
                          </span>
                        </button>
                      </h2>
                      <div
                        id="flush-collapse<?= $calculationFaqSection->slug ?>"
                        class="accordion-collapse collapse"
                        aria-labelledby="flush-heading<?= $calculationFaqSection->slug ?>"
                        data-bs-parent="#faqsFlushExample"
                      >
                        <div class="accordion-body">
                        <?= $calculationFaqSection->content ?>
                        </div>
                      </div>
                    </div>
    
                    <?php endforeach; ?>

                    <?php endif; ?>

         
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>





