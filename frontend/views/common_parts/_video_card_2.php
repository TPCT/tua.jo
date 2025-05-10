<?php

use frontend\assets\YoutubeAsset;

YoutubeAsset::register($this);

use yii\helpers\Url;
$lng = Yii::$app->language;

preg_match("/embed\/([a-zA-Z0-9_-]+)/", $item->youtube_link, $matches);
$videoId = $matches[1] ?? null;

?>

<div class="video-card  <?= $videoId? '' : 'not-video' ?>">

    <div class="youtube position-relative" data-id="<?= $videoId ?>" 
        data-fancybox="video"
        <?= $item->youtube_link ? 'data-fancybox="video"' : "" ?>
        data-type="ifram"
        data-caption="<p><?= $item->publishedDate2 ."<br/>".  $item->title ?></p>"
        data-src="<?= $item->youtube_link ?>"
    >
        <img src="<?= Url::to("/images/Icons/PlayCircle.svg") ?>" alt="" class="play-icon <?= $videoId? '' : 'd-none' ?>" />
    </div>
    <div>
        <span><?=$item->publishedDate2?></span>
        <h3><?=$item->title?></h3>
    </div>
</div>

