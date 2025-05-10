<?php

use yii\helpers\Url;
use kartik\form\ActiveForm;
use frontend\widgets\HeaderImage;
use frontend\widgets\breadcrumbs\BreadCrumbs;
use borales\extensions\phoneInput\PhoneInput;

$this->registerCssFile("/theme/css/ecard-step-1.css", ['depends' => [\frontend\assets\AppAsset::className()],]);
$this->registerCssFile("/theme/css/donate-gift-step-1.css", ['depends' => [\frontend\assets\AppAsset::className()],]);

$this->title = Yii::t('site', 'E_CARD_STEP_1_TITLE');
$this->description = Yii::t('site', 'E_CARD_STEP_1_TITLE_DESCRIPTION');


$lng = Yii::$app->language;
?>

<section class="ecard-main">
      <div class=" container d-flex flex-column align-items-start justify-content-start">
      <?= BreadCrumbs::widget(['is_inner'=> false , 'bread_crumb_slug'=>  'step-two',  ]) ?>

        <div class=" ecard-main-container">
          <div class="ecard-header">
            <div class="ecard-header-item e-card-passed-step">
              <div class="ecard-main-icon">
                <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <g clip-path="url(#clip0_1707_29752)">
                    <path
                      d="M21.4888 3.59599C20.8081 2.9144 19.7028 2.91483 19.0212 3.59599L7.91531 14.7023L2.97922 9.76627C2.29763 9.08468 1.19278 9.08468 0.511193 9.76627C-0.170398 10.4479 -0.170398 11.5527 0.511193 12.2343L6.68104 18.4041C7.02162 18.7447 7.46821 18.9154 7.91484 18.9154C8.36147 18.9154 8.80849 18.7452 9.14907 18.4041L21.4888 6.06398C22.1704 5.38286 22.1704 4.27754 21.4888 3.59599Z" />
                  </g>
                  <defs>
                    <clipPath id="clip0_1707_29752">
                      <rect width="22" height="22" />
                    </clipPath>
                  </defs>
                </svg>
              </div>
              <div class="ecard-header-item-content">
                <h5> <?= Yii::t('site', 'E_CARD_STEP_1_TITLE') ?> </h5>
                <p> <?= $amount ?> <?= Yii::t('site', 'JOD') ?> </p>

              </div>
            </div>
            <div class="ecard-header-item e-card-recent-step">
              <div class="ecard-main-icon">
                <svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M4.6802 8.93918C5.21951 8.93866 5.74657 8.77826 6.19475 8.47826C6.64293 8.17826 6.9921 7.75212 7.19813 7.25371C7.40416 6.75529 7.4578 6.20699 7.35227 5.67809C7.24674 5.1492 6.98678 4.66347 6.60524 4.28229C6.2237 3.90112 5.73772 3.64162 5.20873 3.53659C4.67974 3.43157 4.13148 3.48573 3.63327 3.69224C3.13505 3.89874 2.70924 4.24832 2.40967 4.69678C2.11009 5.14525 1.9502 5.67246 1.9502 6.21177C1.95088 6.93537 2.23881 7.62908 2.75071 8.1405C3.26261 8.65191 3.9566 8.93918 4.6802 8.93918ZM4.6802 4.77917C4.96251 4.77917 5.23848 4.86289 5.47322 5.01973C5.70795 5.17658 5.8909 5.39951 5.99894 5.66033C6.10698 5.92116 6.13525 6.20816 6.08017 6.48505C6.02509 6.76194 5.88915 7.01627 5.68952 7.2159C5.48989 7.41552 5.23556 7.55147 4.95867 7.60655C4.68178 7.66162 4.39478 7.63336 4.13395 7.52532C3.87313 7.41728 3.6502 7.23433 3.49336 6.9996C3.33651 6.76486 3.2528 6.48889 3.2528 6.20658C3.25417 5.82891 3.40516 5.46718 3.67271 5.20061C3.94025 4.93404 4.30252 4.78437 4.6802 4.78437V4.77917Z" />
                  <path
                    d="M22.0454 3.85352H10.3454C9.81401 3.85421 9.30453 4.06563 8.92874 4.44142C8.55295 4.8172 8.34154 5.32668 8.34085 5.85812V6.56272C8.33947 6.82762 8.39055 7.09018 8.49113 7.33524C8.59171 7.58031 8.73981 7.80304 8.92688 7.9906C9.11396 8.17816 9.33631 8.32683 9.58112 8.42804C9.82592 8.52926 10.0883 8.58101 10.3532 8.58032H22.0532C22.5851 8.57963 23.095 8.36786 23.4709 7.99151C23.8467 7.61516 24.0578 7.10501 24.0578 6.57312V5.85812C24.0575 5.59431 24.0052 5.33316 23.9038 5.0896C23.8025 4.84603 23.6541 4.62484 23.4672 4.43866C23.2803 4.25248 23.0585 4.10497 22.8146 4.00457C22.5706 3.90417 22.3093 3.85284 22.0454 3.85352ZM22.75 6.56272C22.7514 6.65625 22.7342 6.74911 22.6995 6.83595C22.6647 6.92278 22.6131 7.00186 22.5475 7.0686C22.482 7.13534 22.4039 7.18842 22.3177 7.22476C22.2315 7.2611 22.139 7.27999 22.0454 7.28032H10.3454C10.1583 7.27963 9.97912 7.20482 9.84706 7.07227C9.715 6.93972 9.64085 6.76023 9.64085 6.57312V5.85812C9.64153 5.67146 9.71599 5.49264 9.84798 5.36065C9.97997 5.22866 10.1588 5.15421 10.3454 5.15352H22.0454C22.2321 5.15421 22.4109 5.22866 22.5429 5.36065C22.6749 5.49264 22.7494 5.67146 22.75 5.85812V6.56272Z" />
                  <path
                    d="M4.6802 15.7273C5.21951 15.7267 5.74657 15.5664 6.19475 15.2663C6.64293 14.9663 6.9921 14.5402 7.19813 14.0418C7.40416 13.5434 7.4578 12.9951 7.35227 12.4662C7.24674 11.9373 6.98678 11.4516 6.60524 11.0704C6.2237 10.6892 5.73772 10.4297 5.20873 10.3247C4.67974 10.2197 4.13148 10.2738 3.63327 10.4803C3.13505 10.6868 2.70924 11.0364 2.40967 11.4849C2.11009 11.9333 1.9502 12.4605 1.9502 12.9999C1.9502 13.3582 2.02083 13.7131 2.15805 14.0442C2.29528 14.3753 2.49641 14.676 2.74995 14.9293C3.00349 15.1826 3.30446 15.3835 3.63567 15.5204C3.96687 15.6573 4.32181 15.7276 4.6802 15.7273ZM4.6802 11.5673C4.96218 11.5678 5.23769 11.6518 5.47196 11.8087C5.70624 11.9657 5.88879 12.1885 5.99658 12.449C6.10437 12.7096 6.13257 12.9962 6.07762 13.2728C6.02267 13.5494 5.88704 13.8035 5.68783 14.0031C5.48862 14.2026 5.23476 14.3387 4.95829 14.3942C4.68181 14.4496 4.39511 14.422 4.13435 14.3146C3.87359 14.2073 3.65045 14.0252 3.4931 13.7912C3.33575 13.5572 3.25122 13.2818 3.2502 12.9999C3.2502 12.8122 3.2872 12.6264 3.3591 12.453C3.43099 12.2797 3.53637 12.1222 3.66919 11.9896C3.80201 11.857 3.95967 11.7519 4.13315 11.6804C4.30664 11.6088 4.49253 11.5721 4.6802 11.5725V11.5673Z" />
                  <path
                    d="M22.0454 10.6416H10.3454C9.81353 10.6423 9.30366 10.8541 8.9278 11.2304C8.55194 11.6068 8.34082 12.1169 8.34082 12.6488V13.3508C8.34082 13.8827 8.55194 14.3928 8.9278 14.7692C9.30366 15.1455 9.81353 15.3573 10.3454 15.358H22.0454C22.5773 15.3573 23.0872 15.1455 23.463 14.7692C23.8389 14.3928 24.05 13.8827 24.05 13.3508V12.6488C24.05 12.1169 23.8389 11.6068 23.463 11.2304C23.0872 10.8541 22.5773 10.6423 22.0454 10.6416ZM22.75 13.3508C22.75 13.5379 22.6759 13.7174 22.5438 13.8499C22.4117 13.9825 22.2325 14.0573 22.0454 14.058H10.3454C10.1583 14.0573 9.9791 13.9825 9.84703 13.8499C9.71497 13.7174 9.64082 13.5379 9.64082 13.3508V12.6488C9.64082 12.4617 9.71497 12.2822 9.84703 12.1497C9.9791 12.0171 10.1583 11.9423 10.3454 11.9416H22.0454C22.2325 11.9423 22.4117 12.0171 22.5438 12.1497C22.6759 12.2822 22.75 12.4617 22.75 12.6488V13.3508Z" />
                  <path
                    d="M4.6802 22.5163C5.21951 22.5158 5.74657 22.3554 6.19475 22.0554C6.64293 21.7554 6.9921 21.3293 7.19813 20.8309C7.40416 20.3324 7.4578 19.7841 7.35227 19.2552C7.24674 18.7263 6.98678 18.2406 6.60524 17.8594C6.2237 17.4783 5.73772 17.2188 5.20873 17.1137C4.67974 17.0087 4.13148 17.0629 3.63327 17.2694C3.13505 17.4759 2.70924 17.8255 2.40967 18.2739C2.11009 18.7224 1.9502 19.2496 1.9502 19.7889C1.9502 20.1473 2.02083 20.5022 2.15805 20.8333C2.29528 21.1643 2.49641 21.4651 2.74995 21.7184C3.00349 21.9717 3.30446 22.1725 3.63567 22.3095C3.96687 22.4464 4.32181 22.5167 4.6802 22.5163ZM4.6802 18.3563C4.96251 18.3563 5.23848 18.44 5.47322 18.5969C5.70795 18.7537 5.8909 18.9767 5.99894 19.2375C6.10698 19.4983 6.13525 19.7853 6.08017 20.0622C6.02509 20.3391 5.88915 20.5934 5.68952 20.793C5.48989 20.9927 5.23556 21.1286 4.95867 21.1837C4.68178 21.2388 4.39478 21.2105 4.13395 21.1025C3.87313 20.9944 3.6502 20.8115 3.49336 20.5767C3.33651 20.342 3.2528 20.066 3.2528 19.7837C3.25417 19.4061 3.40516 19.0443 3.67271 18.7778C3.94025 18.5112 4.30252 18.3615 4.6802 18.3615V18.3563Z" />
                  <path
                    d="M22.0454 17.4199H10.3454C9.81353 17.4206 9.30366 17.6324 8.9278 18.0087C8.55194 18.3851 8.34082 18.8952 8.34082 19.4271V20.1317C8.34151 20.6632 8.55293 21.1726 8.92871 21.5484C9.3045 21.9242 9.81398 22.1356 10.3454 22.1363H22.0454C22.5769 22.1356 23.0863 21.9242 23.4621 21.5484C23.8379 21.1726 24.0493 20.6632 24.05 20.1317V19.4375C24.0514 19.1733 24.0006 18.9114 23.9005 18.6668C23.8004 18.4222 23.653 18.1999 23.4667 18.0124C23.2805 17.825 23.0591 17.6761 22.8152 17.5744C22.5712 17.4728 22.3097 17.4203 22.0454 17.4199ZM22.75 20.1421C22.7493 20.3288 22.6749 20.5076 22.5429 20.6396C22.4109 20.7716 22.2321 20.846 22.0454 20.8467H10.3454C10.1588 20.846 9.97994 20.7716 9.84795 20.6396C9.71596 20.5076 9.64151 20.3288 9.64082 20.1421V19.4375C9.63943 19.3433 9.65687 19.2498 9.69212 19.1625C9.72736 19.0751 9.7797 18.9957 9.84606 18.9289C9.91242 18.862 9.99147 18.8091 10.0786 18.7732C10.1657 18.7373 10.259 18.7192 10.3532 18.7199H22.0532C22.2403 18.7206 22.4195 18.7954 22.5516 18.928C22.6837 19.0605 22.7578 19.24 22.7578 19.4271L22.75 20.1421Z" />
                </svg>
              </div>
              <div class="ecard-header-item-content">
                <h5> <?= Yii::t('site', 'E_CARD_STEP_1_E_CARD') ?> </h5>
                <p><?= Yii::t('site', 'E_CARD_STEP_1_E_CARD') ?> </p>
              </div>
            </div>
            <div class="ecard-header-item e-card-next-step">
              <div class="ecard-main-icon">
                <svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <g  >
                    <path
                      d="M22.75 4.46875H3.25C2.71128 4.46875 2.19462 4.68276 1.81369 5.06369C1.43276 5.44462 1.21875 5.96128 1.21875 6.5V19.5C1.21875 20.0387 1.43276 20.5554 1.81369 20.9363C2.19462 21.3172 2.71128 21.5312 3.25 21.5312H22.75C23.2887 21.5312 23.8054 21.3172 24.1863 20.9363C24.5672 20.5554 24.7812 20.0387 24.7812 19.5V6.5C24.7812 5.96128 24.5672 5.44462 24.1863 5.06369C23.8054 4.68276 23.2887 4.46875 22.75 4.46875ZM22.3438 6.90625V8.9375H3.65625V6.90625H22.3438ZM3.65625 19.0938V11.375H22.3438V19.0938H3.65625ZM21.125 16.6562C21.125 16.9795 20.9966 17.2895 20.768 17.518C20.5395 17.7466 20.2295 17.875 19.9062 17.875H16.6562C16.333 17.875 16.023 17.7466 15.7945 17.518C15.5659 17.2895 15.4375 16.9795 15.4375 16.6562C15.4375 16.333 15.5659 16.023 15.7945 15.7945C16.023 15.5659 16.333 15.4375 16.6562 15.4375H19.9062C20.2295 15.4375 20.5395 15.5659 20.768 15.7945C20.9966 16.023 21.125 16.333 21.125 16.6562ZM14.2188 16.6562C14.2188 16.9795 14.0903 17.2895 13.8618 17.518C13.6332 17.7466 13.3232 17.875 13 17.875H11.7812C11.458 17.875 11.148 17.7466 10.9195 17.518C10.6909 17.2895 10.5625 16.9795 10.5625 16.6562C10.5625 16.333 10.6909 16.023 10.9195 15.7945C11.148 15.5659 11.458 15.4375 11.7812 15.4375H13C13.3232 15.4375 13.6332 15.5659 13.8618 15.7945C14.0903 16.023 14.2188 16.333 14.2188 16.6562Z" />
                  </g>
                </svg>
              </div>
              <div class="ecard-header-item-content">
                <h5> <?= Yii::t('site', 'E_CARD_STEP_3_E_CARD') ?> </h5>
                <p> <?= Yii::t('site', 'E_CARD_STEP_3_E_CARD_PAYMENT') ?></p>
              </div>
            </div>
          </div>
    
          <?php
                $form = ActiveForm::begin([
                    'id' => 'zaka-form',
                    'method' => 'post',
                    'options' => [
                        'class' => 'contact-us-form ecard-step-content radio-check mb-5',

                        'data-pjax' => true,
                    ],
                    'enableAjaxValidation' => false,
                    'enableClientValidation' => true,


                ]);
                ?>

            <h3> <?= Yii::t('site','DETAILS') ?> </h3>
            <p>  <?= Yii::t('site','PLEASE_FILL_OUT_THE') ?></p>
              <div class="d-flex flex-column w-100  align-items-start justify-content-start">
                <div class="row w-100 px-0 g-4 pt-3 pb-3">
                <?php if ($users): ?>
                  <div class="col-lg-12 col-12 d-flex flex-column gap-3">
                  <label for="donor_id"><?= Yii::t('site', 'Select donors user') ?> <span
                                            class="red-astrik">*</span> </label>
                    <select name="ECardFormWebform[donor_id]" id="donor_id">
                        <?php foreach ($users as $id => $user): ?>
                            <option value="<?= $id ?>"><?= $user['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                  </div>
                  <?php endif; ?>
                  <div class="col-lg-6 col-12 d-flex flex-column gap-3">
                  <?= $form->field($model, 'sender_name')->textInput(['class' => false, 'maxlength' => true, 'placeholder' => Yii::t("site", "DONATE_SENDER")])->label(); ?>

                  </div>

                  <div class="col-lg-6 col-12 d-flex flex-column gap-3">
                  <?= $form->field($model, 'sender_email')->textInput(['class' => false, 'maxlength' => true, 'placeholder' => Yii::t("site", "DONATE_EMAIL")])->label(); ?>

                  </div>



                  <div class="col-lg-6 col-12 d-flex flex-column gap-3">
                  <?= $form->field($model, 'recipient_name')->textInput(['class' => false, 'maxlength' => true, 'placeholder' => Yii::t("site", "DONATE_RECIEPT")])->label(); ?>

                  </div>
            
                  <div class="col-lg-6 col-12 d-flex flex-column gap-3">
                  <?= $form->field($model, 'recipient_email')->textInput(['class' => false, 'maxlength' => true, 'placeholder' => Yii::t("site", "DONATE_RECIEPT_EMAIL_PLACEHOLDER")])->label(); ?>

                  </div>


                  <div class="col-lg-6 col-12 d-flex flex-column gap-3">
                  <?= $form->field($model, 'sender_mobile_number')->widget(PhoneInput::className(), [
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
                  <?= $form->field($model, 'recipient_mobile_number')->widget(PhoneInput::className(), [
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
                  <div class="col-lg-12 col-12 d-flex flex-column gap-3 ">

                    <label for="name"> <?= Yii::t('site', 'SEND_DATE') ?> <span class="optional">( <?= Yii::t('site', 'OPTIONAL') ?>)</span>
                    </label>
                    <input type="date" name="ECardFormWebform[start_date]" class="customization_date_class" id="date" placeholder=" DD/MM/YYYY ">

                  </div>
                </div>
              </div>
              <p class="">  <?= Yii::t('site', 'SELECT_AN_E_CARD')  ?>  <span class="optional">(<?= Yii::t('site', 'OPTIONAL')  ?>)</span></p>

              <div class="e-card-design">
              <?php foreach($cards as $key=> $card) : ?>
                  <div class="ecard">
         
                    <input type="radio" class="customize-img-prev" data-image="<?= $card->image ?>"  name="ECardFormWebform[e_card_id]" value="<?= $card->id ?>" />

                    <?= \frontend\widgets\WebpImage::widget(["src" => $card->image, "alt" => $card->title, "loading" => "lazy", 'css' => ""]) ?>
                  </div>
                <?php endforeach; ?>


              </div>
              <div class=" col-12 d-flex flex-column gap-3">
              <?= $form->field($model, 'message')->textarea(['maxlength' => true, 'id' => "exampleFormControlTextarea1", 'placeholder' => Yii::t("site", "TYPE_HERE"), 'rows' => 5])->label() ?>

              </div>
            <button type="button" class="preivew-ecard-btn" data-bs-toggle="modal" data-bs-target="#previewModalCenter">
              <picture>
                <img src="/theme/assets/Icons/shared-vision 1.svg" alt="">
              </picture>
              <p> <?= Yii::t('site','PREVIEW_E_CARD') ?> </p>
            </button>
      
 
    
            <button type="submit" class="type-4-btn mt-4">
              <span> <?= Yii::t('site','CONTINUE') ?> </span>
            </button>
            <?php ActiveForm::end(); ?>
        </div>
      </div>
    </section>



    
    <!--preview Modal -->
    <div class="preview-ecard-modal modal fade" id="previewModalCenter" tabindex="-1"
      aria-labelledby="previewModalCenterTitle" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="previewModalCenterTitle">   <?= Yii::t('site','PREVIR') ?>  </h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <picture>
              <img src="./assets/Images/e-cards/ecard-popup-1.png" alt="">
            </picture>
            <h4 class="modal-title-content"> <?= Yii::t('site','DEAR') ?>  <span id="receiver_name">   </span>  </h4>
            <h4  class="modal-desc-content"><span id="message-content"></span></h4>
          </div>
          <div class="modal-footer">
            <button type="button" class="ecard-modal-btn type-3-btn"><Span>
              <?= Yii::t('site','DONE') ?>  
            </Span></button>
          </div>
        </div>
      </div>
    </div>
<?php
    $script = <<< JS
    $(document).ready(function () {

      $('.customize-img-prev').on('change', function () {
          const selectedImage = $(this).data('image');
          $('#previewModalCenter .modal-body img').attr('src', selectedImage);
      });


      $('#ecardformwebform-recipient_name').on('input', function () {
          const recipientName = $(this).val();
          $('#receiver_name').text(recipientName);
      });


      $('#ecardformwebform-sender_name').on('input', function () {
          const senderName = $(this).val();
          $('#sender-message').text(senderName);
      });


      $('#exampleFormControlTextarea1').on('input', function () {
          const recipientMessage = $(this).val();
          $('#message-content').text(recipientMessage);
      });

      // Close Modal
      $(".ecard-modal-btn").on("click", function () {
        const modalElement = $(".preview-ecard-modal")[0];
        const modalInstance = bootstrap.Modal.getInstance(modalElement);
        modalInstance.hide();
      });
    });
JS;
$this->registerJs($script);
?>
