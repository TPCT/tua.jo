<?php

use yeesoft\widgets\assets\LanguageSelectorAsset;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

LanguageSelectorAsset::register($this);

//var_dump($url, $params, Yii::$app->urlManager->createUrl(ArrayHelper::merge($params, [$url, 'language' => 'ar'])));
?>


<?php foreach ($languages as $key => $lang) : ?>
    <?php $link = Yii::$app->urlManager->createUrl(ArrayHelper::merge($params, [$url, 'language' => $key])); ?>
    <?php if (Yii::$app->yee->getDisplayLanguageShortcode($language) != $key) : ?>
            <a class="single-nav-lang-switcher" href="<?= $link ?>"> 
            <div class="icon-container">
            <span>  </span>

            </div>
            </a>
        
    <?php endif; ?>
<?php endforeach; ?>