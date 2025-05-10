<?php

use common\helpers\Utility;
use frontend\widgets\LanguageSelectorMobile;
use kartik\helpers\Html;
use yii\helpers\Url;

$currentRoute = Html::encode(Yii::$app->request->getUrl());
$lng = Yii::$app->language;

?>



<div class="blue-sub-header">
    <div class="container d-flex flex-column justify-content-center h-100 gap-4">
        <h2><?= $title ?></h2>
        <div class="blue-sub-header-list multiple-items">
            <?php foreach ($menuLinks as $item): ?>
                <div>
                    <a <?= $item['url'][0] ? Utility::PrintAllUrl($item['url'][0]) : ''; ?>
                        class=" <?= $item['active'] ? 'current-active' : '' ?> ">
                        <?= $item['label'] ?>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>



<?php
$script = <<< JS

        $(document).ready(function(){

            let currentRoute = "{$currentRoute}"; 
            let break_point = "{$break_point}"; 
            let anchors = $(".blue-sub-header-list a");
            

            $(anchors).each(function(index, item){
                if( currentRoute.includes($(item).attr("href"))  )
                {

                    $(item).addClass("current-active");
                }
            });


            // !! Sub Menu Slider
            let resizeTimeout;
            var isRTL = $('html').attr('lang') === 'ar';
            function scrollToActiveItem() {
                const activeItem = $('.blue-sub-header-list .current-active');
                let activeIndex = $(activeItem).closest('div').index();
                if (activeIndex !== -1) {
                    console.log("rrrrr", activeIndex);
                
                    if(activeIndex)
                    {
                        let currentBreakpoint = $(window).width();

                        if(currentBreakpoint<1200 && currentBreakpoint> 767)
                        {
                            const slickInstance = $('.multiple-items').slick('getSlick');
                            let slidesToShow = slickInstance.options.slidesToShow;

                            let counter = slickInstance.slideCount;

                            counter--;
                            slidesToShow--;
                            if( (counter - activeIndex) < slidesToShow)
                            {
                                console.log(slidesToShow, counter);
                                counter = counter- slidesToShow;
                                activeIndex =  counter;
                            }
                        }
                        $('.multiple-items').slick('slickGoTo', activeIndex);
                    }


                }
            }
            $(window).on('resize orientationchange', function () {
                clearTimeout(resizeTimeout);
                resizeTimeout = setTimeout(function () {
                    if ($(window).width() > break_point) {
                        if ($('.multiple-items').hasClass('slick-initialized')) {
                            $('.multiple-items').slick('unslick');
                        }
                    } else {
                        if (!$('.multiple-items').hasClass('slick-initialized')) {
                            $('.multiple-items').slick({
                                infinite: false,
                                slidesToShow: 7,
                                slidesToScroll: 1,
                                arrows: true,
                                rtl: isRTL,
                                prevArrow: `<button type="button" class="arrow-prev">
                                <i class="fa-solid fa-angle-left"></i>
                                </button>`,
                                nextArrow: `<button type="button" class="arrow-next">
                                <i class="fa-solid fa-angle-right"></i>
                                </button>`,
                                responsive: [
                                    {
                                        breakpoint: 1200,
                                        settings: {
                                            slidesToShow: 4,
                                        },
                                    },
                                    {
                                        breakpoint: 992,
                                        settings: {
                                            slidesToShow: 3,
                                        },
                                    },
                                    {
                                        breakpoint: 768,
                                        settings: {
                                            slidesToShow: 1,
                                        },
                                    },
                                ],
                            });

                            scrollToActiveItem(); 
                        }
                    }
                }, 100);
            }).trigger('resize');

            

        });

JS;
$this->registerJs($script);

?>

<?php if($active_header_url): ?>
    <?php
    $active_header_url = Url::to([$active_header_url]);
    $script = <<< JS

        $(document).ready(function(){

            let url = "{$active_header_url}";   
            let anchors = $(".desktop-only-nav a");

            $(anchors).each(function(index, item){
                if($(item).attr("href") == url)
                {
                    $(item).addClass("active");
                }
            });
            

        });

    JS;
    $this->registerJs($script);

    ?>

<?php endif; ?>