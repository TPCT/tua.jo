<?php

use backend\modules\interviews\models\Interviews;

$lng = Yii::$app->language;

?>






<section class="press-room-inner-video-section">
    <div class="container">
        <div class="press-room-inner-video-section--content">
            <?php if ($item->country || $item->city): ?>
                <h5>
                    <?= $item->city ?>
                    <?php if ($item->city): ?>     
                        <?= $lng == 'en' ? ' , ' : ' ، ' ?>   
                    <?php endif; ?>
                    <?= $item->country ?>
                </h5>
            <?php endif; ?>

            <h2><?= $item->title ?></h2>
            <?php if(($item instanceof Interviews) && $item->media_outlet): ?>
                <h5><?= Yii::t('site', 'MediaOutlet') . '&nbsp;' .  $item->media_outlet ?></h5>
            <?php endif; ?>
            <?php if(($item instanceof Interviews) && $item->interviewer): ?>
                <h5><?= Yii::t('site', 'InterviewerName') . '&nbsp;' . $item->interviewer ?></h5>
            <?php endif; ?>

            <h5><?= $item->publishedDate2 ?></h5>
            <?php if(isset($item->trailer)): ?>
                <h5> <?= $item->trailer ?> </h5>
            <?php endif; ?>
        </div>
        <?= $this->render('//common_parts/_single_vidoe_in_page.php', ['item'=>$item]) ?>
        
    </div>
</section>

