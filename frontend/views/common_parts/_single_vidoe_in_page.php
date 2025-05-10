<?php

use yii\helpers\Url;

$video = $item->youtube_link?$item->youtube_link :$item->video;

?>



    <div class="press-room-inner-video-section--img <?= $video? '' : 'not-video' ?>">
        <picture 
            class="video-thumbnail" 
            
            <?= $video ? 'data-fancybox="video"' : "" ?>
            data-type="ifram"
            data-caption="<p> <?= $item->publishedDate2 ."<br/>".  $item->brief ?> </p>"
            data-src="<?= $video ? $video :'' ?>"
            
        >
            <img src="<?= $item->image?:'/images/photo-gallery-2/Speeches.png' ?>" alt="" />
        </picture>
    </div>

