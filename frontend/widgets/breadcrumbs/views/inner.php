<?php 
    $total = count($crumbs);
    $i= 0; 
?>
<div class="links-nav d-flex align-items-center justify-content-between">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <?php foreach($crumbs as $key => $value): ?>
                <li class="breadcrumb-item breadcrumb-link">
                    <?php $i++ ?>
                    <?php if( ($is_clickable === false ) && ( $total-1 == $i ) ) : ?>
                        <?=  Yii::t('site', $key) ?>
                    <?php else : ?>
                            <a href="<?=$value?>"> <?=  Yii::t('site', $key) ?>  </a>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
            <?php if($bread_crumb_title) : ?>
                <li class="breadcrumb-item">
                    <a href="#"> <?= $bread_crumb_title?>  </a>
                </li>
            <?php endif; ?>


    
        </ol>
    </nav>
    <?= frontend\widgets\share_button\ShareButton::widget() ?>

</div>