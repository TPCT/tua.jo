<?php

use common\helpers\Utility;
use kartik\form\ActiveForm;
use kartik\helpers\Html;
use yii\helpers\Url;
use frontend\widgets\HeaderImage;

$this->title = Yii::t("site", "SEARCH");
$this->registerCssFile("/theme/css/SearchInner.css", ['depends' => [\frontend\assets\AppAsset::className()],]);

$lng = Yii::$app->language;



?>




<main>

    <?= HeaderImage::widget(['currentBreadCrump'=>$this->title]) ?> 

    <?php
    $form = ActiveForm::begin([
        'formConfig' => [
            'showHints' => false,
        ],
        'fieldConfig' => [
            'options' => [
                'tag' => false,
            ],
        ],
        'action' => Url::to(['/site/search',]),
        //'enableAjaxValidation' => true,
        'options' => [
            'class' => 'mb-3 container search-form-container',
            'id' => "search-form"
        ],
    ]);

    ?>



<?= Html::activeTextInput($model, 'body', ['placeholder' => Yii::t('site', 'Search'), 'class' => 'form-control', 'type' => 'search']); ?>
    <button class="btn btn-search" type="submit" id="button-addon2 ">
        <?= Yii::t("site", "SEARCH") ?>
    </button>

    <?php ActiveForm::end(); ?>




        <div class="container searchPageContainer">
            <div class="row flex-column-reverse flex-md-row">
                <div class=" ">
                    <div class="search-container">

                        <div id="search-section">
                            <div id="search-container">
                                <div class="" id="search-append">

                                    <?php if (isset($searchSections) && count($searchSections)) : ?>
                                        <?php foreach ($searchSections as $key => $section) : ?>

                                            <?php $section_id = explode("\\", $section['model']);
                                            $section_id = end($section_id) ?>

                                            <div class="product" id="<?= $section_id  ?>">
                                                <h4><?= $section['title'] ?></h4>

                                                <?php foreach ($section["items"] as $item) : ?>
                                                    <div class="search-product__card">
                                                        <h3>
                                                            <a href="<?= $item['siteUrl']; ?>"> <?= $item['title'] ?> </a>
                                                        </h3>
                                                        <p> <?= $item['brief'] ?? '' ?> </p>
                                                    </div>
                                                <?php endforeach; ?>

                                                <?php if (isset($section["pagination"])) : ?>
                                                    <?php
                                                    if ($section["pagination"]["pageCount"] - 1 > $section["pagination"]["page"]) :
                                                        $page = $section["pagination"]["page"] + 1;
                                                    ?>

                                                        <div class="search-read-more" id="<?= $section_id . "_pagination"  ?>">
                                                            <div class="col-lg-12 col-md-12">
                                                                <div class="add--read_more">
                                                                    <a href="<?= Url::to(['/site/search']) ?>" class="load-more" data-model="<?= $section['model'] ?>" data-page="<?= $page ?>" data-section="<?= $section_id ?>">
                                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#000" stroke="#000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus">
                                                                            <path d="M5 12h14" />
                                                                            <path d="M12 5v14" />
                                                                        </svg>
                                                                        <?= Yii::t("site", "LOAD_MORE") ?>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    <?php endif; ?>
                                                <?php endif; ?>

                                            </div>


                                        <?php endforeach; ?>
                                    <?php else : ?>

                                        <div class="row my-5">
                                            <div class="col-lg-12 col-md-12 ">
                                                <div class="search_contents">
                                                    <h4 class="text-center"><?= Yii::t('site', 'NO_RESULT_FOUND') ?></h4>
                                                </div>
                                            </div>
                                        </div>

                                    <?php endif ?>


                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>


</main>



<?php
$script = <<< JS
$(document).ready(function(){


    $(document).on("click",".load-more",function(e){
        
        $(this).attr("disabled","disabled");
        e.preventDefault();
        console.log($(this).attr('href')+$(this).attr("data-page") );
        let section = "#"+$(this).attr("data-section");
        let section_pagination = "#"+$(this).attr("data-section")+"_pagination";
        console.log(section);
        var form = new FormData();
        form.append("page",$(this).attr("data-page"));
        form.append("DynamicModel[body]",$("#dynamicmodel-body").val());
        form.append("DynamicModel[spacificModel]",$(this).attr("data-model"));
        //var formData = new FormData($('#search-form')[0]);// yourForm: form selector  
        $.ajax
        ({
            type: "POST", 
            url: $(this).attr('href'),
            dataType: 'text', //vip
            data: form,
            async: false, // to make js wait unitl ajax finish
            processData: false,
            contentType: false,

            success: function (data) 
            {
                console.log(data);
                $(section_pagination).remove();
                $(section).append(data);
                // result = data;   
            },
            error:function(data)
            { 
                console.log(data);
                // $(section_pagination).remove();
                // $(section).append(data.responseText);
                //console.log(data.responseJSON);
                //console.log(data.responseJSON.message);
                //result = data;
            }
        });
        //return result;
      
        // $.post($(this).attr('href'), {page:$(this).attr("data-page"), formData:form}, function(response){ 
        //     console.log(response);
        // });
        
            
       

    });
    

    $(document).on("click",".specific-model-accordion",function(e){

        e.preventDefault();

        $("#dynamicmodel-spacificmodel").val($(this).attr("data-value"));
        $("#accordion-title").html($(this).html());
        $("#search-form").submit();
        

    });
    
    

});



JS;
$this->registerJs($script);
?>