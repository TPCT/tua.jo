<?php

/* @var $this yii\web\View */


$this->title = $title;
?>


<?php $this->beginBlock('top-banner'); ?>
<?= $this->title; ?>
<?php $this->endBlock(); ?>
<!-- End Banner -->



<div class="photo_gallery">
    <div class="container">
        <div class="row photo_gallery_content">
            <div class="col-md-12">
                <div class="gallery_content newseventsdtls">
                <?= $msg; ?>
              </div>
            </div>
        </div>
    </div>
</div>