<?php

use yii\widgets\Pjax;

$this->params['mainIdName'] = "Guarantees";
$this->title = Yii::t('site', 'Guarantees');
$this->registerCssFile("/theme/css/account-settings.css", ['depends' => [\frontend\assets\AppAsset::className()]]);
$this->registerCssFile("/theme/css/Guarantees.css", ['depends' => [\frontend\assets\AppAsset::className()]]);
?>

    <div class="donation-table-wrapper">
        <table>
            <thead>
            <tr>
                <th>
                    <p> <?= Yii::t('site', 'DETAILS') ?> </p>
                </th>
                <th>
                    <p>
                        <?= Yii::t('site', 'USER_DONOR') ?>

                    </p>
                </th>
                <th>
                    <p>
                        <?= Yii::t('site', 'TYPE_OF_DONATION') ?>
                    </p>
                </th>
                <th>
                    <p>
                        <?= Yii::t('site', 'DONATION_AMOUNT') ?>

                    </p>
                </th>
                <th>
                    <p>
                        <?= Yii::t('site', 'ACTION') ?>
                    </p>
                </th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($sponsorships as $sponsorship): ?>
                <tr>
                    <td>
                        <div class="donation-detail">
                            <?php if (!empty($sponsorship['image'])): ?>
                                <?= \frontend\widgets\WebpImage::widget(["src" => $sponsorship['image'], "alt" => $sponsorship['title'], "loading" => "lazy", 'css' => ""]) ?>
                            <?php endif; ?>

                            <div>
                                <p><?= $sponsorship['title'] ?></p>
                                <p><?= Yii::t('site', 'Age') ?>
                                    : <?= $sponsorship['age'] ?> <?= Yii::t('site', 'Years old') ?></p>
                                <p><?= Yii::t('site', 'Gender') ?>: <?= $sponsorship['gender'] ?></p>
                            </div>
                        </div>
                    </td>
                    <td>
                        <p><?= $sponsorship['donor'] ?></p>
                    </td>
                    <td>
                        <p><?= Yii::t('site', 'Monthly') ?></p>
                    </td>
                    <td><p><?= $sponsorship['amount'] ?> <?= Yii::t('site', 'JOD') ?></p></td>
                    <?php if ($sponsorship['id']): ?>
                        <td class="d-flex flex-column gap-2">
                            <button class="type-3-btn request-visit-button" data-bs-toggle="modal"
                                    data-bs-target="#request-visit-modal" data-family-id="<?= $sponsorship['id'] ?>">
                                <span><?= Yii::t('site', 'Request a visit') ?></span>
                            </button>
                            <button class="type-4-btn request-call-button" data-bs-toggle="modal"
                                    data-bs-target="#request-call-modal" data-family-id="<?= $sponsorship['id'] ?>">
                                <span><?= Yii::t('site', 'Request a call') ?></span>
                            </button>
                        </td>
                    <?php else: ?>
                        <td></td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="request-call-modal modal fade" id="request-call-modal" tabindex="-1"
         aria-labelledby="request-call-modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="previewModalCenterTitle"><?=Yii::t('site', 'Request a call')?></h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><?=Yii::t('site', 'REQUEST_CALL_BRIEF')?></p>
                    <?php
                    $form = \kartik\widgets\ActiveForm::begin([
                        'method' => 'post',
                        'action' => \yii\helpers\Url::to(['/account/guarantees/request-call']),
                        'id' => 'request-call-form',
                        'options' => [
                            'class' => 'row',
                        ],
                        'enableClientValidation' => false
                    ]);
                    ?>
                    <?= $form->field($request_call_form, 'family_id')->label(false)->hiddenInput() ?>
                    <div class="col-lg-6 col-12 d-flex flex-column gap-2 mb-3">
                        <label for="account-name"><?= Yii::t('site', 'Name') ?></label>
                        <?= $form->field($request_call_form, 'name')->label(false)->textInput([
                            'placeholder' => Yii::$app->user->identity->first_name . " " . Yii::$app->user->identity->last_name
                        ]) ?>
                    </div>
                    <div class="col-lg-6 col-12 d-flex flex-column gap-2 mb-3">
                        <label for="account-email"><?= Yii::t('site', 'Email Address') ?></label>
                        <?= $form->field($request_call_form, 'email')->label(false)->textInput([
                            'placeholder' => Yii::t('site', 'Email')
                        ]) ?>
                    </div>
                    <div class="col-lg-6 col-12 d-flex flex-column gap-2 mb-3">
                        <label for="account-number"><?= Yii::t('site', 'Mobile Number') ?><span
                                    class="red-astrik">*</span> </label>
                        <?= $form->field($request_call_form, 'phone')->label(false)->textInput([
                            'placeholder' => Yii::t('site', '+962 7XX XXXX XXX')
                        ]) ?>
                    </div>
                    <div class="col-lg-6 col-12 d-flex flex-column gap-2 mb-3">
                        <label for="account-name"><?= Yii::t('site', 'Call Date') ?><span class="red-astrik">*</span>
                        </label>
                        <?= $form->field($request_call_form, 'date')->label(false)->widget(\kartik\widgets\DateTimePicker::className(), [
                            'options' => ['placeholder' => Yii::t('site', 'Call Date')],
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd hh:ii:ss',
                                'todayHighlight' => true,
                                'startDate' => date('Y-m-d H:i'),
                            ],
                        ]) ?>
                    </div>
                    <div class="col-12 d-flex flex-column gap-2 mb-3">
                        <label for="message"><?= Yii::t('site', 'message') ?> </label>
                        <?= $form->field($request_call_form, 'message')->label(false)->textarea([]) ?>
                    </div>
                    <?php
                    \kartik\widgets\ActiveForm::end();
                    ?>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="type-3-btn" form="request-call-form">
                        <span>
                          <?= Yii::t('site', 'submit') ?>
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="request-visit-modal modal fade" id="request-visit-modal" tabindex="-1"
         aria-labelledby="request-visit-modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="previewModalCenterTitle"><?=Yii::t('site', 'Request a visit')?></h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><?=Yii::t('site', 'REQUEST_VISIT_BRIEF')?></p>
                    <?php
                    $form = \kartik\widgets\ActiveForm::begin([
                        'method' => 'post',
                        'action' => \yii\helpers\Url::to(['/account/guarantees/request-visit']),
                        'id' => 'request-visit-form',
                        'options' => [
                            'class' => 'row',
                        ],
                        'enableClientValidation' => false
                    ]);
                    ?>
                    <?= $form->field($request_visit_form, 'family_id')->label(false)->hiddenInput() ?>
                    <div class="col-lg-6 col-12 d-flex flex-column gap-2 mb-3">
                        <label for="account-name"><?= Yii::t('site', 'Name') ?></label>
                        <?= $form->field($request_visit_form, 'name')->label(false)->textInput([
                            'placeholder' => Yii::$app->user->identity->first_name . " " . Yii::$app->user->identity->last_name
                        ]) ?>
                    </div>
                    <div class="col-lg-6 col-12 d-flex flex-column gap-2 mb-3">
                        <label for="account-email"><?= Yii::t('site', 'Email Address') ?></label>
                        <?= $form->field($request_visit_form, 'email')->label(false)->textInput([
                            'placeholder' => Yii::t('site', 'Email')
                        ]) ?>
                    </div>
                    <div class="col-lg-6 col-12 d-flex flex-column gap-2 mb-3">
                        <label for="account-number"><?= Yii::t('site', 'Mobile Number') ?><span
                                    class="red-astrik">*</span> </label>
                        <?= $form->field($request_visit_form, 'phone')->label(false)->textInput([
                            'placeholder' => Yii::t('site', '+962 7XX XXXX XXX')
                        ]) ?>
                    </div>
                    <div class="col-lg-6 col-12 d-flex flex-column gap-2 mb-3">
                        <label for="account-name"><?= Yii::t('site', 'Call Date') ?><span class="red-astrik">*</span>
                        </label>
                        <?= $form->field($request_visit_form, 'date')->label(false)->widget(\kartik\widgets\DateTimePicker::className(), [
                            'options' => ['placeholder' => Yii::t('site', 'Call Date')],
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd hh:ii:ss',
                                'todayHighlight' => true,
                                'startDate' => date('Y-m-d H:i'),
                            ],
                        ]) ?>
                    </div>
                    <div class="col-12 d-flex flex-column gap-2 mb-3">
                        <label for="message"><?= Yii::t('site', 'message') ?> </label>
                        <?= $form->field($request_visit_form, 'message')->label(false)->textarea([]) ?>
                    </div>
                    <?php
                    \kartik\widgets\ActiveForm::end();
                    ?>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="type-3-btn" form="request-visit-form">
                        <span>
                          <?= Yii::t('site', 'submit') ?>
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </div>


<?php

$this->registerJs("
    $('.request-call-button, .request-visit-button').on('click', function(event) {
        $('#requestcallform-family_id').val($(this).data('family-id'));
        $('#requestvisitform-family_id').val($(this).data('family-id'));
    })
    $('#request-call-form').on('submit', function(event) {
        event.preventDefault();
        const form = $(this);
        $.post(form.attr('action'), form.serialize(), function(data) {
            if (data.success) {
                $('#request-call-modal').modal('hide');
            }
            $.each(data.errors, function(key, value) {
                $('.field-' + key).find('.invalid-feedback').html(value[0]).css('display', 'block');
            })
        });
        return false;
    });
    $('#request-visit-form').on('submit', function(event) {
        event.preventDefault();
        const form = $(this);
        $.post(form.attr('action'), form.serialize(), function(data) {
            if (data.success) {
                $('#request-visit-modal').modal('hide');
            }
            $.each(data.errors, function(key, value) {
                $('.field-' + key).find('.invalid-feedback').html(value[0]).css('display', 'block');
            })
        });
        return false;
    });
");

?>