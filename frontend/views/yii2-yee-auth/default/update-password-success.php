<?php

/* @var $this yii\web\View */

use ruskid\jssocials\JsSocials;
use yeesoft\comments\widgets\Comments;
use yeesoft\page\models\Page;
use yii\helpers\Html;

$this->title = Yii::t('site', 'Password recovery');

?>


<?php $this->beginBlock('header-image'); ?>
<div class="banner">
    <img src="<?= \common\helpers\Utility::getHeaderImage(null, ''); ?>" class="img-responsive">
</div>
<?php $this->endBlock(); ?>



<!-- content region -->
<div class="container text-center">
    <div class="jobInnerOut blueText">
        <h3><?= Yii::t('site', 'Password has been updated') ?></h3>
    </div>
</div>
<!-- End content region -->