<?php

$this->params['mainIdName'] = "login";
$this->title = Yii::t('site', 'Login');
$this->registerCssFile("/theme/css/donation-as-guest-or-login.css", ['depends' => [\frontend\assets\AppAsset::className()]]);
$this->registerCssFile("/theme/css/login.css", ['depends' => [\frontend\assets\AppAsset::className()]]);
?>
<section class="login-main-section">
    <div class="container">
        <div class="donation-login">
            <h2><?=Yii::t('site', 'LOGIN_TO_ACCOUNT_TITLE')?></h2>
            <p><?=Yii::t('site', 'LOGIN_TO_ACCOUNT_SECOND_TITLE')?></p>

            <?php
            $form = \kartik\form\ActiveForm::begin([
                'method' => 'post',
                'options' => [
                    'class' => 'contact-us-form vistor-checkout-form',
                ],
                'enableClientValidation' => true
            ]);
            ?>
            <div class="row w-100 px-0 g-4 pt-3 pb-3">
                <?php if (Yii::$app->session->hasFlash('success')) : ?>
                    <div class="alert alert-success">
                        <button aria-hidden="true" data-bs-dismiss="alert" class="close btn" type="button">×</button>
                        <?= Yii::$app->session->getFlash('success')[0] ?>
                    </div>
                <?php endif; ?>
                <div class=" col-12 d-flex flex-column gap-3">
                    <label for="email"><?=Yii::t('site', 'EMAIL_LOGIN_LBAEL')?><span class="red-astrik">*</span></label>
                    <?=
                    $form->field($model, 'email')->label(false)->textInput([
                        'placeholder' => Yii::t('site', 'EMAIL_LOGIN_PLACE_HOLDER'),
                        'type' => 'email',
                        'id' => 'email'
                    ])
                    ?>
                </div>

                <div class="col-12 d-flex flex-column gap-3">
                    <label for="password"><?=Yii::t('site', 'PASSWORD')?><span class="red-astrik">*</span></label>
                    <div class="position-relative">
                        <?=
                        $form->field($model, 'password')->passwordInput([
                            'id' => 'password',
                            'placeholder' => Yii::t('site', 'ENTER_PASSWORD'),
                        ])->label(false)
                        ?>
                            <i class="fa-solid fa-eye change-eye-btn pass-visable-btn"></i>
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-2">
                    <a class="forget-password" data-bs-toggle="modal" data-bs-target="#change-password-modal" href="<?=\yii\helpers\Url::to(['/account/forget-password'])?>"><?=Yii::t('site', 'Forget Password ?')?></a>
                </div>
                <button type="submit" class="type-3-btn w-100">
                    <span><?=Yii::t('site', 'Continue')?></span>
                </button>
            </div>

            <!-- <div class=" continue-border">
                <div></div>
                <p><?=Yii::t('site', 'OTHER_SIGN_IN_OPTIONS')?></p>
                <div></div>
            </div> -->
            <!-- <div class="login-methods">
                <a class="type-77-btn">
                    <svg width="24" height="25" viewBox="0 0 24 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_1439_5411)">
                            <path d="M0 12.2002C0 5.5834 5.3832 0.200195 12 0.200195C14.6723 0.200195 17.2017 1.05997 19.3147 2.6866L16.5262 6.309C15.2197 5.30328 13.6545 4.77162 12 4.77162C7.90389 4.77162 4.57143 8.10408 4.57143 12.2002C4.57143 16.2963 7.90389 19.6288 12 19.6288C15.2991 19.6288 18.1026 17.4673 19.0688 14.4859H12V9.91448H24V12.2002C24 18.817 18.6168 24.2002 12 24.2002C5.3832 24.2002 0 18.817 0 12.2002Z" fill="#FAFAFA"/>
                        </g>
                        <defs>
                            <clipPath id="clip0_1439_5411">
                                <rect width="24" height="24" fill="white" transform="translate(0 0.200195)"/>
                            </clipPath>
                        </defs>
                    </svg>
                </a>
                <a class="type-77-btn">
                    <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_1439_5404)">
                            <path d="M19.0821 0.799805C19.1435 0.799805 19.205 0.799805 19.2699 0.799805C19.4206 2.66159 18.71 4.05271 17.8463 5.06011C16.9989 6.06056 15.8385 7.03087 13.9616 6.88364C13.8364 5.04852 14.5482 3.76057 15.4107 2.75549C16.2106 1.8188 17.6771 0.985287 19.0821 0.799805Z" fill="#FAFAFA"/>
                            <path d="M24.7632 19.9106C24.7632 19.9292 24.7632 19.9454 24.7632 19.9628C24.2357 21.5603 23.4834 22.9294 22.5652 24.1999C21.7271 25.3534 20.7 26.9057 18.866 26.9057C17.2813 26.9057 16.2287 25.8867 14.6045 25.8588C12.8865 25.831 11.9417 26.7109 10.3709 26.9323C10.1912 26.9323 10.0115 26.9323 9.83531 26.9323C8.68184 26.7654 7.75094 25.8519 7.07277 25.0288C5.07304 22.5967 3.52773 19.455 3.24023 15.4347C3.24023 15.0406 3.24023 14.6476 3.24023 14.2534C3.36196 11.3761 4.76003 9.03671 6.61834 7.90295C7.59908 7.30013 8.94731 6.78657 10.4486 7.01611C11.092 7.1158 11.7493 7.33606 12.3254 7.55401C12.8714 7.76383 13.5542 8.13596 14.2011 8.11625C14.6393 8.1035 15.0752 7.87512 15.5169 7.71399C16.8106 7.2468 18.0789 6.71122 19.7505 6.96278C21.7595 7.26651 23.1854 8.15914 24.0665 9.53635C22.367 10.6179 21.0234 12.2479 21.2529 15.0313C21.457 17.5596 22.9269 19.0389 24.7632 19.9106Z" fill="#FAFAFA"/>
                        </g>
                        <defs>
                            <clipPath id="clip0_1439_5404">
                                <rect width="26.4" height="26.4" fill="white" transform="translate(0.800781 0.799805)"/>
                            </clipPath>
                        </defs>
                    </svg>
                </a>
            </div> -->
            <div class="not-member">
                <p><?=Yii::t('site', 'ALREADY_HAS_ACCOUNT_LOGIN')?></p>
                <a href="<?=\yii\helpers\Url::to('/account/register')?>"><?=Yii::t('site', "REGISTER_NOW")?></a>
            </div>
            <?php \kartik\form\ActiveForm::end() ?>
        </div>
        <picture class="login-main-pic">
            
            <?php if($loginPageImage): ?>
                <?= \frontend\widgets\WebpImage::widget(["src" => $loginPageImage->image, "alt" => $loginPageImage->title, "loading" => "lazy", 'css' => ""]) ?>
            <?php endif; ?>
        </picture>
    </div>
