<?php

use yii\widgets\Pjax;

$this->params['mainIdName'] = "Payment-Schedule";
$this->title = Yii::t('site', 'Payment Schedule');
$this->registerCssFile("/theme/css/account-settings.css", ['depends' => [\frontend\assets\AppAsset::className()]]);
$this->registerCssFile("/theme/css/Payment-Schedule.css", ['depends' => [\frontend\assets\AppAsset::className()]]);
?>

<div class="donation-table-wrapper">
    <table>
        <thead>
        <tr>
            <th>
                <p><?=Yii::t('site', 'Details')?></p>
            </th>
            <th>
                <p>
                    <?=Yii::t('site', 'Types')?>
                </p>
            </th>
            <th>
                <p><?=Yii::t('site', 'Donors user')?></p>
            </th>
            <th>
                <p><?=Yii::t('site', 'Amount')?></p>
            </th>
            <th>
                <p>
                    <?=Yii::t('site', 'Due date')?>
                </p>
            </th>
            <th>
                <p>
                    <?=Yii::t('site', 'Action')?>
                </p>
            </th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($items as $item): ?>
            <tr>
                <td>
                    <div class="donation-detail">
                        <?php if (!empty($item->image)): ?>
                            <?= \frontend\widgets\WebpImage::widget(["src" => $item->image, "alt" => $item->title, "loading" => "lazy", 'css' => ""]) ?>
                        <?php endif; ?>
                        <div>
                            <p><?=$item->title?></p>
                        </div>
                    </div>
                </td>
                <td>
                    <p><?=$item->donationType->title?></p>
                </td>
                <td>
                    <p><?=$item->name?></p>
                </td>
                <td>
                    <p><?=$item->total_jod?> <?=Yii::t('site', 'JOD')?></p>
                </td>
                <td>
                    <p><?=date('Y-m-d', $item->next_due_at)?></p>
                </td>
                <td>
                    <div class="d-flex gap-2 align-items-center justify-content-between h-100">
                        <button data-id="<?=$item->id?>" class="type-6-btn cancel-recurring" data-bs-toggle="modal" data-bs-target="#stop-recaring-modal">
                            <span><?=Yii::t('site', 'STOP_RECURRING')?></span>
                        </button>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="stop-recaring-modal modal fade" id="stop-recaring-modal" tabindex="-1" aria-labelledby="stop-recaring-Modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form method="post" action="<?=\yii\helpers\Url::to(['/account/payment-schedule/delete'])?>" id="stop-recurring-form">
            <input type="hidden" name="<?=Yii::$app->request->csrfParam?>" value="<?=Yii::$app->request->csrfToken?>" />
            <input type="hidden" name="id" id="item-id">
        </form>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <picture>
                    <img src="/theme/assets/gif/credit.gif" alt="">
                </picture>
                <h4 class="text-center"><?=Yii::t('site', 'ARE_YOU_SURE_YOU_WANT_TO_STOP_IT_AUTOMATICALLY')?></h4>
            </div>
            <div class="modal-footer">
                <button type="button" class="ecard-modal-btn type-3-btn" data-bs-dismiss="modal">
                    <span><?=Yii::t('site', 'MOVE_BACK')?>
                    </span>
                </button>
                <button type="submit" class="ecard-modal-btn type-6-btn" form="stop-recurring-form">
                    <span><?=Yii::t('site', 'YES_PLEASE')?></span>
                </button>
            </div>
        </div>
    </div>
</div>


<?php

$js = <<<JS
    $(".cancel-recurring").on('click', function (){
        $("#item-id").val($(this).data('id'));
    });
JS;

$this->registerJs($js);

?>
