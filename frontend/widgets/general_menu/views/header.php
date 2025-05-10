<?php

use common\helpers\Utility;
use frontend\widgets\LanguageSelectorMobile;
use yii\helpers\Url;

$currentRoute = Yii::$app->request->getUrl();
$lng = Yii::$app->language;

// var_dump($menuLinks);
// die;
?>



<?php foreach ($menuLinks as $item): ?>
    <li>
        <a <?= $item['url'][0] ? Utility::PrintAllUrl($item['url'][0]) : ''; ?>
            class=" <?= $item['active'] ? 'active' : '' ?> ">
            <?= $item['label'] ?>
        </a>
    </li>
<?php endforeach; ?>