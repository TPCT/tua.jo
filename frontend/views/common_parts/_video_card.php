<?php

use yii\helpers\Url;
$lng = Yii::$app->language;

$video = $item->youtube_link ?: $item->video;

?>


<div class="video-card <?= $video? '' : 'not-video' ?>">
    <picture>
        <img src="<?= $item->image?: Url::to('/images/photo-gallery-2/SpeechesThroneDefault.png') ?>" alt="<?= $item->title ?>"
        class="video-thumbnail" 
        <?= $video ? 'data-fancybox="video"' : "" ?>
        data-fancybox="video"
        data-type="ifram"
        data-caption="<p><?= $item->publishedDate2 ."<br/>".  $item->title ?></p>"
        data-src="<?= $video ?>"
        
        />
        <img src="<?= Url::to("/images/Icons/PlayCircle.svg") ?>" alt="" class="play-icon <?= $video? '' : 'd-none' ?>" />
    </picture>
    <div>
        <span><?= $item->publishedDate2; ?></span>
        <a href="/<?= $lng ?>/throne-speeches/<?= $item->slug ?>">
            <h3><?= $item->title; ?></h3>
        </a>
        <p><?= $item->brief; ?></p>
    </div>
</div>