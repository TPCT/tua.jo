<?php
/* @var $this \yii\web\View */

use frontend\widgets\breadcrumbs\BreadCrumbs;
use yeesoft\helpers\Html;

$lng = Yii::$app->language;
?>


    <?php if($webp_iamge): ?>
        <?php
        $css = <<<CSS

            .main-stars-header {
                background-image: url($webp_iamge) !important;
            }
        CSS;

        $this->registerCss($css);
        ?>
    <?php endif; ?>

    <?php if($webp_mobile_image): ?>
        <?php
        $css = <<<CSS

            @media (max-width: 767.98px) {
                .main-stars-header {
                    background-image: url($webp_mobile_image)  !important;
                }
            }
        CSS;

        $this->registerCss($css);
        ?>
    <?php endif; ?>

    <section class="header-section d-flex align-items-end gap-5">
      <div class="header-section-container container d-flex flex-column gap-3">
        <h1> <?= $title ?> </h1>
        <?= BreadCrumbs::widget([
 
                'is_inner'=>$is_inner,
                'bread_crumb_slug'=>$bread_crumb_slug,
                'is_clickable'=>$is_clickable,
                'bread_crumb_title'=>$bread_crumb_title,
            ]) 
        ?>

      </div>
    </section>

