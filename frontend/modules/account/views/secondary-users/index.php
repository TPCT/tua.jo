<?php

use yii\widgets\Pjax;

$this->params['mainIdName'] = "secondary-users";
$this->title = Yii::t('site', 'Secondary Users');
$this->registerCssFile("/theme/css/account-settings.css", ['depends' => [\frontend\assets\AppAsset::className()]]);
$this->registerCssFile("/theme/css/Payment-Schedule.css", ['depends' => [\frontend\assets\AppAsset::className()]]);
?>

<?php //if (count($user->secondaryUsers) < 3): ?>
<!--    <button class="type-3-btn my-3" data-bs-toggle="modal" data-bs-target="#add-user-modal"><span>--><?php //=Yii::t('site', 'Add new user')?><!--</span></button>-->
<?php //endif; ?>

<div class="donation-table-wrapper">
    <table>
        <thead>
        <tr>
            <th>
                <p><?=Yii::t('site', 'SECONDRY_USER_NAME')?></p>
            </th>
            <th>
                <p><?=Yii::t('site', 'SECONDRY_ClASS')?></p>
            </th>
            <th>
                <p><?=Yii::t('site', 'SECONDRY_email')?></p>
            </th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>
                <p><?=$user->first_name . ' ' . $user->last_name?></p>
            </td>
            <td>
                <p><?=Yii::t('site', 'Primary_Account')?></p>
            </td>
            <td>
                <p><?=$user->email?></p>
            </td>
        </tr>
        <?php foreach ($user->secondaryUsers as $secondary_user):?>
            <tr>
                <td>
                    <p><?=$secondary_user->name?></p>
                </td>
                <td>
                    <p><?=Yii::t('site', 'Secondary_Account')?></p>
                </td>
                <td>
                    <p><?=$secondary_user->email?></p>
                </td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
</div>


<!--<div class="add-user-modal modal fade" id="add-user-modal" tabindex="-1" aria-labelledby="add-user-modal"-->
<!--     aria-hidden="true">-->
<!--    <div class="modal-dialog modal-dialog-centered">-->
<!--        <div class="modal-content">-->
<!--            <div class="modal-header">-->
<!--                <div>-->
<!--                    <h4 class="modal-title" id="previewModalCenterTitle">Add new user</h4>-->
<!--                </div>-->
<!--                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>-->
<!--            </div>-->
<!--            <div class="modal-body">-->
<!---->
<!--                --><?php
//                    $form = \kartik\form\ActiveForm::begin([
//                        'method' => 'post',
//                        'id' => 'secondary-user-form',
//                        'action' => \yii\helpers\Url::to(['/account/secondary-users/create']),
//                        'options' => [
//                            'class' => 'd-flex row',
//                        ],
//                        'enableClientValidation' => false,
//                    ]);
//                ?>
<!--                <div class="col-12 d-flex flex-column gap-2 mb-3">-->
<!--                    <label for="name">--><?php //=Yii::t('site', 'Donor Name')?><!--<span class="red-astrik">*</span></label>-->
<!--                    --><?php //=
//                        $form->field($model, 'name')->textInput([
//                            'id' => 'name',
//                            'placeholder' => Yii::t('site', 'Donor Name'),
//                        ])->label(false)
//                    ?>
<!--                </div>-->
<!--                <div class="col-12 d-flex flex-column gap-2 mb-3">-->
<!--                    <label for="email">--><?php //=Yii::t('site', 'Donor Name')?><!--<span class="red-astrik">*</span></label>-->
<!--                    --><?php //=
//                        $form->field($model, 'email')->textInput([
//                            'id' => 'email',
//                            'placeholder' => Yii::t('site', 'Email'),
//                            'type' => 'email'
//                        ])->label(false)
//                    ?>
<!--                </div>-->
<!--                --><?php //\kartik\form\ActiveForm::end();?>
<!--            </div>-->
<!--            <div class="modal-footer">-->
<!--                <button type="submit" class="type-3-btn" form="secondary-user-form">-->
<!--                    <span>  --><?php //=Yii::t('site', 'add')?><!-- </span>-->
<!--                </button>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->

<?php

$this->registerJs("
    $('#secondary-user-form').on('submit', function(event) {
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

?>