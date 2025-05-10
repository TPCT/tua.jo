<?php

use frontend\assets\PhotoGalleryAsset;
use frontend\widgets\general_menu\GeneralMenu;
use frontend\widgets\header_image_2\HeaderImage2;
use yeesoft\helpers\Html;
use yii\helpers\Url;

$this->title =  $album->title ;
$this->description = $album->content ;
$this->og_image =  $album->image   ;
$this->type = "article";

$lng = Yii::$app->language;
PhotoGalleryAsset::register($this);

?>

<section class="Header-section">
<?php // HeaderImage2::widget(['defaulImage'=>'/images/Headers/Mask group-3.png', 'defaulMobileImage'=>'/uploads/2024/10/header-6.jpg']) ?>
<?= GeneralMenu::widget(["menu_id" => "media-center",'view_name'=>'sub', "title"=> Yii::t('site', 'MEDIA_CENTER')]) ?>
</section>



<section>
  <div class="gallery-two-container container my-5">
    <?php foreach ($images as $index => $image): ?>
      <picture>
        <img src="<?= Html::encode($image->media->url) ?>" alt="<?= Html::encode($image->media->title) ?>"
          class="gallery-img" data-index="<?= Html::encode($index) ?>"
          data-fancybox="gallery"
          data-src="<?= $image->media->url ?>"
          data-download-src="<?= $image->media->url ?>"
          data-caption="<p class='caption-paragraph'><?= $image->media->publishedDate2 ."<br/>". $image->media->title ."<br/>". $image->media->description ?></p>"
          />
      </picture>
    <?php endforeach ?>
  </div>

  <?php if ($images): ?>
    <?= \frontend\widgets\Pager::widget(['pagination' => $pagination]); ?>
  <?php endif; ?>

  </div>
</section>


<?php
$css = <<< CSS

    /* common */
    .fancybox__backdrop{
        background: rgba(0, 0, 0, 0.8);
    }
    .f-button[data-fancybox-close]{

        width: auto;
        height: auto;
        background: transparent;
        color:#fff;
    }
    .f-button[data-fancybox-close]:hover{
        background: transparent;
    }
    .arabic-version .fancybox__caption{
        direction: rtl;
    }
    .arabic-version .fancybox__caption .fa-chevron-left{
        transform: rotate(180deg);
    }

    .is-next svg,
    .fancybox__toolbar__column .f-button[data-fancybox-next]  svg{
        transform: rotate(180deg);
    }

    .arabic-version .is-next svg,
    .arabic-version .fancybox__toolbar__column .f-button[data-fancybox-next]  svg{
        transform: rotate(0deg);
    }

    .fancybox__toolbar{
        --f-button-bg: transparent;   
    }

    .fancybox__caption, 
    .f-button {
      font-family: "NotoNaskh";
    }



    /* photo only */
    .fancybox__toolbar.is-absolute{
        top: unset;
        bottom: 15px;
    }
    .arabic-version .fancybox__toolbar.is-absolute{
        direction: rtl;
    }
    .arabic-version .fancybox__slide{
        direction: rtl;
    }

    .arabic-version .prev-popup svg{
        transform: rotate(180deg);
    }
    .is-compact .fancybox__footer{
        bottom: 55px;
    }
    .fancybox__caption{
        width: 100%;
        align-self: start;
        padding-inline: 1rem;
    }
    .fancybox__toolbar__column.is-right{
        padding-inline: 1rem;
    }
    .top-tool-bar{
        margin-top: 1rem;
        padding-inline: 1rem;
    }
    .arabic-version .top-tool-bar{
        direction: rtl;
    }
    .arabic-version .fa-chevron-left{
        transform: rotate(180deg);
    }
    .popup-btn{
        border: #fff solid 1px;
        border-radius: 50%;
        text-decoration: none;
        cursor: pointer;
        --f-button-width:35px;
        --f-button-height:35px;
    }
    .fancybox__toolbar__column.is-right{
        gap: .3rem;
    }

    .fancybox__caption{
        height: 150px;
        overflow: auto;
        font-family: var(--was-sf-pro);
        font-size: 0.9rem;
        font-weight: 500;
        line-height: 1.4rem;
        text-align: justify;
    }

    @media (min-width: 1600px){
        .fancybox__content{
            width: 80% !important;
            height: auto !important;
        }
    }

    .caption-paragraph{
      color:#fff;
      height:70px;
      overflow:auto;
    }

    .fancybox__caption p{
      color: #fff;
    }

CSS;
$this->registerCss($css);
?>


<?php
$backToPhotoGallery = Yii::t("site","BACK_TO_PHOTO_GALLERY");

