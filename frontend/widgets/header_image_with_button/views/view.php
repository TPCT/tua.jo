<?php

use common\helpers\Utility;
use frontend\widgets\LanguageSelectorMobile;
use yeesoft\helpers\Html;
use yii\helpers\Url;	

?>

    <?= Html::style( ".header-image-backgroud-image { background-image: url({$webp_iamge}); background-size: cover;  }" ) ?>
    <div class="news-inner-banner header-image-backgroud-image " >
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="news-inner-content">
                        <h3> <?= $title ?> </h3>
                        <p> <?= $brief ?> </p>
                        <?php if($url): ?>
                            <a <?= Utility::PrintAllUrl($url) ?> class="btn-style-one white" tabindex="-1">
                                <span> <?= $buttonText ?> </span>
                                <i class="far fa-long-arrow-right"></i>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
