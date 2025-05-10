<?php

use common\helpers\Utility;
use frontend\widgets\LanguageSelectorMobile;
use yii\helpers\Url;

$currentRoute = Yii::$app->request->getUrl();
$lng = Yii::$app->language;

?>


<?php if (isset($siteMapMenuParents)) : ?>

    <?php foreach ($siteMapMenuParents as $key => $item) : ?>
        <div class="col-lg-6 site-map-strategiecs">
            <div class="">
                <div class=" site-map-item d-flex align-items-center justify-content-between">
                    <a <?= Utility::PrintAllUrl($item->link) ?>>
                        <h4> <?= $item->label ?> </h4>
                    </a>
                    <?php if ($item->childs) : ?>
                        <button class="site-map-button" data-bs-target="<?= $item->id ?>">
                            <i class="fa-solid fa-chevron-down to-rotate" ></i>
                        </button>
                    <?php endif; ?>
                </div>
                <?php if ($item->childs) : ?>
                    <ul id="<?= $item->id ?>">
                        <?php foreach ($item->childs as $key => $subItem) : ?>
                            <li>
                                <a <?= $subItem->link ? Utility::PrintAllUrl($subItem->link) : ''; ?>> <?= $subItem->label ?> </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>


    <?php endforeach; ?>




<?php endif; ?>
