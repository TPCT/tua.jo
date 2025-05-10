<?php

use common\helpers\Utility;
use frontend\widgets\account_menu\AccountMenu;
use frontend\widgets\LanguageSelector;
use frontend\widgets\LanguageSelectorMobile;
use frontend\widgets\newmenu\NewMenu;
use frontend\widgets\currency_menu\CurrencyMenu;
use frontend\widgets\topmenu\TopMenu;
use frontend\widgets\WebpImage;
use kartik\form\ActiveForm;
use yii\base\DynamicModel;
use yii\helpers\Url;


$lng = Yii::$app->language;
?>

<div class="navigation-container container hover-none">
    <a href="<?= Url::to(["/"]) ?>">
        <picture class="top-logo">
            <img src="<?= WebpImage::widget(["src" => Yii::$app->settings->get('site.logo', null, $lng) ?? '', "alt" => "", "loading" => "lazy", 'css' => "", "just_image" => true]); ?>"
                 alt=""/>
        </picture>
    </a>

    <div class="w-100">
        <div class="main-navigation--container">
            <div class="container upper-nav">
                <!--  -->
                <a href="" class="logo-container">
                    <!-- <img src="./assets/Logo.svg" alt="" srcset=""> -->
                    <span></span>
                </a>
                <div class="">

                    <a href="<?= Url::to(["/zakat-calculation"]) ?>">
                        <span class="icon-container"></span>
                        <div class="">
                            <span><?= Yii::t('site', 'ZAKAT_CALCULATION') ?></span>
                        </div>
                    </a>
                    <a class="cart" href="<?= Url::to(['/cart/']) ?>">
                        <span class="cart-items-count"><?=\common\helpers\Utility::cartItemsCount()?></span>  
                        <span class="icon-container"></span>
                        <div class="">
                            <span><?= Yii::t('site', 'cart') ?></span>
                            <!-- <p>Virtual Tour</p> -->
                        </div>
                    </a>


                    <?= AccountMenu::widget() ?>
                    <?= CurrencyMenu::widget() ?>
                    <?= LanguageSelector::widget() ?>
                    <?php
                    try {
                        echo \frontend\widgets\AccessibilityTools::widget([]);

                    } catch (Exception $e) {
                    //    var_dump($e->getMessage());
                    }

                    ?>
                </div>
            </div>
        </div>
        <header class="main-navigation--container">
            <div class="hewader-panel-main d-flex position-relative justify-content-between px-0">
                <div
                        class="header-logo header-custom-container w-100 d-flex flex-row align-items-start align-items-lg-center justify-content-between">
                    <div class="header-menu px-0 w-100 d-flex">
                        <nav id="cssmenu"
                             class="head_btm_menu d-flex justify-content-xl-between justify-content-end w-100">
                            <ul class="">

                                <a href="<?= Url::to(["/"]) ?>">

                                    <picture class="bottom-logo">
                                        <img src="<?= WebpImage::widget(["src" => Yii::$app->settings->get('site.logo', null, $lng) ?? '', "alt" => "", "loading" => "lazy", 'css' => "", "just_image" => true]); ?>"
                                             alt=""/>
                                    </picture>
                                </a>


                                <?= NewMenu::widget() ?>


                                <li class="smaller-screens-only">
                                    <a href="<?= Url::to(["/zakat-calculation"]) ?>" class="Zakat">
                                        <span class="icon-container"></span>
                                        <div class="">
                                            <span><?= Yii::t('site', 'ZAKAT_CALCULATION') ?> </span>
                                        </div>
                                    </a>
                                </li>
                                <li class="smaller-screens-only">
                                    <a href="<?= Url::to(['/cart/']) ?>" class="cart">
                                        <span class="cart-items-count"><?= Utility::cartItemsCount() ?></span>
                                        <span class="icon-container"></span>
                                        <div class="">
                                            <span><?=Yii::t('site', 'CART')?></span>
                                        </div>
                                    </a>
                                </li>
                                <li class="smaller-screens-only">
                                    <a href="<?= Url::to(['/account/login']) ?>" class="login">
                                        <span class="icon-container"></span>
                                        <div class="">
                                            <span><?= Yii::t('site', 'LOGIN') ?></span>
                                        </div>
                                    </a>
                                </li>

                                <li class="smaller-screens-only">
                                    <a href="<?= Url::to(['/account/settings/currency-switch/', 'slug' => Utility::selected_currency('slug') == 'jod' ? 'usd' : 'jod']) ?>"
                                       class="coin">
                                        <span class="icon-container"></span>
                                        <div class="">
                                            <span><?= Utility::selected_currency('title') ?></span>
                                        </div>
                                    </a>
                                </li>

                            </ul>
                            <a href="<?= Url::to(["/"]) ?>">
                                <picture class="single-nav-logo">

                                    <img src="<?= WebpImage::widget(["src" => Yii::$app->settings->get('site.logo', null, $lng) ?? '', "alt" => "", "loading" => "lazy", 'css' => "", "just_image" => true]); ?>"
                                         alt=""/>
                            </a>
                            </picture>
                            <div class="navigation-last-content">
                                <ul class="main-navigation-search-container">
                                    <li>
                                        <a class="navigation-search">
                                            <span>  <?= Yii::t("site", "SEARCH") ?> </span>
                                            <i class="fa-solid fa-magnifying-glass"></i></a>
                                    </li>
                                    <li class="LanguageSelectorDesktop">
                                        <?= LanguageSelector::widget() ?>
                                    </li>
                                    <li>
                                        <?= LanguageSelectorMobile::widget() ?>
                                    </li>
                                </ul>
                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </header>
    </div>
</div>

<div class="searchBarOpen">

    <?php
    $model = new DynamicModel([
        'body',
    ]);
    $model->addRule('body', 'string', ['min' => 0]);
    $form = ActiveForm::begin([
        'formConfig' => [
            'showHints' => false,
        ],
        'fieldConfig' => [
            'options' => [
                'tag' => false,
            ],
        ],
        'options' => ['class' => 'searchBarOpen--input'],
        'action' => Url::to(['/site/search',])
    ])
    ?>
    <label> <?= Yii::t("site", "SEARCH") ?></label>
    <div class="">


        <?= $form->field($model, 'body')->textInput(['maxlength' => true, "class" => ""])->label(false) ?>
        <button>
            <i class="fa-solid fa-magnifying-glass"></i>
        </button>
    </div>
    <?php ActiveForm::end(); ?>
    <span class="searchBarOpen--closeBtn"
    ><i class="fa-solid fa-x"></i
        ></span>
</div>