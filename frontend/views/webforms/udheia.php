<?php

use yii\helpers\Url;
use kartik\form\ActiveForm;
use frontend\widgets\HeaderImage;

use frontend\widgets\RatingWebformWidget;
use frontend\widgets\breadcrumbs\BreadCrumbs;


$this->title = Yii::t('site', 'UDHAIA');
$this->description = Yii::t('site', 'UDHAIA_DESCRIPTION');


$this->registerCssFile("/theme/css/Check-Your-Udhiyah.css", ['depends' => [\frontend\assets\AppAsset::className()],]);


$lng = Yii::$app->language;
?>
    <section class="udhiyah-main">
      <div class=" container d-flex flex-column align-items-start justify-content-start">
        <!-- <div class="container breadcrumb-without-header-section d-flex align-items-center justify-content-between">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active"><a href="#">Check Your Udhiyah</a></li>
              </ol>
            </nav>
        </div> -->
        <?= BreadCrumbs::widget(['is_inner'=> false  ]) ?>

        <div class="udhiyah-main-container">
  
                
            <?php
                 $form = \kartik\form\ActiveForm::begin([
                     'id' => 'zaka-form',
                    'method' => 'post',
                    'options'=>[
                         'class'=>'contact-us-form udhiyah-main-container-content',
                          
                        'data-pjax' => true,
                     ],
                     'enableAjaxValidation' => false,
                    'enableClientValidation' => true,
                 
                                        
                ]); 
            ?>

            
<?php if (Yii::$app->session->hasFlash('error')) : ?>
              <div class="alert alert-danger alert-dismissable">
                  <button aria-hidden="true" data-bs-dismiss="alert" class="close btn" type="button">×</button>
                  <?= Yii::$app->session->getFlash('error')[0] ?>
              </div>
              <?php endif; ?>

              <?php if($udheiaBlock): ?>
 
                  <h3> <?= $udheiaBlock->title ?> </h3>
                  <?= $udheiaBlock->content ?>
              <?php endif; ?>

                <div class="col-lg-12 col-12 d-flex flex-column gap-3 mb-3">
           
                 <?= $form->field($model, 'reciept_number')->textInput([ 'maxlength' => true,'placeholder' => Yii::t("site", "RECEIPT_NUMBER_PLACEHOLDER")])->label(); ?>

               </div>
               <div class="col-12">
                    <?= $form->field($model, 'reCaptcha', [])->widget(\himiklab\yii2\recaptcha\ReCaptcha::className())->label(false); ?>

                    </div>
                   <button type="submit" class="type-4-btn  my-3">
                          <span> <?= Yii::t('site', 'SUBMITE')  ?>  </span>
              
                  </button>
                <?php \kartik\form\ActiveForm::end(); ?>
        </div>
      </div>
    </section>
