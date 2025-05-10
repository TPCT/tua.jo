<?php

use common\helpers\Content;
use frontend\assets\AppAsset;
use frontend\assets\CustomAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\AccesabilityAssets;



AppAsset::register($this);
AccesabilityAssets::register($this);

CustomAsset::register($this);
$lng = Yii::$app->language;

?>

<?php $this->beginPage() ?>

<!doctype html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=2.0">
    <meta name="format-detection" content="telephone=no">

    <?= $this->renderMetaTags() ?>

    <?php $this->head() ?>

    <?= Html::csrfMetaTags() ?>

</head>
<body>
<?php $this->beginBody() ?>

<main id="<?= $this->params['mainIdName'] ?? '' ?>" class="<?= (Yii::$app->language == 'en') ? '' : 'arabic-version' ; ?>" >

    <nav class="simple-nav">
        <div class="container d-flex justify-content-between align-items-center">
            <a href="<?= Url::to(["/"])  ?>" class="logo-container">
                <picture>
                    <?php if(!(Yii::$app->settings->get('site.logo', null, $lng))): ?>
                        <img src="/theme/assets/Images/login-register-logo.png" alt="" />
                    <?php else: ?>
                        <img src="<?= Yii::$app->settings->get('site.logo', null, $lng)??'' ?>" alt="<?= Yii::$app->settings->get('site.title', null, $lng) ?>" />
                    <?php endif; ?>
                </picture>
            </a>

            <?=\frontend\widgets\LanguageSelector::widget()?>
        </div>
    </nav>

    <?= Content::inlineStyleToClasses($content)  ?>
</main>
<?php $this->endBody() ?>

</body>
</html>
<?php $this->endPage() ?>

