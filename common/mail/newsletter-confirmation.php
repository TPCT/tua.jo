<?php
use kartik\helpers\Html;
use yii\helpers\Url;

?>

<h3><p><?= Yii::t('site', 'Hello')?>,</p></h3>



<p><?= Yii::t('site', "Your request to subscribe to STRATEGIECS newsletter has been received. To confirm, please click on the link below:") ?></p>

<p><?= Html::a(Url::toRoute(["/site/newsletter-confirm", "email" => $email], true), Url::toRoute(["/site/newsletter-confirm", "email" => $email], true)); ?></p>
