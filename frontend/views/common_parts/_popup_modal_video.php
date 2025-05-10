<?php

use frontend\assets\FancyBoxAsset;
use yii\helpers\Url;
FancyBoxAsset::register($this);

?>

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

    .fancybox__toolbar{
        --f-button-bg: transparent;   
    }

    .fancybox__caption,
    .f-button{
        font-family: "NotoNaskh";
    }
    .fancybox__caption p{
        color: #fff;
    }



    /* video only */
    .fancybox__caption{
        height: 140px;
        overflow: auto;
        font-family: "NotoNaskh";
        font-size: 0.9rem;
        font-weight: 500;
        line-height: 1.4rem;
        text-align: justify;
        width: 930px;
    }
    .has-youtube .fancybox__content{
        margin-top: 20px;
    }
    .footer-to-top{
        top: 50px;
        bottom: unset !important;
        background: transparent !important;
    }

    @media (min-width: 1600px){
        .fancybox__caption{
            width: 80%;
        }
        .has-youtube .fancybox__content{
            width: 80% !important;
            height: auto !important;
        }
    }

CSS;
$this->registerCss($css);
?>


    
<?php
$backToVideoGallery = Yii::t("site","BACK_TO_MAIN");

$script = <<< JS

$(document).ready(function() {

  Fancybox.bind('[data-fancybox="video"]', {
       
    Html : {
      youtube: {
        enablejsapi:0
      }
    },
    autoFocus:false,
    backdropClick:false,
    dragToClose: false,
    Thumbs:false,
    idle: false,
    Carousel: {
      Navigation: false,
      Panzoom: {
        wheel: false,
        dragFree:false,
        touch:false,
      },
    },
    Toolbar: {
      enabled: true,
      items: {
          close: {
              tpl: '<button class="f-button" title="{{CLOSE}}" data-fancybox-close> </button>',
          },
      },
      display: {
          left: ["close"],
          middle: [],
          right: [],
      }
    },
    on: {
      "Carousel.ready Carousel.change": (fancybox) => {
        // Current slide
        let captionElementMobile = $(fancybox.getSlide().contentEl).parents(".fancybox__carousel").next();
        if ($(captionElementMobile).children().length == 0)
        {
          let captionElement = fancybox.getSlide().captionEl;
          let content = $(fancybox.getSlide().el);
          let cloned = $(captionElement).clone();
          $(cloned).addClass("h-auto").html('<button class="f-button" title="{{CLOSE}}" data-fancybox-close> <i class="fa-solid fa-chevron-left mx-2"></i> $backToVideoGallery </button>');
          $(content).prepend(cloned);
        }
        else
        {
          let mobileCloned = $(captionElementMobile).clone();
          $(mobileCloned).addClass("footer-to-top d-block d-md-none").html('<div class="fancybox__caption"><button class="f-button h-auto" title="{{CLOSE}}" data-fancybox-close> <i class="fa-solid fa-chevron-left mx-2"></i> $backToVideoGallery </button></div>');
          $(".fancybox__toolbar").prepend(mobileCloned);
        }

      },
    },
        
        
        
  });

});


JS;
$this->registerJs($script);
?>