<?php

$this->params['mainIdName'] = "account-info";
$this->title = Yii::t('site', 'Account Information');
$this->registerCssFile("/theme/css/account-settings.css", ['depends' => [\frontend\assets\AppAsset::className()]]);
$this->registerCssFile("/theme/css/account-info.css", ['depends' => [\frontend\assets\AppAsset::className()]]);
$this->registerCssFile("/theme/css/otp-page.css", ['depends' => [\frontend\assets\AppAsset::className()]]);
?>

    <form action="<?=\yii\helpers\Url::to(['/account/profile/delete'])?>" method="post" id="delete-account-form" class="d-none">
        <input type="hidden" name="<?=Yii::$app->request->csrfParam?>" value="<?=Yii::$app->request->csrfToken?>">
    </form>

    <form class="account-info-form">
        <h3><?=Yii::t('site', 'PROFILE_DETAILS')?></h3>
        <div class="col-12 d-flex flex-column gap-2 mb-3">
            <label for="account-name"><?=Yii::t('site', 'PROFILE_NAME')?><span class="red-astrik">*</span> </label>
            <input type="text" name="account-name" id="account-name" placeholder="<?=$client->first_name?> <?=$client->last_name?>" disabled>
        </div>
        <div class="col-12 d-flex flex-column gap-2 mb-3">
            <label for="account-email"><?=Yii::t('site', 'PROFILE_EMAIL')?><span class="red-astrik">*</span>  </label>
            <input type="email" name="account-email" id="account-email" placeholder="<?=$client->email?>" disabled>
        </div>
        <div class="col-12 d-flex flex-column gap-2 mb-3 phoneContainer" data-bs-toggle="modal" data-bs-target="#change-mobile-modal">
            <label for="account-number"><?=Yii::t('site', 'PROFILE_MOBILE_NUMBER')?><span class="red-astrik">*</span> </label>
            <input type="tel" name="account-number" id="account-number" placeholder="+<?=$client->country_code?> <?=$client->phone?>" disabled>
            <?php if (time() - $client->phone_changed_at > 3600 * 24): ?>
                <button type="button" class="change-btn"><?=Yii::t('site', 'CHANGE')?></button>
            <?php endif; ?>
        </div>
        <div class="col-12 d-flex flex-column gap-2 mb-3 passContainer" data-bs-toggle="modal" data-bs-target="#change-password-modal">
            <label for="account-pass"><?=Yii::t('site', 'CHANGE_PASSWORD')?><span class="red-astrik">*</span> </label>
            <input type="tel" name="account-pass" id="account-pass" placeholder=" ********* " disabled>
            <button type="button" class="change-btn"><?=Yii::t('site', 'CHANGE')?></button>
        </div>
        <button type="button" class="type-6-btn " data-bs-toggle="modal" data-bs-target="#delete-account-modal">
            <span><?=Yii::t('site', 'DELETE_ACCOUNT')?></span>
        </button>
    </form>
    <?php if($profilePageBlocks): ?>

    <div class="d-flex flex-column gap-3">
    <?php foreach ($profilePageBlocks as $key => $item): ?>

        <div class="info-box">
  
                <?= \frontend\widgets\WebpImage::widget(["src" => $item->image, "alt" => $item->title, "loading" => "lazy", 'css' => ""]) ?>

            <h3> <?= $item->title ?> </h3>
            <p><?= $item->brief ?></p>
        </div>
        <?php endforeach; ?>

    </div>
    <?php endif; ?>
    <div class="delete-account-modal modal fade" id="delete-account-modal" tabindex="-1" aria-labelledby="delete-account-modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <picture>
                        <img src="/theme/assets/gif/wanted.gif" alt="">
                    </picture>
                    <h4><?=Yii::t('site', 'DELETE_ACCOUNT_MESSAGE')?></h4>
                </div>
                <div class="modal-footer">
                    <button type="button" class="type-3-btn" data-bs-dismiss="modal" aria-label="Close">
                        <span><?=Yii::t('site', 'MOVE_BACK')?></span>
                    </button>
                    <button id="delete-account-button" type="submit" class="type-6-btn" aria-label="<?=Yii::t('site', 'DELETE_ACCOUNT')?>" form="delete-account-form">
                    <span>
                          <?=Yii::t('site', 'YES_PLEASE')?>
                    </span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <?php if (time() - $client->phone_changed_at > 3600 * 24): ?>
        <div class="change-mobile-modal modal fade" id="change-mobile-modal" tabindex="-1" aria-labelledby="change-mobile-modal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <button type="button" class="btn-close btn-close-modal-phone" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <?php
                            $form = \kartik\form\ActiveForm::begin([
                                'method' => 'post',
                                'action' => \yii\helpers\Url::to(['/account/profile/update-phone']),
                                'id' => 'update-phone-form',
                            ]);
                        ?>
                            <input class="step" type="hidden" name="step" value="phone"/>
                            <div class="d-flex flex-column w-100 align-items-center justify-content-center update-phone">
                                <div class="row w-100 px-0 g-4 pt-3 pb-5">
                                    <picture class="secure-img">
                                        <img src="/theme/assets/Images/secure-img.png" alt="" class="mw-100">
                                    </picture>
                                    <h4 class="text-center"><?=Yii::t('site', 'CHAGE_MOBILE_NUMBER')?></h4>
                                    <div class="col-12 d-flex flex-column gap-2">
                                        <label for="name"><?=Yii::t('site', 'PHONE_NUMBER')?><span class="red-astrik">*</span> </label>
                                        <?= $form->field($update_phone_form, 'phone')->label(false)->widget(\borales\extensions\phoneInput\PhoneInput::className(), [
                                            'jsOptions' => [
                                                'initialCountry' => 'JO',
                                                'placeholderNumberType' => false,
                                                'nationalMode' => false,
                                                'separateDialCode' => true,
                                                'excludeCountries' => ['IL'],
                                            ],
                                            'options' => [
                                                'class' => 'p-0 change-phone-number',
                                            ],
                                        ]);
                                        ?>
                                    </div>
                                </div>
                            </div>
                        <div class="d-flex flex-column w-100 align-items-center justify-content-center update-otp d-none">
                            <div class="row w-100 px-0 g-4 pt-3 pb-5">
                                <picture class="secure-img">
                                    <img src="/theme/assets/Images/secure-img.png" alt="" class="mw-100">
                                </picture>
                                <h4 class="text-center"><?=Yii::t('site', 'CHECK_YOUR_MOBILE_Phone')?></h4>
                                <span class="text-center warn">
                                      <?=Yii::t('site', 'WE_HAVE_SEND_THE_CODE')?>
                                </span>
                                <div class="otp-container">
                                    <input type="text" name="otp[]" id="otp1" class="otp-input" placeholder="-" maxlength="1" oninput="moveForward(1)" onkeydown="moveBackward(event, 1)">
                                    <input type="text" name="otp[]" id="otp2" class="otp-input" placeholder="-" maxlength="1" oninput="moveForward(2)" onkeydown="moveBackward(event, 2)">
                                    <input type="text" name="otp[]" id="otp3" class="otp-input" placeholder="-" maxlength="1" oninput="moveForward(3)" onkeydown="moveBackward(event, 3)">
                                    <input type="text" name="otp[]" id="otp4" class="otp-input" placeholder="-" maxlength="1" oninput="moveForward(4)" onkeydown="moveBackward(event, 4)">
                                </div>
                                <div class="field-updatephoneform-otp">
                                    <span class="invalid-feedback text-danger text-center"></span>
                                </div>
                            </div>
                        </div>

                        <?php
                            \kartik\form\ActiveForm::end();
                        ?>
                    </div>
                    <div class="modal-footer">
                        <button class="type-4-btn ms-2 update-phone-btn" type="button">
                            <span><?=Yii::t('site', 'CONTINUE')?></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="change-password-modal modal fade" id="change-password-modal" tabindex="-1" aria-labelledby="change-password-modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php

                    $form = \kartik\form\ActiveForm::begin([
                        'method' => 'post',
                        'action' => \yii\helpers\Url::to(['/account/profile/update-password']),
                        'id' => 'change-password-form',
                        'options' => [
                            'class' => 'update-password-form',
                        ],
                        'enableClientValidation' => false
                    ]);

                    ?>
                    <div class="d-flex flex-column w-100 align-items-center  justify-content-center align-items-center ">
                        <div class="row w-100 px-0 g-4 pt-3 pb-5">
                            <picture class="secure-img">
                                <img src="/theme/assets/Images/secure-img.png" alt="" class="mw-100">
                            </picture>
                            <h4 class="text-center "><?=Yii::t('site', 'CHANGE_PASSWORD')?></h4>
                            <div class="col-12 d-flex flex-column passContainer">
                                <label for="password"><?=Yii::t('site', 'ENTER_CURRENCY_PASSWORD')?><span class="red-astrik">*</span> </label>
                                <?= $form->field($update_password_form, 'password')->passwordInput([
                                    'id' => 'password',
                                    'class'=>'account-pass',
                                    'options' => [
                                        'placeholder' => Yii::t('site', 'ENTER_PASSWORD'),
                                        'class'=>'account-pass'
                                    ]
                                ])->label(false)?>
                                <i class="fa-solid fa-eye change-eye-btn"></i>
                            </div>

                            <div class="col-12 d-flex flex-column passContainer">
                                <label for="new_password"><?=Yii::t('site', 'NEW_PASSWORD')?><span class="red-astrik">*</span> </label>
                                <?= $form->field($update_password_form, 'new_password')->passwordInput([
                                    'id' => 'new_password',
                                    'class'=>'account-pass',
                                    'options' => [
                                        'placeholder' => Yii::t('site', 'ENTER_NEW_PASSWORD'),
                               
                                    ]
                                ])->label(false)?>
                                <i class="fa-solid fa-eye change-eye-btn"></i>
                            </div>

                            <div class="col-12 d-flex flex-column passContainer">
                                <label for="confirm_new_password"><?=Yii::t('site', 'CONFIRM_NEW_PASSWORD')?><span class="red-astrik">*</span> </label>
                                <?= $form->field($update_password_form, 'confirm_new_password')->passwordInput([
                                    'id' => 'confirm_new_password',
                                    'class'=>'account-pass',
                                    'options' => [
                                        'placeholder' => Yii::t('site', 'ENTER_NEW_PASSWORD'),
                                       
                                    ]
                                ])->label(false)?>
                                <i class="fa-solid fa-eye change-eye-btn"></i>
                            </div>
                        </div>
                    </div>
                    <?php
                    \kartik\form\ActiveForm::end();
                    ?>
                </div>
                <div class="modal-footer">
                    <button class="type-4-btn ms-2" type="submit" form="change-password-form">
                        <span><?=Yii::t('site', 'CONTINUE')?></span>
                    </button>
                </div>
            </div>
        </div>
    </div>

