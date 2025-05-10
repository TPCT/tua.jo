<?php

use frontend\assets\AppAsset;
use frontend\widgets\breadcrumbs\BreadCrumbs;
use kartik\form\ActiveForm;
use common\components\TuaClient;

$this->title = Yii::t('site', 'Payment Methods');
$this->registerCssFile("/theme/css/payment-method-options.css", ['depends' => [AppAsset::className()]]);
?>

<?= BreadCrumbs::widget([]) ?>

<section class="mb-5 success-payment-section">
    <div class="container success-payment-content d-flex justify-content-center align-items-center flex-column">
        <picture class="success-payment-logo">
            <img src="/theme/assets/gif/success.gif" alt="<?= Yii::t('site', 'PAYMENT_SUCCESS') ?>"/>
        </picture>
        <p class="success-payment-title"><?= Yii::t('site', 'THANK_YOUFOR_YOUR_DONATION') ?></p>
        <?=\frontend\widgets\donation_programs\DonationPrograms::widget([
            'title' => Yii::t('site', 'DONATION_PROGRAM_SUCCESS_PAYMENT_TITLE'),
            'subtitle' => Yii::t('site', 'DONATION_PROGRAM_SUCCESS_PAYMENT_BRIEF'),
            'id' => 'payment-success-donations-programs'
        ])?>
        <p class="success-payment-desc-scuccess"><?= Yii::t('site', 'REFERENCE_NUMBER') ?>: #<span class="text-success"><?= $reference ?></span></p>
        <button class="type-6-btn" data-bs-toggle="modal" data-bs-target="#leave-opinion-ModalCenter">
            <span><?= Yii::t('site', 'LEAVE_OPTION') ?></span>
        </button>
    </div>
</section>


