<?php

use common\helpers\Utility;


$currentRoute = Yii::$app->request->getUrl();
$lng = Yii::$app->language;

?>



<div class="blue-sub-header">
    <div class="container d-flex flex-column justify-content-center h-100 gap-4">
        <h2><?= Yii::t('site', 'By His Majesty'); ?></h2>
        <div class="blue-sub-header-list multiple-items">
            <?php foreach ($menuLinks as $item): ?>
                <div>
                    <a <?= $item['url'][0] ? Utility::PrintAllUrl($item['url'][0]) : ''; ?>
                        class=" <?= $item['active'] ? 'current-active' : '' ?> ">
                        <?= $item['label'] ?>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>