</section>

<div class="change-password-modal modal fade" id="change-password-modal" tabindex="-1" aria-labelledby="change-password-modal" aria-hidden="true">
    <form method="post" action="<?=\yii\helpers\Url::to(['/account/forget-password'])?>">
        <input type="hidden" name="<?=Yii::$app->request->csrfParam?>" value="<?=Yii::$app->request->csrfToken?>" />
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex flex-column w-100 align-items-center justify-content-center align-items-center ">
                        <div class="row w-100 px-0 g-4 pt-3 pb-5">
                            <picture class="secure-img">
                                <img src="/theme/assets/Images/secure-img.png" alt="" class="mw-100">
                            </picture>
                            <h4 class="text-center "><?=Yii::t('site', 'ENTER_YOUR_EMAIL_TO_RESET_PASSWORD')?></h4>
                            <div class="bg-success rounded-3 alert d-none"></div>
                            <div class="col-12 d-flex flex-column">
                                <label for="password"><?=Yii::t('site', 'ENTER YOUR EMAIL')?><span class="red-astrik">*</span> </label>
                                <input class="email" type="email" name="email" placeholder="<?=Yii::t('site', 'example@email.com')?>" />
                                <span class="text-danger email-error d-none"><?=Yii::t('site', 'Please enter valid email')?></span>
                            </div>
                            <div class="col-12 d-flex justify-content-center">
                                <button class="type-4-btn ms-2 reset-password" type="submit" form="change-password-form">
                                    <span><?=Yii::t('site', 'Reset')?></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<?php
$this->registerJsVar('language', Yii::$app->language);
$js = <<<JS
$("button.reset-password").on('click', function(e) {
    e.preventDefault();
    let form = $(this).closest('form');
    let email = form.find(".email").val();
    let alertBox = form.find('.alert');

    form.find('.error').addClass('d-none');
    alertBox.html("").addClass("d-none");

    if (!email.trim().match(/^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/)){
        form.find('.email-error').removeClass('d-none');
        return;
    }

    $.ajax({
        method: 'POST',
        url: form.attr('action'),
        data: form.serialize(),
        success: function(response) {
            alertBox.removeClass('d-none').html(response['message']);

            setTimeout(function() {
                form.find(".email").val(""); 
                const modal = bootstrap.Modal.getInstance(document.getElementById('change-password-modal'));
                modal.hide(); 
            }, 1000);
        }
    });
});


$('#change-password-modal').on('hidden.bs.modal', function () {
    let form = $(this).find('form');
    form.find('.alert').addClass('d-none').html("");
    form.find('.email-error').addClass('d-none');
    form.find('.email').val('');
});

function showPassword() {
      const changeEyeBtn = document.querySelector(".change-eye-btn");
      const inputPassword = document.querySelector("input[type='password']");
      changeEyeBtn.addEventListener("click", () => {
        if (inputPassword.type === "password") {
            inputPassword.type = "text";
            changeEyeBtn.classList.toggle("fa-eye-slash");
            changeEyeBtn.classList.toggle("fa-eye");
        } else {
          inputPassword.type = "password";
            changeEyeBtn.classList.toggle("fa-eye");
            changeEyeBtn.classList.toggle("fa-eye-slash");
        }
      });
    }
    showPassword();
JS;

$this->registerJs($js);