<div class="leave-opinion-modal modal rating-form-section fade" id="leave-opinion-ModalCenter" tabindex="-1" aria-labelledby="leave-opinion-ModalCenterTitle" aria-modal="true" role="dialog">
    <div class="modal-dialog  modal-dialog-centered modal-dialog-scrollable">

        <?php $form = ActiveForm::begin([
            'id' => 'contact-form',
            'method' => 'post',
            'options' => [
                'class' => 'contact-us-form '
            ],
        ]);
        ?>

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="Dontaion-reminder-ModalCenterTitle"> <?= Yii::t('site', 'LEAVE_US_YOUR_OPINION') ?> </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><?= Yii::t('site', 'LEAVE_US_YOUR_OPINION_BRIEF') ?></p>
                <div>
                    <h4><?= Yii::t('site', 'HOW_WOULD_YOU_RATE_THE_EASE_OF_USING') ?></h4>
                    <div class="payment-method-box">
                        <?php foreach (array_keys(TuaClient::QOption1) as $index => $key) : ?>
                            <div>
                                <label for="">  <?= Yii::t('site', TuaClient::QOption1[$key]) ?>   </label>
                                <input
                                        type="radio"
                                        name="RatingWebform[question_1_id]"
                                        value="<?= $key ?>"
                                        <?=$index == 0 ? "checked" : ""?>
                                />
                            </div>
                        <?php endforeach; ?>

                    </div>
                </div>
                <div>
                    <h4> <?= Yii::t('site', 'DID_YOU_ENCOUNTER_ANY_ISSUES') ?> </h4>
                    <div class="payment-method-box">
                        <?php foreach (array_keys(TuaClient::QOption2) as $index => $key) : ?>

                            <div>
                                <label for="">  <?= Yii::t('site', TuaClient::QOption2[$key]) ?>   </label>
                                <input
                                        type="radio"
                                        name="RatingWebform[question_2_id]"
                                        value="<?= $key ?>"
                                        <?=$index == 0 ? "checked" : ""?>
                                />
                            </div>
                        <?php endforeach; ?>

                    </div>
                </div>
                <div>
                    <h4> <?= Yii::t('site', 'DID_YOU_ENCOUNTER_ANY_ISSUES_TEXT') ?> </h4>
                    <div class="">

                        <div>

                            <?= $form->field($model, 'question_2_text')->textInput(['class' => false, 'maxlength' => true, 'placeholder' => Yii::t("site", "QUESTION_TWO_TEXT")])->label(); ?>

                        </div>

                    </div>
                </div>
                <div>
                    <h4><?= Yii::t('site', 'HOW_SATISFIED_ARE_YOU') ?></h4>
                    <div class="payment-method-box">
                        <?php foreach (array_keys(TuaClient::QOption2) as $index => $key) : ?>
                            <div>
                                <label for="">  <?= Yii::t('site', TuaClient::QOption3[$key]) ?>   </label>
                                <input
                                        type="radio"
                                        name="RatingWebform[question_3_id]"
                                        value="<?= $key ?>"
                                        <?=$index == 0 ? "checked" : ""?>
                                />
                            </div>
                        <?php endforeach; ?>


                    </div>
                </div>

                <div>
                    <h4> <?= Yii::t('site', 'DID_YOU_ENCOUNTER_ANY_ISSUES_TEXT_FOUR') ?> </h4>
                    <div class="">

                        <div>

                            <?= $form->field($model, 'question_4_text')->textInput(['class' => false, 'maxlength' => true, 'placeholder' => Yii::t("site", "QUESTION_FOUR_TEXT")])->label(); ?>

                        </div>

                    </div>
                </div>

                <div>
                    <h4><?= Yii::t('site', 'DO_YOU_HAVE_ANY_SUGGESTIONS') ?></h4>
                    <div class="payment-method-box">

                        <?php foreach (array_keys(TuaClient::QOption5_7) as $index => $key) : ?>

                            <div>
                                <label for="">  <?= Yii::t('site', TuaClient::QOption5_7[$key]) ?>   </label>
                                <input
                                        type="radio"
                                        name="RatingWebform[question_5_id]"
                                        value="<?= $key ?>"
                                        <?=$index == 0 ? "checked" : ""?>
                                />
                            </div>
                        <?php endforeach; ?>

                    </div>
                </div>

                <div>
                    <h4><?= Yii::t('site', 'DO_YOU_HAVE_ANY_SUGGESTIONS_2') ?></h4>
                    <div class="payment-method-box">

                        <?php foreach (array_keys(TuaClient::QOption5_7) as $index => $key) : ?>

                            <div>
                                <label for="">  <?= Yii::t('site', TuaClient::QOption5_7[$key]) ?>   </label>
                                <input
                                        type="radio"
                                        name="RatingWebform[question_6_id]"
                                        value="<?= $key ?>"
                                    <?=$index == 0 ? "checked" : ""?>
                                />
                            </div>
                        <?php endforeach; ?>

                    </div>
                </div>

                <div>
                    <h4><?= Yii::t('site', 'DO_YOU_HAVE_ANY_SUGGESTIONS_22') ?></h4>
                    <div class="payment-method-box">

                        <?php foreach (array_keys(TuaClient::QOption5_7) as $index => $key) : ?>

                            <div>
                                <label for="">  <?= Yii::t('site', TuaClient::QOption5_7[$key]) ?>   </label>
                                <input
                                        type="radio"
                                        name="RatingWebform[question_7_id]"
                                        value="<?= $key ?>"
                                    <?=$index == 0 ? "checked" : ""?>
                                />
                            </div>
                        <?php endforeach; ?>

                    </div>
                </div>

                <div>
                    <h4><?= Yii::t('site', 'DO_YOU_HAVE_ANY_SUGGESTIONS_22_TEXT_AREA') ?></h4>
                    <div class="">


                        <div>
                            <?= $form->field($model, 'question_8_text')->textarea(['maxlength' => true, 'id' => "exampleFormControlTextarea1", 'placeholder' => Yii::t("site", "TYPE_HERE"), 'rows' => 5])->label() ?>

                        </div>

                    </div>
                </div>

            </div>
            <div class="modal-footer justify-content-center">
                <button type="submit" class="ecard-modal-btn type-3-btn">
                <span>
                <?= Yii::t('site', 'SUBMIT') ?>
                  
                </span>
                </button>
            </div>
        </div>
        <?php ActiveForm::end(); ?>

    </div>
</div>


<?php
//if ($show_popup){
//    $js = <<<JS
//        setTimeout(function() {
//            $("#leave-opinion-ModalCenter").modal("show");
//        }, 1000);
//    JS;
//    $this->registerJs($js);
//}
//?>