<?php
/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;

Yii::$app->assetManager->forceCopy = true;
AppAsset::register($this);
//ThemeAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <link rel="shortcut icon" href="/images/favicon.ico" type="image/x-icon"/>

    <?php $this->head() ?>


</head>
<body>
<?php $this->beginBody() ?>


<?= $content ?>





<?php $this->endBody() ?>



</body>
</html>
<?php $this->endPage() ?>