<?php

$this->registerCss("
    #updatephoneform-phone{
        padding-left: 100px !important;
    }
    
    .arabic-version #updatephoneform-phone{
        padding-left: unset;
        padding-right: 100px !important;
    }
");

$this->registerJs("
    $('#change-password-form').on('submit', function(event) {
        event.preventDefault();
        const form = $(this);
        $.post(form.attr('action'), form.serialize(), function(data) {
            if (data.success) {
                window.location.href = data.response;
            }
            $.each(data.errors, function(key, value) {
                $('.field-' + key).find('.invalid-feedback').html(value[0]).css('display', 'block');
            })
        });
        return false;
    });"
);


$this->registerJs("

    $('#change-mobile-modal').on('shown.bs.modal', function () {
        const phoneInput = document.querySelector('.change-phone-number');
        const continueBtn = document.querySelector('.update-phone-btn');

        if (phoneInput && continueBtn) {
            phoneInput.addEventListener('keydown', function (e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    continueBtn.click();
                }
            });
        }
    });


    $('#change-mobile-modal').on('hidden.bs.modal', function () {
        $('.change-phone-number').val(''); // تفريغ حقل رقم الهاتف
        $('.update-phone').removeClass('d-none');
        $('.update-otp').addClass('d-none');
        $('.invalid-feedback').addClass('d-none');
        $('.step').val('phone');
        $('.change-phone-number').val('');
    });



    $('.update-phone-btn').on('click', function() {
        $('#update-phone-form').submit();
    });


    $('#update-phone-form').on('submit', function(event) {
        event.preventDefault();
        const form = $(this);
        $.post(form.attr('action'), form.serialize(), function(data) {
            if (data.success) {
                $('.update-phone').addClass('d-none');
                $('.update-otp').removeClass('d-none');
                $('.step').val('otp');
                if (data.step == 'final'){
                    window.location.href = data.response;
                }
            }

            $.each(data.errors, function(key, value) {
                $('.field-updatephoneform-' + key).find('.invalid-feedback')
                    .html(value[0])
                    .css('display', 'block');
            });
        });
        return false;
    });
