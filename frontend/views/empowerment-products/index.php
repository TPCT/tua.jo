<?php

use yii\helpers\Url;
use kartik\form\ActiveForm;
use frontend\widgets\HeaderImage;

$this->title = Yii::t('site', 'EMPOWERMENT');
$this->registerCssFile("/theme/css/Empowerment-products.css", ['depends' => [\frontend\assets\AppAsset::className()],]);

$this->title = Yii::t('site', 'EMPOWERMENT');
$this->description = Yii::t('site', 'EMPOWERMENT_DESCRIPTION');

$lng = Yii::$app->language;
?>
<?php




?>
      
      <?= HeaderImage::widget(['is_inner'=> true , 'path'=>'/empowerment-products' ]) ?>



      <div class="container filter-inputs-container">
            
        <?php
            $form = ActiveForm::begin([
                'action' => Url::to(['/empowerment-products/index']),

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
                    'data-model' => "empowerment-products",
                    'data-pjax' => true

                ],
                
            ])
        ?>
        

        <?= $form->field($searchModel, 'sort')->dropDownList($searchModel->getSortList(),["prompt"=>Yii::t("site","SELECT_SORT"), 'data-url-name' => "sort","class"=>"first-select form-select  input-submit"])->label(false) ?>
                <?= $form->field($searchModel, "category_slug")->dropDownList($searchModel->getCategorySearchList(),['class' => 'form-select input-submit',"prompt"=> Yii::t('site', 'SELECT_Category'), 'data-url-name' => "category" ])->label(false) ?>

                <?php \kartik\form\ActiveForm::end(); ?>

       </div>



      <div id="items-section">
      <div id="items-container">

 
      <section class="empowerment-main-section">
        <div class="container">
   
        <?php foreach($EmpowermentProducts as $EmpowermentProduct) : ?>

       
            <div class="empowerment-card">

                <?= \frontend\widgets\WebpImage::widget(["src" => $EmpowermentProduct->image, "alt" => $EmpowermentProduct->title, "loading" => "lazy", 'css' => ""]) ?>

                <div class="empowerment-card-content">
                    <div>
                        <div class="product-price">
                            <h4> <?= $EmpowermentProduct->category->title ?> </h4>
                            <h4> 5  <?= Yii::t('site', 'JOD') ?></h4>
                        </div>
                        <p> <?= $EmpowermentProduct->title ?> </p>
                    </div>
                    <div class="buttons">
                        <a href="<?= Url::to(["/empowerment-products/view", "slug" => $EmpowermentProduct->slug]) ?>" id="Readbuttn" class="type-4-btn" style="opacity: 1; transform: translateX(0px); transition: 0.5s ease-in-out; display: flex; flex-shrink: 0;">
                          <span> <?= Yii::t('site', 'READ_MORE') ?> </span>
                          <i class="fa-solid fa-arrow-right"></i>
                        </a>

                        <?= frontend\widgets\cards_share_box_button\CardsShareBoxButton::widget([
                                'url' =>   $EmpowermentProduct->slug
                            ]); ?>

                    </div>
                </div>
            </div>

        <?php endforeach; ?>

           
        </div>
       


          
      </section>
      <div class="pagination by-ajax"  data-section="#items-section" data-container="#items-container">
             <?= \frontend\widgets\Pager::widget(['pagination' => $pagination]); ?>
      </div>

      </div>
    </div>

