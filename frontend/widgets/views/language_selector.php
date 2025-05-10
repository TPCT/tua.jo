<?php

use yeesoft\widgets\assets\LanguageSelectorAsset;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

LanguageSelectorAsset::register($this);
?>




<?php foreach ($languages as $key => $lang) : ?>
    <?php
    $link = Yii::$app->urlManager->createUrl(ArrayHelper::merge($params, [$url, 'language' => $key]));
    $link = str_replace('%2F', '/', $link);
    ?>
    <?php if (Yii::$app->yee->getDisplayLanguageShortcode($language) != $key) : ?>
        <a href="<?=$link?>" class="text-decoration-none text-dark">
            <span><?=$lang?></span>
            <picture>
                <img src="/theme/assets/Icons/GlobeSimple-dark.svg" alt="">
            </picture>
        </a>
        <?php break; ?>
    <?php endif; ?>
<?php endforeach; ?>



