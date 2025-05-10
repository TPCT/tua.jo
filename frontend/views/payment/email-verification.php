<?php

$this->title = Yii::t('site', 'Payment Email Verification');
$this->registerCssFile("/theme/css/otp-page.css", ['depends' => [\frontend\assets\AppAsset::className()]]);
?>

<section class="otp-section">
    <div class="container">
        <form action="" class="d-flex flex-column" method="POST">
            <input type="hidden" name="<?=Yii::$app->request->csrfParam?>" value="<?=Yii::$app->request->csrfToken?>"/>
            <picture class="secure-img ">
                <img src="/theme/assets/Images/secure-img.png" alt="" class="mw-100">
            </picture>
            <h4 class="text-center mt-3"><?=Yii::t('site','CHECK_YOUR_MOBILE')?></h4>
            <span class="text-center warn">
                  <?=Yii::t('site', 'WE_HAVE_SEND_THE_CODE')?>
                </span>
            <div class="otp-container">
                <input type="text" name="otp[]" id="otp1" class="otp-input" placeholder="-" maxlength="1" oninput="moveForward(1)" onkeydown="moveBackward(event, 1)">
                <input type="text" name="otp[]" id="otp2" class="otp-input" placeholder="-" maxlength="1" oninput="moveForward(2)" onkeydown="moveBackward(event, 2)">
                <input type="text" name="otp[]" id="otp3" class="otp-input" placeholder="-" maxlength="1" oninput="moveForward(3)" onkeydown="moveBackward(event, 3)">
                <input type="text" name="otp[]" id="otp4" class="otp-input" placeholder="-" maxlength="1" oninput="moveForward(4)" onkeydown="moveBackward(event, 4)">
            </div>

            <div class="d-flex mt-3">
                <button class="otp-verify type-6-btn text-dark" type="submit">
                    <span><?=Yii::t('site', 'Verify')?></span>
                </button>
            </div>
        </form>
    </div>
</section>

<?php

$js = <<<JS
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