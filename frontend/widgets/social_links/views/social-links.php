<?php

use yii\helpers\Url;

?>


<li class="footer-stay-in-touch">

            <?php if(Yii::$app->settings->get('site.twitter_link')): ?>
                <a target="blank" rel="noopener noreferrer nofollow" href="<?= Yii::$app->settings->get('site.twitter_link') ?>">
                    <i class="fa-brands fa-x-twitter"></i>
                </a>
            <?php endif; ?>

            <?php if(Yii::$app->settings->get('site.facebook_link')): ?>

                <a target="blank" rel="noopener noreferrer nofollow" href="<?= Yii::$app->settings->get('site.facebook_link') ?>">
                    <i class="fa-brands fa-facebook-f"></i>
                </a>
            <?php endif; ?>

            <?php if(Yii::$app->settings->get('site.youtube_link')): ?>

                <a target="blank" rel="noopener noreferrer nofollow" href="<?= Yii::$app->settings->get('site.youtube_link') ?>">
                <i class="fa-brands fa-youtube"></i>
                </a>
    
            <?php endif; ?>

            <?php if(Yii::$app->settings->get('site.instagram_link')): ?>

            <a target="blank" rel="noopener noreferrer nofollow" href="<?= Yii::$app->settings->get('site.instagram_link') ?>">
                <i class="fa-brands fa-instagram"></i>
            </a>
            <?php endif; ?>

            <?php if(Yii::$app->settings->get('site.linked_in')): ?>

                <a target="blank" rel="noopener noreferrer nofollow" href="<?= Yii::$app->settings->get('site.linked_in') ?>">
                    <i class="fa-brands fa-linkedin"></i>
                </a>
            <?php endif; ?>

           
            
          
            </li>

