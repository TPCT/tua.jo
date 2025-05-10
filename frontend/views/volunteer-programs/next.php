<?php 
use yii\helpers\Url; 

?>

<?php foreach($volunteerPrograms as $volunteerProgram) : ?>

<?php
                $objectFit = $volunteerProgram->object_fit?: 'contain';
                $css = <<<CSS
                    .volunteerProgram-image-$volunteerProgram->id{
                    object-fit: $objectFit !important;
                    object-position: $volunteerProgram->object_position !important;
                    }
                CSS;
                $this->registerCss($css);
            ?>


<div class="latest-added-card mb-4 extra-content">
  <div
    class="box-latest-news-added d-flex align-items-center flex-column justify-content-between h-100"
  >

    <?= \frontend\widgets\WebpImage::widget(["src" => $volunteerProgram->image, "alt" => $volunteerProgram->title, "loading" => "lazy", 'css' => "volunteerProgram-image-$volunteerProgram->id  mw-100"]) ?>


    <div
      class="latest-news-added-content d-flex flex-column justify-content-between px-3 pb-4 mt-2 gap-2 h-100"
    >
      <h4> <?= $volunteerProgram->title ?></h4>
      <div
        class="latest-news-added-info d-flex flex-column justify-content-between h-100"
      >
        <p class="h-100 volunteering-programs-brief">
        <?= $volunteerProgram->brief ?>
        </p>
        <div class="buttons">
          <a href="<?= Url::to(["/volunteer-programs/view", "slug" => $volunteerProgram->slug]) ?>" class="type-4-btn">
            <span>  <?= Yii::t('site', 'APPLY_NOW') ?>  </span>
            <i class="fa-solid fa-arrow-right"></i>
          </a>
          <?= frontend\widgets\cards_share_button\CardsShareButton::widget() ?>

        </div>
      </div>
    </div>
  </div>
</div>
<?php endforeach; ?>