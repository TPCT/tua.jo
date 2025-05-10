<?php

use yii\helpers\Url;
use kartik\form\ActiveForm;
use frontend\widgets\HeaderImage;

$this->title = Yii::t('site', 'ZAKAT_STORIES');
$this->description = Yii::t('site', 'ZAKAT_STORIES_DESCRIPTION');


$this->registerCssFile("/theme/css/LatestNews.css", ['depends' => [\frontend\assets\AppAsset::className()],]);
$this->registerCssFile("/theme/css/Blogs.css", ['depends' => [\frontend\assets\AppAsset::className()],]);

$this->registerCssFile("/theme/css/ZakatStories.css", ['depends' => [\frontend\assets\AppAsset::className()],]);


$lng = Yii::$app->language;
?>
<?php




?>

<?= HeaderImage::widget(['is_inner'=> true , 'path'=>'/zakat-stories' ]) ?>

<div id="items-section">
            <div id="items-container">
      <section class="latest-added-section py-5">
        <div class="container">
        <?php
            $form = ActiveForm::begin([
                'action' => Url::to(['/zakat-stories/index']),

                'id' => 'news-search',
                'method' => 'post',
                
                'formConfig' => [
                    'showHints' => false,
                ],
                'fieldConfig' => [
                    'options' => [
                        'tag' => false,
                    ],
                ],
                'options' => [
                    'autocomplete' => 'off',
                    'class'=>'official-announcements-wrapper ajax-scroll-filter module-search-post',
                    'data-section'=>'#items-section',
                    'data-contanier'=>'#items-container',
                    'data-model' => "zakat-stories",
                    'data-pjax' => true

                ],
                
            ])
        ?>
          <div
            class="head-latest-news d-flex align-items-center justify-content-between"
          >
            <h3><?=  Yii::t('site', 'ZAKAT_LATEST_ADDED') ?></h3>
            <?= $form->field($searchModel, "year")->dropDownList($searchModel->getYearsList(),['class' => 'form-select input-submit',"prompt"=> Yii::t('site', 'SELECT_YEAR'), 'data-url-name' => "year" ])->label(false) ?>

 
          </div>
          <?php \kartik\form\ActiveForm::end(); ?>
  
          <div class="latest-added-container mt-5">

          <?php foreach($zakat_stories as $zakat_story) : ?>

          <?php
                $objectFit = $zakat_story->object_fit?: 'contain';
                $css = <<<CSS
                    .zakat_story-image-$zakat_story->id{
                    object-fit: $objectFit !important;
                    object-position: $zakat_story->object_position !important;
                    }
                CSS;
                $this->registerCss($css);
            ?>

            <div class="latest-added-card mb-4">
              <div
                class="box-latest-news-added d-flex align-items-center flex-column justify-content-between h-100"
              >

                <?= \frontend\widgets\WebpImage::widget(["src" => $zakat_story->image, "alt" => $zakat_story->title, "loading" => "lazy", 'css' => "zakat_story-image-$zakat_story->id mw-100"]) ?>

                <div
                  class="latest-news-added-content d-flex flex-column justify-content-between px-3 pb-4 mt-2 gap-2 h-100"
                >
                  <div class="date d-flex align-items-center gap-2">
                    <picture>
                      <img
                        src="/theme/assets/Icons/CalendarDot.svg"
                        alt=""
                        class="mw-100"
                      />
                    </picture>
                    <h5 class="date-content"> <?= $zakat_story->getPublishedAtFullDate($zakat_story->published_at) ?> </h5>
                  </div>
                  <div
                    class="latest-news-added-info d-flex flex-column justify-content-between h-100"
                  >
                    <h2 class="h-100">
                      <?= $zakat_story->title ?>
                    </h2>
                    <div class="buttons">
                      <a href="<?= Url::to(["/zakat-stories/view", "slug" => $zakat_story->slug]) ?>" class="type-4-btn">
                        <span>  <?= Yii::t('site', 'READ_MORE') ?> </span>
                        <i class="fa-solid fa-arrow-right"></i>
                      </a>
                      <?= frontend\widgets\cards_share_box_button\CardsShareBoxButton::widget([
                                'url' =>  '/' . $zakat_story->slug
                            ]); ?>

                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php endforeach; ?>

    
          </div>
        </div>
      </section>
      <!-- End Latest Added Section -->

        <div class="pagination by-ajax"  data-section="#items-section" data-container="#items-container">
              <?= \frontend\widgets\Pager::widget(['pagination' => $pagination]); ?>
        </div>

      </div>
    </div>

