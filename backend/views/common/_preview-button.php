<?php

use yeesoft\helpers\Html;
use yii\helpers\Url;

?>

<?php if($with_preview): ?>
    <?php $completeUrl = get_class($model) == "yeesoft\page\models\Page"? "/index?slug=" : "/view?slug="; ?>
    <a href='<?= yii\helpers\Url::to( "https://". Yii::$app->params["FrontendUrlDomain"]."/".$front_url. $completeUrl. $model->slug . "&revision=1" ) ?>' class="btn btn-sm btn-success " target="_blank"><?= Yii::t("site","Preview") ?></a>
<?php endif; ?>