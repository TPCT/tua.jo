<?php

use yii\helpers\Url;
use kartik\form\ActiveForm;
use frontend\widgets\HeaderImage;

use frontend\widgets\RatingWebformWidget;


$this->registerCssFile("/theme/css/LatestNews.css", ['depends' => [\frontend\assets\AppAsset::className()],]);
$this->registerCssFile("/theme/css/Blogs.css", ['depends' => [\frontend\assets\AppAsset::className()],]);

$this->title = Yii::t('site', 'NEWS');
$this->description = Yii::t('site', 'NEWS_DESCRIPTION');

$lng = Yii::$app->language;
?>
<?php




?>


      
      <?= HeaderImage::widget(['is_inner'=> true , 'path'=>'/news' ]) ?>


      <section class="latest-added-section pt-5">
        <div class="container">

        <?php
            $form = ActiveForm::begin([
                'action' => Url::to(['/news/index']),

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
                    'data-model' => "news",
                    'data-pjax' => true

                ],
                
            ])
        ?>

          <div
            class="head-latest-news d-flex align-items-center justify-content-between"
          >
            <h3> <?=  Yii::t('site', 'FILTERS_BY_YEAR') ?> </h3>

            <?= $form->field($searchModel, "year")->dropDownList($searchModel->getYearsList(),['class' => 'form-select input-submit',"prompt"=> Yii::t('site', 'SELECT_YEAR'), 'data-url-name' => "year" ])->label(false) ?>

          </div>
          <?php \kartik\form\ActiveForm::end(); ?>
          <div class="latest-added-container mt-5 target-div">

          <?php foreach($latestNews as $latestNew) : ?>

            <div class="latest-added-card ">
              <div
                class="box-latest-news-added d-flex align-items-center flex-column justify-content-between h-100"
              >
    
                <?= \frontend\widgets\WebpImage::widget(["src" => $latestNew->image, "alt" => $latestNew->title, "loading" => "lazy", 'css' => "mw-100"]) ?>

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
                    <h5 class="date-content">  <?= $latestNew->getPublishedAtFullDate($latestNew->published_at) ?> </h5>
                  </div>
                  <div
                    class="latest-news-added-info d-flex flex-column justify-content-between h-100"
                  >
                    <h4 class="h-100">
                       <?= $latestNew->title ?> 
                    </h4>
                    <div class="buttons">
                      <a href="<?= Url::to(["/news/view", "slug" => $latestNew->slug]) ?>" class="type-4-btn">
                        <span> <?= Yii::t('site', 'READ_MORE') ?> </span>
                        <i class="fa-solid fa-arrow-right"></i>
                      </a>
                      <?= frontend\widgets\cards_share_box_button\CardsShareBoxButton::widget([
                                'url' =>   $latestNew->slug
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

      <div id="items-section">
      <div id="items-container">

      <section class="latest-news-section my-5 pb-4 target-section" >
        <div class="container">
          <div class="see-more-container py-5">
            <h3> <?= Yii::t('site', 'MORE_NEWS') ?></h3>
          </div>
          <div class="latest-news-container">

          <?php foreach($news as $new) : ?>

          <?php
                $objectFit = $new->object_fit?: 'contain';
                $css = <<<CSS
                    .news-image-$new->id{
                    object-fit: $objectFit !important;
                    object-position: $new->object_position !important;
                    }
                CSS;
                $this->registerCss($css);
            ?>

            <div class="lastest-news-card mb-4">
              <div
                class="box-latest-news d-flex align-items-center justify-content-between h-100
            
                "
              >

                <?= \frontend\widgets\WebpImage::widget(["src" => $new->image, "alt" => $new->title, "loading" => "lazy",     'css' => "mw-100 news-image-$new->id"]) ?>

                
                <div
                  class="latest-news-content d-flex flex-column justify-content-between py-3 px-3 gap-2 h-100"
                >
                  <div class="date d-flex align-items-center gap-2">
                    <picture>
                      <img
                        src="/theme/assets/Icons/CalendarDot.svg"
                        alt=""
                        class="mw-100"
                      />
                    </picture>
                    <h5 class="date-content"> <?= $new->getPublishedAtFullDate($new->published_at) ?>  </h5>
                  </div>
                  <div
                    class="latest-news-info d-flex flex-column justify-content-between gap-3 h-100"
                  >
                    <h4 class="h-100">
                        <?= $new->title ?>
                    </h4>
                    <div class="buttons">
                      <a href="<?= Url::to(["/news/view", "slug" => $new->slug]) ?>" class="type-4-btn">
                        <span> <?= Yii::t('site', 'READ_MORE') ?> </span>
                        <i class="fa-solid fa-arrow-right"></i>
                      </a>
                      <?= frontend\widgets\cards_share_box_button\CardsShareBoxButton::widget([
                                'url' =>   $new->slug
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

      <div class="pagination by-ajax"  data-section="#items-section" data-container="#items-container">
             <?= \frontend\widgets\Pager::widget(['pagination' => $pagination]); ?>
      </div>

      </div>
    </div>
