<?php
use yii\helpers\Html;

?>
<div class="comment-one <?= ($index ? 'two' : '') ?>">
    <div class="comment-icon"><img src="/images/comment-icon.png" alt=""></div>
    <div class="comment-text">
        <p><?= Html::encode($model->content); ?></p>
    </div>
    <div class="clearfix"></div>
</div>