");


?>

<?php

$js = <<<JS
$(document).ready(function () {
  const changeEyeBtns = $(".change-eye-btn");
  const inputPasswords = $(".account-pass");
  changeEyeBtns.each(function (index) {
    $(this).on("click", function () {
      const input = inputPasswords.eq(index);
      if (input.attr("type") === "password") {
        input.attr("type", "text");
        $(this).toggleClass("fa-eye-slash fa-eye");
      } else {
        input.attr("type", "password");
        $(this).toggleClass("fa-eye fa-eye-slash");
      }
    });
  });
});
$(document).ready(function() {
    $('.otp-input').first().focus();
    function moveForward(current) {
        let input = $('#otp' + current);
        let nextInput = $('#otp' + (current + 1));
        if (input.val().length === 1 && nextInput.length) {
            nextInput.focus();
        }
    }
    function moveBackward(e, current) {
        let input = $('#otp' + current);
        let prevInput = $('#otp' + (current - 1));
        if (e.key === 'Backspace' && input.val() === '' && prevInput.length) {
            prevInput.focus();
        }
    }
    $('.otp-input').each(function(index) {
        let current = index + 1;
        $(this).on('input', function() {
            moveForward(current);
        });
        $(this).on('keydown', function(e) {
            moveBackward(e, current);
        });
    });
});
JS;

$this->registerJs($js);

?>
