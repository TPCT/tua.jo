<?php

/* @var $this yii\web\View */

use ruskid\jssocials\JsSocials;
use yeesoft\comments\widgets\Comments;
use yeesoft\page\models\Page;
use yii\helpers\Html;

$this->title = Yii::t('site', 'Password recovery');

?>


<!-- Start Banner -->
<?php $this->beginBlock('top-banner'); ?>
<div class="inner_banner">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h2><?= Yii::t('site', 'Reset Password') ?></h2>
			</div>
		</div>
	</div>
</div>
<?php $this->endBlock(); ?>
<!-- End Banner -->


<!-- content region -->

<div class="commonpage ">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="commonpage_gapping userprofile_main ">
					<h3> <?= Yii::t('site', 'Check your E-mail for further instructions') ?></h3>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- End content region -->