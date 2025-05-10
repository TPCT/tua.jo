<?php

use yii\helpers\Url;
use frontend\widgets\siteMapMenu\SiteMapMenu;
use frontend\widgets\general_menu\GeneralMenu;
use common\helpers\Utility;

$this->title = Yii::t('site', 'Site Map');

$lng = Yii::$app->language;
?>

<main class="site-map" id="mangement">
    <div class="available-jobs-heading-section container border-b-gray--main">
        <h1><?= $this->title ?> </h1>
    </div>
    <div class="container ">
        <div class="row" id="accordionExample">

            <h2 class="mt-5"><?= Yii::t("site","HEADER") ?> </h2>
            <?= SiteMapMenu::widget(["menu_id" => "main-menu"]) ?>

            <h2 class="mt-5"><?= Yii::t("site","FOOTER") ?> </h2>
            <div class="col-lg-6 site-map-strategiecs">
                <div class="">
                    <div class=" site-map-item d-flex align-items-center justify-content-between">
                        <h4> <?= Yii::t("site","ABOUT_STRATICS") ?> </h4>
                        
                        <button class="site-map-button" data-bs-target="site-map-about">
                            <i class="fa-solid fa-chevron-down to-rotate" ></i>
                        </button>
                    </div>
                    <ul id="site-map-about">
                        <?= GeneralMenu::widget(["menu_id" => "footer-menu"]) ?>
                    </ul>
                </div>
            </div>

            <div class="col-lg-6 site-map-strategiecs">
                <div class="">
                    <div class=" site-map-item d-flex align-items-center justify-content-between">
                        <h4> <?= Yii::t("site","KEEP_INFORMED") ?> </h4>
                        
                        <button class="site-map-button" data-bs-target="site-map-about">
                            <i class="fa-solid fa-chevron-down to-rotate" ></i>
                        </button>
                    </div>
                    <ul id="site-map-about">
                        <?= GeneralMenu::widget(["menu_id" => "footer-menu-2"]) ?>
                    </ul>
                </div>
            </div>

            <div class="col-lg-6 site-map-strategiecs">
                <div class="">
                    <div class=" site-map-item d-flex align-items-center justify-content-between">
                        <h4> <?= Yii::t("site","JOIN_US") ?> </h4>
                        
                        <button class="site-map-button" data-bs-target="site-map-about">
                            <i class="fa-solid fa-chevron-down to-rotate" ></i>
                        </button>
                    </div>
                    <ul id="site-map-about">
                        <?= GeneralMenu::widget(["menu_id" => "footer-menu-3"]) ?>
                    </ul>
                </div>
            </div>


        

        </div>
    </div>



</main>


<?php

?>