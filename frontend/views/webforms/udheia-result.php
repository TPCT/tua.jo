<?php

use yii\helpers\Url;
use kartik\form\ActiveForm;
use frontend\widgets\HeaderImage;
use frontend\widgets\breadcrumbs\BreadCrumbs;

use frontend\widgets\RatingWebformWidget;

$this->title = Yii::t('site', 'UDHAIA_RESULT');
$this->description = Yii::t('site', 'UDHAIA_RESULT_DESCRIPTION');

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
        <?= BreadCrumbs::widget(['is_inner'=> false , 'bread_crumb_slug'=>  $slug, ]) ?>

        <div class="udhiyah-main-container">
            <div class="udhiyah-main-container-header">

                <h3>  <?= Yii::t('site', 'HAPPY_EID')  ?> </h3>
                <h4>  <?= Yii::t('site', 'HAPPY_EID_PERFORMANCE')  ?> </h4>
            </div>
            <div class="udhiyah-main-container-item">
                <p>  <?= Yii::t('site', 'RECEIPT_NUMBER')  ?> </p>
                <p> <?= $apiResponse[0]['ReceiptNumber'] ?>  </p>
            </div>
            <div class="udhiyah-main-container-item">
                <p> <?= Yii::t('site', 'STATUS')  ?> </p>
                <p>   <?= $apiResponse[0]['State'] ? Yii::t('site', 'PERFORMED') : Yii::t('site', 'NON_PERFORMED')?>   </p>
            </div>
            <div class="udhiyah-main-container-item">
                <p>  <?= Yii::t('site', 'NUMBER_OF_UDHEIA')  ?>  </p>
                <p ><?= $apiResponse[0]['Number'] ?> </p>
            </div>
           
              <a  href="<?= Url::to(["/"])  ?>"  class="type-4-btn mx-4 my-3">
                <span>  <?= Yii::t('site', 'GO_TO_HOME_PAGE')  ?>  </span></a>
        </div>
      </div>
    </section>
