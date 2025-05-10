<?php

use common\helpers\Utility;
use yii\helpers\Url;

$currentRoute = Yii::$app->request->getUrl();

?>

<div class="container footer-section">
    <?php foreach ($menuLinks as $key => $item): ?>
        <div class="footer-item">
            <?php //if(isset($item['url'])): ?>
                <div class="footer-item-header">
                <a class="<?=$item['url'][0]?'footer_link_bottom':'footer_link_bottom_no_style'?>" <?= $item['url'][0] ? Utility::PrintAllUrl($item['url'][0]) : ''; ?> ><h5><?= $item['label'] ?></h5></a>
                    <?php if ($item['items']): ?>
                        <button class="toggleButton mobile-responsive" data-target="footer-item-<?= $key ?>">
                            <i class="fa-solid fa-plus"></i>
                            <i class="fa-solid fa-minus"></i>
                        </button>
                    <?php endif; ?>
                </div>
            <?php //endif; ?>

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