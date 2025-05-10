<?php

use common\helpers\Utility;
use yii\helpers\Url;

$currentRoute = Yii::$app->request->getUrl();

?>

<div class="container footer-section">
    <?php foreach ($menuLinks as $key => $item): ?>
        <div class="footer-item">
            <div class="footer-item-header">
                <h5><?= $item['label'] ?></h5>
                <?php if ($item['items']): ?>
                    <button class="toggleButton mobile-responsive" data-target="footer-item-<?= $key ?>">
                        <i class="fa-solid fa-plus"></i>
                        <i class="fa-solid fa-minus"></i>
                    </button>
                <?php endif; ?>
            </div>

            <?php if ($item['items']): ?>
                <ul id="footer-item-<?= $key ?>" class="footer-submenu">
                    <?php foreach ($item['items'] as $subItem): ?>
                        <li>
                            <a <?= $subItem['url'][0] ? Utility::PrintAllUrl($subItem['url'][0]) : ''; ?>
                                class=" <?= $subItem['active'] ? 'active' : '' ?> ">
                                <?= $subItem['label'] ?></a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>