<?php

use borales\extensions\phoneInput\PhoneInput;
use common\helpers\Utility;
use yii\helpers\Url;	

$currentRoute = Yii::$app->request->getUrl();

$session = Yii::$app->session;

?>



	<?php if($needHelp): ?>
		<section class="helping-sec">
			<div class="container-fluid">
				<div class="row">
					<div class="col-xl-12 mx-auto">
						<div class="row helping-box">
							<div class="col-xl-8">
								<div class="helping-content">
									<h1><?= $needHelp->title ?></h1>
									<div>
										<?= $needHelp->brief ?>
									</div>
									<div class="helping-form">
										<?php $form =  \kartik\form\ActiveForm::begin([
											'action' => ['/site/newsletter-subscribe'],
											'id' => 'newsletter-form',
											'options' => ['class' => 'clearfix'],
										]) ?>
											
											<ul class="helping-form-ul">
												<li class="helping-form-li"><i class="fal fa-user"></i>
													<?= $form->field($model, 'name')->textInput(['maxlength' => true])->label(false)  ?>
												</li>
												<li class="helping-form-li"> <i class="fal fa-mobile-android"></i>
													<?= 
														$form->field($model, 'phone',['inputOptions' => ['placeholder' => $model->getAttributeLabel('phone'), 'class'=>'form-control need-help-phone-input'], ])->widget(PhoneInput::className(), [
															'jsOptions' => [
																'initialCountry' => 'JO', // auto not working
																'placeholderNumberType' => 'FIXED_LINE',
																'nationalMode' => false,
																'separateDialCode'=>true,
																'class'=>'form-control border need-help-phone-input',
																'excludeCountries'=>['IL'], //unknown fucken country
															],
														])->label(false);
													?>
												<li class="helping-form-li"><a href="javascript:void(0);" id="newsletter-submit-btn" class="btn-style-help"> <?= Yii::t('site','REQUEST_CALL_BACK') ?> </a></li>
											</ul>
										<?php \kartik\form\ActiveForm::end(); ?>
										
									</div>
								</div>
							</div>
							<div class="col-xl-4 mt-3">
								<div>
									<?= \frontend\widgets\WebpImage::widget(["src" => Url::to($needHelp->image), "alt" => $needHelp->title ,"loading" => "",'css'=>""]) ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	<?php endif; ?>