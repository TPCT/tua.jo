<?php

use common\helpers\Content;
use frontend\assets\AppAsset;
use frontend\assets\CustomAsset;
use yii\helpers\Html;
use simialbi\yii2\schemaorg\helpers\JsonLDHelper;
use common\components\traits\OrganizitionalSchemaTrait;
use frontend\assets\AccesabilityAssets;



AppAsset::register($this);
AccesabilityAssets::register($this);

CustomAsset::register($this);



?>

<?php $this->beginPage() ?>

<!doctype html>
<html lang="<?= Yii::$app->language ?>">

<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=2.0">
    <meta name="format-detection" content="telephone=no">

    <link rel="icon" type="image/png" href="/theme/assets/fav.png">

    <?= $this->renderMetaTags() ?>
    
    <?php $this->head() ?>

    

    <?= Html::csrfMetaTags() ?>
    <?=
        $this->render('//common_parts/og_and_twitter_meta.php',[
            "title"=>$this->title??Yii::$app->settings->get('general.title', null, Yii::$app->language),
            "description"=>$this->description??Yii::$app->settings->get('general.description', null, Yii::$app->language),
            "og_image"=>$this->og_image??Yii::$app->settings->get('general.og_image', null, Yii::$app->language),
            "type"=>$this->type?? "website",
        ])
    ?>
    <?= $this->render('//common_parts/organizational_schema.php') ?>

    <?php JsonLDHelper::render(); ?>



    <?=
        $this->render('//common_parts/google_tag_key_head.php')
    ?>
    <?=
        $this->render('//common_parts/google_analytics_key.php')
    ?>
    <?=
        $this->render('//common_parts/meta_pixel_key.php')
    ?>
    

    </head>
<body  class="<?= (Yii::$app->language == 'en') ? '' : 'arabic-version' ; ?>" >
<?php $this->beginBody() ?>
<?=
        $this->render('//common_parts/organizational_schema.php')
    ?>
<?=
    $this->render('//common_parts/google_tag_key_body.php')
?>

<main id="<?= $this->params['mainIdName'] ?? '' ?>">
    <?= Yii::$app->controller->renderPartial('@app/views/layouts/_header_inner', []) ?>
        <?= Content::inlineStyleToClasses($content)  ?>        
        <?= Yii::$app->controller->renderPartial('@app/views/layouts/_footer_inner', []) ?>
</main>
<?php $this->endBody() ?>



<div class="toast text-white hide" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-body text-white ">
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
        <span class="message text-white w-100"></span>
    </div>
</div>


<div class="cart-reminder modal fade" id="cart-reminder" tabindex="-1" aria-labelledby="cart-reminder" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="d-flex flex-column w-100 align-items-center justify-content-center align-items-center ">
                    <div class="row w-100 px-0 g-4 pt-3 pb-5">
                        <picture class="secure-img">
                            <img src="/theme/assets/Images/waiting-to-be-donated.gif" alt="" class="mw-100">
                        </picture>
                        <h4 class="text-center "><?=Yii::t('site', 'YOU_HAVE_CART_ITEMS')?></h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>

<script>
    $(function(){
        setInterval(function (){
            $.ajax({
                url: '/en/cart/items-count',
                method: 'GET',
                success: function (data){
                    if (data.count > 0){
                        $('#cart-reminder').modal('show')
                    }
                }
            })
        }, 3600 * 6 * 1000);
    })
</script>
</html>
<?php $this->endPage() ?>

