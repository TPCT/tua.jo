<?php

$this->params['mainIdName'] = "dontaion-history";
$this->title = Yii::t('site', 'Donation History');
$this->registerCssFile("/theme/css/account-settings.css", ['depends' => [\frontend\assets\AppAsset::className()]]);
$this->registerCssFile("/theme/css/Donation-history.css", ['depends' => [\frontend\assets\AppAsset::className()]]);
?>


<?php
    $form = \kartik\form\ActiveForm::begin([
            'method' => 'GET',
            'action' => \yii\helpers\Url::to(['/account/donations-history']),
            'id' => 'donation-history-filter-form',
    ]);
?>
<div class="d-flex gap-2">
    <input type="hidden" name="type" class="type">
    <div class="col-6 col-md-3 d-flex flex-column gap-2 mb-3">
        <?=$form->field($filter_form, "start_date")->widget(\kartik\date\DatePicker::className(), [
            'options' => ['placeholder' => Yii::t('site', 'Start Date')],
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd',
                'todayHighlight' => true,
            ],
        ])?>
    </div>
    <div class=" col-6 col-md-3 d-flex flex-column gap-2 mb-3">
        <?=$form->field($filter_form, "end_date")->widget(\kartik\date\DatePicker::className(), [
            'options' => ['placeholder' => Yii::t('site', 'End Date')],
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd',
                'todayHighlight' => true,
            ],
        ])?>
    </div>

    <div class=" col-6 col-md-3 d-flex flex-column gap-2 mb-3">
        <label for="date"><?=Yii::t('site', 'Donor')?></label>
        <?=$form->field($filter_form, "name")->dropDownList($users)->label(false)?>
    </div>

    <div class="col-6 col-md-2 d-flex flex-column gap-2 mb-3 justify-content-center">
        <input type="submit" form="donation-history-filter-form" value="<?=Yii::t('site', 'Search')?>">
    </div>
</div>

<?php
    \kartik\form\ActiveForm::end();
?>

<div class="donation-table-wrapper">
    <table>
        <thead>
        <tr>
            <th>
                <p><?=Yii::t('site', 'Reason for donation')?></p>
            </th>
            <th>
                <p>
                    <?=Yii::t('site', 'Donor’s user')?>
                </p>
            </th>
            <th>
                <p><?=Yii::t('site', 'Donation Amount')?></p>
            </th>
            <th>
                <p><?=Yii::t('site', 'Donation date')?></p>
            </th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($donations as $donation) : ?>
            <?php
                $date = new DateTime($donation['DonationDate'])
            ?>
            <tr>
                <td>
                    <div class="donation-detail">
                        <?php if (!empty($donation['image'])): ?>
                            <?= \frontend\widgets\WebpImage::widget(["src" => $donation['image'], "alt" => $donation['title'], "loading" => "lazy", 'css' => ""]) ?>
                        <?php endif; ?>

                        <p><?=$donation['title']?></p>
                    </div>
                </td>
                <td>
                    <p><?=$donation['DonorName']?></p>
                </td>
                <td>
                    <p><?=number_format($donation['Amount'], 2)?> <?=Yii::t('site', 'JOD')?></p>
                </td>
                <td>
                    <p><?=$date->format("Y-m-d")?>  |  <?=$date->format('H:i')?></p>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <?php if ($pages > 1): ?>
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <li class="page-item <?=$page == 1 ? "disabled" : ""?>">
                    <a class="page-link" href="<?=\yii\helpers\Url::to(['/account/donations-history?' . http_build_query(array_merge($filter_form->attributes, ['page' => $page - 1]))])?>" tabindex="-1"><?=Yii::t('site', 'Previous')?></a>
                </li>
                <?php if ($page - 2 > 0): ?>
                    <li class="page-item"><a class="page-link" href="<?=\yii\helpers\Url::to(['/account/donations-history?' . http_build_query(array_merge($filter_form->attributes, ['page' => $page -2]))])?>"><?=$page -2?></a></li>
                <?php endif ?>
                <?php if ($page - 1 > 0): ?>
                    <li class="page-item"><a class="page-link" href="<?=\yii\helpers\Url::to(['/account/donations-history?' . http_build_query(array_merge($filter_form->attributes, ['page' => $page -2]))])?>"><?=$page -1?></a></li>
                <?php endif ?>
                <li class="page-item disabled">
                    <a class="page-link" href="<?=\yii\helpers\Url::to(['/account/donations-history?' . http_build_query(array_merge($filter_form->attributes, ['page' => $page]))])?>" tabindex="-1"><?=$page?></a>
                </li>
                <?php if ($page + 1 <= $pages): ?>
                    <li class="page-item"><a class="page-link" href="<?=\yii\helpers\Url::to(['/account/donations-history?' . http_build_query(array_merge($filter_form->attributes, ['page' => $page + 1]))])?>"><?=$page + 1?></a></li>
                <?php endif ?>
                <?php if ($page + 2 <= $pages): ?>
                    <li class="page-item"><a class="page-link" href="<?=\yii\helpers\Url::to(['/account/donations-history?' . http_build_query(array_merge($filter_form->attributes, ['page' => $page + 2]))])?>"><?=$page + 2?></a></li>
                <?php endif ?>
                <li class="page-item <?=$page == $pages ? "disabled" : ""?>">
                    <a class="page-link" href="<?=\yii\helpers\Url::to(['/account/donations-history?' . http_build_query(array_merge($filter_form->attributes, ['page' => $page + 1]))])?>"><?=Yii::t('site', 'Next')?></a>
                </li>
            </ul>
        </nav>
    <?php endif; ?>
</div>
<button class="type-4-btn mt-5 pdf-button">
    <span><?=Yii::t('site', 'DOWNLOAD_AS_PDF')?></span>
</button>

<?php
$this->registerJs(<<<JS
    $(".pdf-button").click(function(){
        $(".type").val('pdf');
        $("#donation-history-filter-form").submit();
    })
JS);