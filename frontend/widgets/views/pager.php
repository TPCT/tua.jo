<?php

use yii\widgets\LinkPager;

?>

<div class="container">
    <div class="col-12 d-flex pagination-wrapper justify-content-center px-5 container-fluid py-4">
        <nav aria-label="Page  mt-0"> 
            <?= LinkPager::widget([
                'pagination' => $pagination,
                'options' => ['class' => 'pagination justify-content-start gap-3 pagination-container mb-0'],
                'linkOptions' => ['class' => 'page-link rounded-circle'],
                'prevPageLabel' => $this->render('//common_parts/_prev_arrow_svg.php') ,
                'nextPageLabel' => $this->render('//common_parts/_next_arrow_svg.php'),
                'prevPageCssClass' => 'page-item prev', 
                'nextPageCssClass' => 'page-item next', 
                'disabledPageCssClass' => 'disabled', 
                'activePageCssClass' => 'active', 
                'pageCssClass' => 'page-item', 
                'firstPageCssClass' => 'd-none', 
                'lastPageCssClass' => 'd-none',
                'disabledListItemSubTagOptions' => ['class' => 'page-link'],
                'maxButtonCount' => 6, 
            ]) ?>
        </nav>
    </div>
</div>