$script = <<<JS

$(document).ready(function() {


  Fancybox.bind('[data-fancybox="gallery"]', {
       
    autoFocus:false,
    backdropClick:false,
    dragToClose: false,
    idle: false,
    contentClick: false,
    wheel:false, 
    compact:false,
    Toolbar: {
        items: {
            prev: {
                tpl: '<button class="f-button not-social popup-btn prev-popup" title="{{PREV}}" data-fancybox-prev><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none"><path d="M8.38007 14.0049L17.7551 4.62988C18.0192 4.3657 18.3776 4.21729 18.7512 4.21729C19.1248 4.21729 19.4831 4.3657 19.7473 4.62988C20.0114 4.89406 20.1598 5.25237 20.1598 5.62598C20.1598 5.99959 20.0114 6.35789 19.7473 6.62207L11.3672 14.9998L19.7449 23.3799C19.8757 23.5107 19.9795 23.666 20.0503 23.8369C20.1211 24.0078 20.1575 24.191 20.1575 24.376C20.1575 24.561 20.1211 24.7442 20.0503 24.9151C19.9795 25.086 19.8757 25.2413 19.7449 25.3721C19.6141 25.5029 19.4588 25.6066 19.2879 25.6774C19.117 25.7482 18.9338 25.7847 18.7488 25.7847C18.5638 25.7847 18.3806 25.7482 18.2097 25.6774C18.0388 25.6066 17.8835 25.5029 17.7527 25.3721L8.37772 15.9971C8.24678 15.8663 8.14294 15.7109 8.07216 15.5399C8.00139 15.3689 7.96507 15.1856 7.96529 15.0005C7.9655 14.8154 8.00226 14.6322 8.07343 14.4613C8.14461 14.2905 8.24881 14.1354 8.38007 14.0049Z" fill="#5E5E50"/></svg></button>',
            },
            next: {
                tpl: '<button class="f-button not-social popup-btn next-popup" title="{{NEXT}}" data-fancybox-next><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none"><path d="M8.38007 14.0049L17.7551 4.62988C18.0192 4.3657 18.3776 4.21729 18.7512 4.21729C19.1248 4.21729 19.4831 4.3657 19.7473 4.62988C20.0114 4.89406 20.1598 5.25237 20.1598 5.62598C20.1598 5.99959 20.0114 6.35789 19.7473 6.62207L11.3672 14.9998L19.7449 23.3799C19.8757 23.5107 19.9795 23.666 20.0503 23.8369C20.1211 24.0078 20.1575 24.191 20.1575 24.376C20.1575 24.561 20.1211 24.7442 20.0503 24.9151C19.9795 25.086 19.8757 25.2413 19.7449 25.3721C19.6141 25.5029 19.4588 25.6066 19.2879 25.6774C19.117 25.7482 18.9338 25.7847 18.7488 25.7847C18.5638 25.7847 18.3806 25.7482 18.2097 25.6774C18.0388 25.6066 17.8835 25.5029 17.7527 25.3721L8.37772 15.9971C8.24678 15.8663 8.14294 15.7109 8.07216 15.5399C8.00139 15.3689 7.96507 15.1856 7.96529 15.0005C7.9655 14.8154 8.00226 14.6322 8.07343 14.4613C8.14461 14.2905 8.24881 14.1354 8.38007 14.0049Z" fill="#5E5E50"/></svg></button>',
            },
            download: {
                tpl: '<a class="f-button not-social popup-btn" title="{{DOWNLOAD}}" data-fancybox-download><svg tabindex="-1" width="24" height="24" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-2M7 11l5 5 5-5M12 4v12"></path></svg></a>',
            },
            share: {
                tpl: `<button class="f-button not-social popup-btn"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" viewBox="0 0 20 20"><path fill="#fff" d="M15,18.9c-.7,0-1.3-.2-1.8-.7-.5-.5-.7-1.1-.7-1.8s0-.3,0-.7l-6.6-3.9c-.2.2-.5.4-.8.5-.3.1-.6.2-1,.2-.7,0-1.3-.2-1.8-.7-.5-.5-.7-1.1-.7-1.8s.2-1.3.7-1.8c.5-.5,1.1-.7,1.8-.7s.7,0,1,.2c.3.1.6.3.8.5l6.6-3.9c0-.1,0-.2,0-.3,0-.1,0-.2,0-.4,0-.7.2-1.3.7-1.8.5-.5,1.1-.7,1.8-.7s1.3.2,1.8.7c.5.5.7,1.1.7,1.8s-.2,1.3-.7,1.8c-.5.5-1.1.7-1.8.7s-.7,0-1-.2c-.3-.1-.6-.3-.8-.6l-6.6,3.9c0,.1,0,.2,0,.3,0,.1,0,.2,0,.4s0,.2,0,.4c0,.1,0,.2,0,.3l6.6,3.9c.2-.2.5-.4.8-.6.3-.1.6-.2,1-.2.7,0,1.3.2,1.8.7.5.5.7,1.1.7,1.8s-.2,1.3-.7,1.8c-.5.5-1.1.7-1.8.7ZM15,17.5c.3,0,.6-.1.8-.3.2-.2.3-.5.3-.8s-.1-.6-.3-.8c-.2-.2-.5-.3-.8-.3s-.6.1-.8.3c-.2.2-.3.5-.3.8s.1.6.3.8c.2.2.5.3.8.3ZM4.2,11.1c.3,0,.6-.1.8-.3.2-.2.3-.5.3-.8s-.1-.6-.3-.8c-.2-.2-.5-.3-.8-.3s-.6.1-.8.3c-.2.2-.3.5-.3.8s.1.6.3.8c.2.2.5.3.8.3ZM15,4.8c.3,0,.6-.1.8-.3.2-.2.3-.5.3-.8s-.1-.6-.3-.8-.5-.3-.8-.3-.6.1-.8.3c-.2.2-.3.5-.3.8s.1.6.3.8c.2.2.5.3.8.3Z"></path></svg></button>`,
                click: () => {
                    $(".not-social").addClass("d-none");
                    $(".social").removeClass("d-none");
                },
            },
            closeShare: {
                tpl: `<button class="f-button social d-none popup-btn"><i class="fa-regular fa-circle-xmark"></i></button>`,
                click: () => {
                    $(".not-social").removeClass("d-none");
                    $(".social").addClass("d-none");
                },
            },
            facebook: {
                tpl: `<button class="f-button social d-none popup-btn"><svg><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg></button>`,
                click: () => {
                    let url = encodeURIComponent(window.location.href);
                    let title = encodeURIComponent(document.title);
                    console.log(url);
                    window.open(
                        `https://www.facebook.com/sharer/sharer.php?u=`+url+`&t=`+title,
                        "",
                        "left=0,top=0,width=600,height=300,menubar=no,toolbar=no,resizable=yes,scrollbars=yes"
                    );
                },
            },
            whats: {
                tpl: `<a class="f-button social d-none popup-btn" id="whatsapp" ><i class="fa-brands fa-whatsapp"></i></a>`,
            },
            linkedin: {
                tpl: `<button class="f-button social d-none popup-btn"><i class="fa-brands fa-linkedin-in"></i></button>`,
                click: () => {
                    let url = encodeURIComponent(window.location.href);
                    window.open(
                        `https://www.linkedin.com/shareArticle?mini=true&url=`+url,
                        "",
                        "left=0,top=0,width=600,height=300,menubar=no,toolbar=no,resizable=yes,scrollbars=yes"
                    );
                },
            },
            twitter: {
                tpl: `<button class="f-button social d-none popup-btn"><i class="fa-brands fa-x-twitter"></i></button>`,
                click: () => {
                    let url = encodeURIComponent(window.location.href);
                    window.open(
                        `https://twitter.com/share?url=`+url,
                        "",
                        "left=0,top=0,width=600,height=300,menubar=no,toolbar=no,resizable=yes,scrollbars=yes"
                    );
                },
            },
            copy: {
                tpl: `<button class="f-button social d-none copy-link popup-btn"><i class="fa-regular fa-copy"></i></button>`,
                
            },
        },
        display: {
            left: [],
            middle: [],
            right: [
                "share",
                "download",
                "prev",
                "next",
                "closeShare",
                "facebook",
                "whats",
                "linkedin",
                "twitter",
                "copy"
            ],
        }
    },
    Thumbs:false,
    Carousel: {
        Navigation: false,
        Panzoom: {
            wheel: false, // Disable zoom on scroll
            dragFree:false,
            touch:false,
        },
    },
    on: {
        "Carousel.ready Carousel.change": (fancybox) => {

            if($(".top-tool-bar").length == 0 )
            {
                let toolbar = $(".fancybox__toolbar.is-absolute");
                let cloned = $(toolbar).clone();
                $(cloned).removeClass("is-absolute")
                        .addClass("top-tool-bar")
                        .html('<button class="f-button" title="{{CLOSE}}" data-fancybox-close> <i class="fa-solid fa-chevron-left mx-2"></i> $backToPhotoGallery </button>');
                $(".fancybox__container").prepend(cloned);
            }

            
        },

    },
        
  });


});

JS;
$this->registerJs($script);

?>