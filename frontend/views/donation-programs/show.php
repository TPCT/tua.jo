<?php


use common\components\TuaClient;
use common\helpers\Utility;
use frontend\assets\AppAsset;
use frontend\widgets\breadcrumbs\BreadCrumbs;
use frontend\widgets\WebpImage;
use yii\helpers\Url;
use kartik\form\ActiveForm;
use frontend\assets\SlickAsset;
SlickAsset::register($this);

$this->title = $program->title;
$this->description = implode(' ', array_slice(explode(' ', strip_tags($program->brief)), 0, 20));
$this->og_image = $program->image;
$this->type = "article";

$this->registerCssFile("/theme/css/main-dontation.css", ['depends' => [AppAsset::className()],]);

$lng = Yii::$app->language;
?>

<?= BreadCrumbs::widget(['is_clickable' => false, 'is_inner' => false, 'bread_crumb_slug' => $program->slug, 'bread_crumb_title' => $program->title]) ?>

    <section class="donation-flow-main-section">
        <div class="container">
            <div class="main-donation-card">
                <div class="main-donation-card-wrapper">
                    <div class="main-donation-card-header">
                        <h3><?= $program->title ?></h3>
                        <div class="share-button-section align-items-center d-flex justify-content-start position-relative">
                            <div class="share-btn p-0" id="share">
                                <div class="shareicoon">
                                    <svg width="22" height="22" viewBox="0 0 22 22" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path
                                                d="M18.0697 17.0455C18.0698 17.4933 17.9718 17.9358 17.7827 18.3417C17.5935 18.7476 17.3178 19.1072 16.9749 19.3952C16.632 19.6833 16.2302 19.8928 15.7978 20.009C15.3653 20.1252 14.9126 20.1453 14.4715 20.068C14.0304 19.9906 13.6116 19.8177 13.2445 19.5612C12.8774 19.3048 12.5708 18.971 12.3464 18.5835C12.122 18.196 11.9851 17.764 11.9454 17.318C11.9057 16.8719 11.9641 16.4226 12.1166 16.0015L7.59952 13.0995C7.16811 13.5227 6.62134 13.809 6.0278 13.9226C5.43427 14.0362 4.8204 13.972 4.26321 13.7381C3.70602 13.5041 3.23032 13.1109 2.89579 12.6076C2.56127 12.1043 2.38281 11.5135 2.38281 10.9092C2.38281 10.3048 2.56127 9.71399 2.89579 9.21072C3.23032 8.70745 3.70602 8.31417 4.26321 8.08022C4.8204 7.84627 5.43427 7.78207 6.0278 7.89568C6.62134 8.00929 7.16811 8.29564 7.59952 8.71882L12.1166 5.82109C11.8579 5.11033 11.8702 4.32919 12.1511 3.62692C12.432 2.92466 12.9618 2.35051 13.6393 2.01418C14.3167 1.67786 15.0944 1.60294 15.8236 1.80374C16.5528 2.00455 17.1825 2.46699 17.5923 3.10272C18.002 3.73845 18.1632 4.50287 18.045 5.24994C17.9268 5.997 17.5375 6.67432 16.9514 7.15247C16.3654 7.63062 15.6237 7.87608 14.8681 7.84193C14.1125 7.80779 13.396 7.49645 12.8555 6.96739L8.33844 9.86938C8.58257 10.544 8.58257 11.2828 8.33844 11.9575L12.8555 14.8594C13.2868 14.4374 13.8329 14.1518 14.4256 14.0386C15.0184 13.9253 15.6313 13.9893 16.1878 14.2227C16.7443 14.456 17.2197 14.8482 17.5544 15.3503C17.8891 15.8524 18.0684 16.4421 18.0697 17.0455Z"
                                                fill="#FAFAFA"/>
                                    </svg>
                                </div>
                                <?= Yii::t('site', 'SHARE') ?>
                            </div>
                            <div class="share-overlay align-items-center gap-3 p-0" id="share-overlay">
                                <a href="#" id="copy-link"><i class="fa-regular fa-copy"></i></a>
                                <a href="#" id="twitter"><i class="fa-brands fa-x-twitter"></i></a>
                                <a href="#" id="linkedin"><i class="fa-brands fa-linkedin-in"></i></a>
                                <a href="#" id="whatsapp"><i class="fa-brands fa-whatsapp"></i></a>
                                <a href="#" id="facebook"><i class="fa-brands fa-facebook"></i></a>
                                <div id="closeButton">
                                    <i class="fa-solid fa-xmark"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?= WebpImage::widget(["src" => $program->image, "alt" => $program->title, "loading" => "lazy", 'css' => ""]) ?>

                <?php if ($program->has_goal): ?>
                    <div class="main-colored-progress-bar">
                        <div class="outer-colored-progress-bar"
                             style="background: <?= $program->color ?> !important;"></div>
                        <div class="inner-colored-progress-bar" style="background: <?= $program->color ?> !important;"
                             progress="<?= (int)($program->progress) ?>%">
                            <span style="background: <?= $program->color ?> !important;"> </span>
                        </div>
                        <div class="d-flex justify-content-between border-bottom pt-3">
                            <div class="d-flex flex-column align-items-start raised-goal-ps">
                                <p><?= Yii::t('site', 'Raised') ?></p>
                                <h4><?= $program->raised ?> <?= Yii::t('site', 'JOD') ?></h4>
                            </div>
                            <div class="d-flex flex-column align-items-end raised-goal-ps">
                                <p><?= Yii::t('site', 'Goal') ?></p>
                                <h4><?= $program->goal ?> <?= Yii::t('site', 'JOD') ?></h4>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (count($program->tabs)): ?>
                    <ul class="nav donation-card-custom-panel nav-pills mb-3" id="pills-tab" role="tablist">
                        <?php foreach ($program->tabs as $index => $tab): ?>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link <?= $index == 0 ? 'active' : '' ?>" id="description-tab"
                                        data-bs-toggle="pill"
                                        data-bs-target="#tab-<?= $tab->id ?>"
                                        type="button" role="tab" aria-controls="description" aria-selected="true">
                                    <h4>
                                        <?= $tab->{"title_" . Yii::$app->language} ?>
                                    </h4>
                                </button>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <?php foreach ($program->tabs as $index => $tab): ?>
                            <div class="tab-pane fade show <?= $index == 0 ? 'active' : '' ?>" id="tab-<?= $tab->id ?>"
                                 role="tabpanel"
                                 aria-labelledby="description-tab">
                                <?= $tab->{"brief_" . Yii::$app->language} ?>

                                <?php if ($tab->{"label_url_" . Yii::$app->language}): ?>
                                    <p>
                                        <a class="downlad-btn" href="<?= $program->fatwa_file; ?>" target="_blank">
                                            <?= $tab->{"label_url_" . Yii::$app->language} ?>
                                        </a>
                                    </p>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
            <div>
                <?php if (!$program->has_goal || ($program->progress >= 0 && $program->progress < 100)): ?>
                    <div class="donation-amount-detailed">
                        <?php if ($program->hasParents): ?>
                            <div class="form-switch-buttons parents">
                                <?php foreach ($program->parents as $index => $parent): ?>
                                    <button type="button" class="<?= $index == 0 ? "active" : "" ?>"
                                            data-target="pill-<?= $parent->id ?>"> <?= $parent->title ?></button>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <?php foreach ($program->parents as $index => $parent): ?>
                            <?php if (!$program->hasParents && $index): ?>
                                <?php break; ?>
                            <?php endif ?>
                            <?php $formId = uniqid("form-") ?>
                            <div class="select-currency-box <?= $index > 0 ? "d-none" : "" ?>"
                                 id="pill-<?= $parent->id ?>">
                                <form id="<?= $formId ?>" action="<?= Url::to(['/cart/add']) ?>" method="post"
                                      class="donation-form">
                                    <?php if ($program->is_recurring): ?>
                                        <h3><?= Yii::t('site', 'Set Recurrence Frequency') ?></h3>
                                        <div class="form-switch-buttons recurring">
                                            <button type="button" data-recurring="once"
                                                    class="recurrence-type active"><?= Yii::t('site', 'Once') ?></button>
                                            <button type="button" data-recurring="monthly"
                                                    class="recurrence-type"><?= Yii::t('site', 'Monthly') ?></button>
                                            <button type="button" data-recurring="yearly"
                                                    class="recurrence-type"><?= Yii::t('site', 'Yearly') ?></button>
                                        </div>
                                    <?php endif; ?>

                                    <?php if (!$program->has_amount): ?>
                                        <h3><?= Yii::t('site', "SELECT_CATEGORY") ?></h3>
                                    <?php endif; ?>

                                    <input type="hidden" name="<?= Yii::$app->request->csrfParam ?>"
                                           value="<?= Yii::$app->request->csrfToken ?>"/>
                                    <div class="donation-list">
                                        <?php foreach ($parent->items as $idx => $item): ?>
                                            <?php if (!$item->donationType && !$item->campaign): ?>
                                                <?php continue; ?>
                                            <?php endif; ?>
                                            <div class="donation-item"
                                                 data-price="<?= $item->amount ?>"
                                                <?= $program->has_amount ? "style='border: unset !important;'" : "" ?>
                                                 data-has-amount="<?= $program->has_amount ?>"
                                            >
                                                <input type="hidden" name="items[<?= $idx ?>][program_id]" value="<?=$program->id?>" />
                                                <input type="hidden" name="items[<?= $idx ?>][id]" value="<?=$item->id?>" />
                                                <input type="hidden" name="items[<?= $idx ?>][donation]"
                                                       value="<?= $item->donationType->guid ?>"/>
                                                <input type="hidden" name="items[<?= $idx ?>][campaign]"
                                                       value="<?= $item->campaign?->guid ?>"/>
                                                <input type="hidden" name="items[<?= $idx ?>][guid]"
                                                       value="<?= uniqid('cart-item-') ?>"/>
                                                <input type="hidden" name="items[<?= $idx ?>][recurrence]" value="once"
                                                       class="item-recurrence-type"/>
                                                <input type="hidden" name="items[<?= $idx ?>][currency]"
                                                       value="<?= Utility::selected_currency('slug') ?>"/>
                                                <?php if ($program->has_amount): ?>
                                                    <input type="hidden" name="items[<?= $idx ?>][type]"
                                                           value="1"/>
                                                    <input type="text" name="items[<?= $idx ?>][amount]"
                                                           placeholder="<?= Yii::t('site', "AMOUNT_NUMBER") ?>"
                                                           class="amount" required/>
                                                    <input type="hidden" name="items[<?= $idx ?>][quantity]" value="1"
                                                           class="quantity"/>
                                                <?php else: ?>
                                                    <input type="hidden" name="items[<?= $idx ?>][type]"
                                                           value="2"/>
                                                    <input type="hidden" name="items[<?= $idx ?>][quantity]" value="0"
                                                           class="quantity"/>
                                                    <input type="hidden" name="items[<?= $idx ?>][amount]"
                                                           value="<?= $item->amount ?>"/>
                                                    <h5 class="price"
                                                        style="color: <?= $program->color ?> !important;"><?= number_format($item->amount, 2) ?>
                                                        <span class="currency"
                                                              style="color: <?= $program->color ?> !important;"> <?= Utility::selected_currency('title') ?></span>
                                                    </h5>
                                                    <h5 class="description"><?= $item->title ?></h5>
                                                    <div class="quantity-control">
                                                        <button type="button" class="quantity-btn minus"
                                                                data-price="<?= $item->amount ?>">−
                                                        </button>
                                                        <h4 class="quantity">0</h4>
                                                        <button type="button" class="quantity-btn plus"
                                                                data-price="<?= $item->amount ?>">+
                                                        </button>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        <?php endforeach; ?>

                                        <?php if ($program->has_amount): ?>
<!--                                            <div class="check-input mt-4">-->
<!--                                                <input type="checkbox" class="add-transaction-fees"/>-->
<!--                                                <p>--><?php //= Yii::t('site', 'TRANSACTION_FEES_TEXT') ?><!--</p>-->
<!--                                            </div>-->
                                        <?php else: ?>
                                            <div class="donation-items-total"
                                                 style="background-color: <?= Utility::hexToRgb($program->color, 0.06) ?> !important; border-color: <?= Utility::hexToRgb($program->color, 0.5) ?> !important;">
                                                <h4 style="color: <?= $program->color ?> !important;"><?= Yii::t('site', 'Total') ?></h4>
                                                <div class="d-flex align-items-center">
                                                    <h4 class="price" style="color: <?= $program->color ?> !important;">
                                                        00.00</h4>
                                                    <h4 class="currency"
                                                        style="color: <?= $program->color ?> !important;"><?= Utility::selected_currency('title') ?></h4>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <span class="text-danger d-none error-message gap-3"></span>

                                    <div class="d-flex justify-content-between gap-3 mt-3">
                                        <button class="type-6-btn w-100"
                                                onclick="addToCart('#<?= $formId ?>', true, false)"
                                                type="button">
                                            <span><?= Yii::t('site', 'DONATE_NOW') ?></span>
                                        </button>
                                        <a class="add-to-cart-btn" onclick="addToCart('#<?= $formId ?>', false, true)">
                                            <svg width="28" height="28" viewBox="0 0 28 28" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                        d="M26.2183 8.10906L23.4139 18.2022C23.2597 18.7535 22.9299 19.2396 22.4746 19.5866C22.0192 19.9336 21.4631 20.1226 20.8906 20.125H10.08C9.50582 20.1247 8.94747 19.9367 8.49012 19.5895C8.03277 19.2424 7.70152 18.7552 7.54688 18.2022L3.71 4.375H1.75C1.51794 4.375 1.29538 4.28281 1.13128 4.11872C0.967187 3.95462 0.875 3.73206 0.875 3.5C0.875 3.26794 0.967187 3.04538 1.13128 2.88128C1.29538 2.71719 1.51794 2.625 1.75 2.625H4.375C4.5663 2.62496 4.75234 2.68762 4.90464 2.80338C5.05694 2.91913 5.16711 3.08161 5.21828 3.26594L6.25516 7H25.375C25.5099 6.99997 25.643 7.03114 25.7638 7.09105C25.8847 7.15097 25.99 7.23802 26.0717 7.3454C26.1533 7.45277 26.2091 7.57758 26.2345 7.71005C26.2599 7.84253 26.2544 7.97908 26.2183 8.10906ZM9.625 21.875C9.27888 21.875 8.94054 21.9776 8.65275 22.1699C8.36497 22.3622 8.14066 22.6355 8.00821 22.9553C7.87576 23.2751 7.8411 23.6269 7.90863 23.9664C7.97615 24.3059 8.14282 24.6177 8.38756 24.8624C8.63231 25.1072 8.94413 25.2738 9.28359 25.3414C9.62306 25.4089 9.97493 25.3742 10.2947 25.2418C10.6145 25.1093 10.8878 24.885 11.0801 24.5972C11.2724 24.3095 11.375 23.9711 11.375 23.625C11.375 23.1609 11.1906 22.7158 10.8624 22.3876C10.5342 22.0594 10.0891 21.875 9.625 21.875ZM21 21.875C20.6539 21.875 20.3155 21.9776 20.0278 22.1699C19.74 22.3622 19.5157 22.6355 19.3832 22.9553C19.2508 23.2751 19.2161 23.6269 19.2836 23.9664C19.3512 24.3059 19.5178 24.6177 19.7626 24.8624C20.0073 25.1072 20.3191 25.2738 20.6586 25.3414C20.9981 25.4089 21.3499 25.3742 21.6697 25.2418C21.9895 25.1093 22.2628 24.885 22.4551 24.5972C22.6474 24.3095 22.75 23.9711 22.75 23.625C22.75 23.1609 22.5656 22.7158 22.2374 22.3876C21.9093 22.0594 21.4641 21.875 21 21.875Z"
                                                        fill="#FAFAFA"></path>
                                                <g clip-path="url(#clip0_938_63966)">
                                                    <path
                                                            d="M18.8127 13.9974C18.8127 14.1134 18.7666 14.2247 18.6845 14.3068C18.6025 14.3888 18.4912 14.4349 18.3752 14.4349H15.6043V17.2057C15.6043 17.3218 15.5582 17.433 15.4762 17.5151C15.3941 17.5971 15.2829 17.6432 15.1668 17.6432C15.0508 17.6432 14.9395 17.5971 14.8575 17.5151C14.7754 17.433 14.7293 17.3218 14.7293 17.2057V14.4349H11.9585C11.8425 14.4349 11.7312 14.3888 11.6491 14.3068C11.5671 14.2247 11.521 14.1134 11.521 13.9974C11.521 13.8814 11.5671 13.7701 11.6491 13.688C11.7312 13.606 11.8425 13.5599 11.9585 13.5599H14.7293V10.7891C14.7293 10.673 14.7754 10.5618 14.8575 10.4797C14.9395 10.3977 15.0508 10.3516 15.1668 10.3516C15.2829 10.3516 15.3941 10.3977 15.4762 10.4797C15.5582 10.5618 15.6043 10.673 15.6043 10.7891V13.5599H18.3752C18.4912 13.5599 18.6025 13.606 18.6845 13.688C18.7666 13.7701 18.8127 13.8814 18.8127 13.9974Z"
                                                            stroke="#041E42" stroke-width="0.5"></path>
                                                </g>
                                                <defs>
                                                    <clipPath id="clip0_938_63966">
                                                        <rect width="9.33333" height="9.33333" fill="white"
                                                              transform="translate(10.5 9.33203)">
                                                        </rect>
                                                    </clipPath>
                                                </defs>
                                            </svg>
                                        </a>
                                    </div>

                                </form>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="goal-achived-box">
                        <picture>
                            <img src="/theme/assets/Images/Donation-Flow/trophy 1.png" alt="">
                        </picture>
                        <h3><?= Yii::t('site', 'GOAL_ACHIEVED') ?></h3>
                        <p><?= $program->goal_achieved ?></p>
                    </div>
                <?php endif; ?>

                <?php if (count($program->features)): ?>
                    <div class="donation-numbers-box">
                        <?php foreach ($program->features as $feature): ?>
                            <?php if (empty($feature->image) || empty($feature->title_ar) || empty($feature->title_en) || empty($feature->value)) continue; ?>
                            <div class="donation-numbers-item">
                                <?= WebpImage::widget(["src" => $feature->image, "alt" => Yii::$app->language == "en" ? $feature->title_en : $feature->title_ar, "loading" => "lazy", 'css' => ""]) ?>

                                <h2 style="color: <?= $program->color ?> !important;"><?= $feature->value ?></h2>
                                <p><?= Yii::$app->language == "en" ? $feature->title_en : $feature->title_ar ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

<?php if (!empty($program->promotions)): ?>
    <?php
        $this->registerJsVar('promotions', count($program->promotions));
    ?>
    <div class="related-programs modal fade" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h2><?= Yii::t('site', 'PROMOTIONAL_ITEM_TITLES') ?></h2>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><?= Yii::t('site', 'PROMOTIONAL_ITEM_BRIEF') ?></p>
                    <div class="slider-wrapper container home-page-fourth-section position-relative donation-programs-slider">
                        <div class="colored-slider">
                            <?php foreach ($program->promotions as $promotion): ?>
                                <?php $program = $promotion->program; ?>
                                <div class="colored-slide wow fadeInUpBig">
                                    <div class="d-flex flex-column h-100 position-relative">
                                        <?= WebpImage::widget(["src" => $program->image, "alt" => $program->title, "loading" => "lazy", 'css' => ""]) ?>

                                        <div class="colored-slide-img"
                                             style="background: <?= $program->color ?> !important;">
                                            <?= WebpImage::widget(["src" => $program->tag_icon, "alt" => $program->tag, "loading" => "lazy", 'css' => ""]) ?>

                                            <span style="color: <?= $program->color ?> !important;"><?= $program->tag ?></span>
                                        </div>
                                        <div class="d-flex flex-column home-page-fourth-section-content  justify-content-start h-100 px-2">
                                            <h4><?= $program->title ?></h4>
                                            <p> <?= $program->brief ?> </p>
                                        </div>
                                    </div>
                                    <div class="px-2">
                                        <?php if ($program->progress != -1): ?>
                                            <div class="d-flex justify-content-between border-top pt-3">
                                                <div class="d-flex flex-column align-items-start raised-goal-ps">
                                                    <p><?= Yii::t('site', 'Raised') ?></p>
                                                    <p><?= number_format($program->raised, 2) ?> <?= Yii::t('site', 'JOD') ?></p>
                                                </div>
                                                <div class="d-flex flex-column align-items-end raised-goal-ps">
                                                    <p><?= Yii::t('site', 'Goal') ?></p>
                                                    <p><?= number_format($program->goal, 2) ?> <?= Yii::t('site', 'JOD') ?></p>
                                                </div>
                                            </div>
                                            <div class="main-colored-progress-bar border-bottom pb-4">
                                                <div class="outer-colored-progress-bar"
                                                     style="background: <?= $program->color ?> !important;"></div>
                                                <div class="inner-colored-progress-bar"
                                                     style="background: <?= $program->color ?> !important;"
                                                     progress="<?= (int)($program->progress) ?>%">
                                                    <span style="background: <?= $program->color ?> !important;"> </span>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <?php if ($program->has_amount && $program->has_goal && $program->progress >= 0 && $program->progress < 100): ?>
                                            <div class="d-flex justify-content-between border-bottom pt-2 pb-2 gap-1 mb-2">
                                                <?php $FID = uniqid('form-'); ?>
                                                <form class="position-relative w-100" id="program-<?= $program->id ?>"
                                                      method="post"
                                                      action="<?= Url::to(['/cart/add']) ?>">
                                                    <input type="hidden" name="<?= Yii::$app->request->csrfParam ?>"
                                                           value="<?= Yii::$app->request->csrfToken ?>"/>
                                                    <input type="hidden" name="items[0][type]" value="1"/>
                                                    <?php if (empty($program->parents) || empty($program->parents[0]->items)): ?>
                                                        <input type="hidden" name="items[0][donation]"
                                                               value="<?= TuaClient::PUBLIC_DONATIONS_TYPE_ID ?>"/>
                                                        <input type="hidden" name="items[0][campaign]"
                                                               value=""/>
                                                    <?php else: ?>
                                                        <input type="hidden" name="items[0][donation]"
                                                               value="<?= $program->parents[0]->items[0]?->donationType?->guid ?>"/>
                                                        <input type="hidden" name="items[0][campaign]"
                                                               value="<?= $program->parents[0]->items[0]?->campaign?->guid ?>"/>
                                                    <?php endif; ?>

                                                    <input type="hidden" name="items[0][guid]"
                                                           value="<?= uniqid('cart-item-') ?>"/>
                                                    <input type="hidden" name="items[0][recurrence]" value="once"
                                                           id="payment-recurrence-type"/>
                                                    <input type="hidden" name="items[0][quantity]" value="1"/>
                                                    <input type="hidden" name="items[0][currency]"
                                                           value="<?= Utility::selected_currency('slug') ?>"/>
                                                    <div>
                                                        <input type="text" placeholder="100" name="items[0][amount]"
                                                               id="amount" class="amount" tabindex="0" required/>
                                                        <button class="colored-slider-type-2-btn" tabindex="0" onclick="addToCart('#<?=$FID?>', true)"
                                                                type="submit"><?= Yii::t('site', 'Donate') ?></button>
                                                    </div>
                                                </form>

                                                <button onclick="addToCart('#<?=$FID?>')"
                                                        class="add-to-cart-btn" type="button">
                                                    <svg width="28" height="28" viewBox="0 0 28 28" fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                                d="M26.2183 8.10906L23.4139 18.2022C23.2597 18.7535 22.9299 19.2396 22.4746 19.5866C22.0192 19.9336 21.4631 20.1226 20.8906 20.125H10.08C9.50582 20.1247 8.94747 19.9367 8.49012 19.5895C8.03277 19.2424 7.70152 18.7552 7.54688 18.2022L3.71 4.375H1.75C1.51794 4.375 1.29538 4.28281 1.13128 4.11872C0.967187 3.95462 0.875 3.73206 0.875 3.5C0.875 3.26794 0.967187 3.04538 1.13128 2.88128C1.29538 2.71719 1.51794 2.625 1.75 2.625H4.375C4.5663 2.62496 4.75234 2.68762 4.90464 2.80338C5.05694 2.91913 5.16711 3.08161 5.21828 3.26594L6.25516 7H25.375C25.5099 6.99997 25.643 7.03114 25.7638 7.09105C25.8847 7.15097 25.99 7.23802 26.0717 7.3454C26.1533 7.45277 26.2091 7.57758 26.2345 7.71005C26.2599 7.84253 26.2544 7.97908 26.2183 8.10906ZM9.625 21.875C9.27888 21.875 8.94054 21.9776 8.65275 22.1699C8.36497 22.3622 8.14066 22.6355 8.00821 22.9553C7.87576 23.2751 7.8411 23.6269 7.90863 23.9664C7.97615 24.3059 8.14282 24.6177 8.38756 24.8624C8.63231 25.1072 8.94413 25.2738 9.28359 25.3414C9.62306 25.4089 9.97493 25.3742 10.2947 25.2418C10.6145 25.1093 10.8878 24.885 11.0801 24.5972C11.2724 24.3095 11.375 23.9711 11.375 23.625C11.375 23.1609 11.1906 22.7158 10.8624 22.3876C10.5342 22.0594 10.0891 21.875 9.625 21.875ZM21 21.875C20.6539 21.875 20.3155 21.9776 20.0278 22.1699C19.74 22.3622 19.5157 22.6355 19.3832 22.9553C19.2508 23.2751 19.2161 23.6269 19.2836 23.9664C19.3512 24.3059 19.5178 24.6177 19.7626 24.8624C20.0073 25.1072 20.3191 25.2738 20.6586 25.3414C20.9981 25.4089 21.3499 25.3742 21.6697 25.2418C21.9895 25.1093 22.2628 24.885 22.4551 24.5972C22.6474 24.3095 22.75 23.9711 22.75 23.625C22.75 23.1609 22.5656 22.7158 22.2374 22.3876C21.9093 22.0594 21.4641 21.875 21 21.875Z"/>
                                                        <g clip-path="url(#clip0_938_63966)">
                                                            <path
                                                                    d="M18.8127 13.9974C18.8127 14.1134 18.7666 14.2247 18.6845 14.3068C18.6025 14.3888 18.4912 14.4349 18.3752 14.4349H15.6043V17.2057C15.6043 17.3218 15.5582 17.433 15.4762 17.5151C15.3941 17.5971 15.2829 17.6432 15.1668 17.6432C15.0508 17.6432 14.9395 17.5971 14.8575 17.5151C14.7754 17.433 14.7293 17.3218 14.7293 17.2057V14.4349H11.9585C11.8425 14.4349 11.7312 14.3888 11.6491 14.3068C11.5671 14.2247 11.521 14.1134 11.521 13.9974C11.521 13.8814 11.5671 13.7701 11.6491 13.688C11.7312 13.606 11.8425 13.5599 11.9585 13.5599H14.7293V10.7891C14.7293 10.673 14.7754 10.5618 14.8575 10.4797C14.9395 10.3977 15.0508 10.3516 15.1668 10.3516C15.2829 10.3516 15.3941 10.3977 15.4762 10.4797C15.5582 10.5618 15.6043 10.673 15.6043 10.7891V13.5599H18.3752C18.4912 13.5599 18.6025 13.606 18.6845 13.688C18.7666 13.7701 18.8127 13.8814 18.8127 13.9974Z"
                                                                    stroke="#041E42" stroke-width="0.5"/>
                                                        </g>
                                                        <defs>
                                                            <clipPath id="clip0_938_63966">
                                                                <rect width="9.33333" height="9.33333" fill="white"
                                                                      transform="translate(10.5 9.33203)"/>
                                                            </clipPath>
                                                        </defs>
                                                    </svg>
                                                </button>
                                            </div>

                                        <?php endif; ?>

                                        <div class="buttons d-flex gap-2 pb-2 ">
                                            <a class="type-4-btn w-100"
                                               href="<?= Url::to(['/donation-programs/view/', 'slug' => $program->slug]) ?>">
                                                <span><?= Yii::t('site', 'MORE_DETAILS') ?></span>
                                                <svg width="21" height="21" viewBox="0 0 21 21" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                            d="M18.4152 11.1969L12.5089 17.1031C12.324 17.288 12.0732 17.3919 11.8117 17.3919C11.5502 17.3919 11.2993 17.288 11.1144 17.1031C10.9295 16.9182 10.8256 16.6674 10.8256 16.4058C10.8256 16.1443 10.9295 15.8935 11.1144 15.7086L15.3398 11.4848H3.28125C3.02018 11.4848 2.7698 11.3811 2.58519 11.1965C2.40059 11.0119 2.29688 10.7615 2.29688 10.5004C2.29688 10.2393 2.40059 9.98897 2.58519 9.80436C2.7698 9.61975 3.02018 9.51604 3.28125 9.51604H15.3398L11.1161 5.28979C10.9311 5.10487 10.8272 4.85405 10.8272 4.59253C10.8272 4.331 10.9311 4.08019 11.1161 3.89526C11.301 3.71034 11.5518 3.60645 11.8133 3.60645C12.0748 3.60645 12.3257 3.71034 12.5106 3.89526L18.4168 9.80151C18.5086 9.89309 18.5814 10.0019 18.631 10.1217C18.6806 10.2415 18.7061 10.3699 18.706 10.4995C18.7058 10.6292 18.68 10.7575 18.6301 10.8772C18.5802 10.9969 18.5072 11.1055 18.4152 11.1969Z"/>
                                                </svg>
                                            </a>
                                            <?= frontend\widgets\cards_share_button\CardsShareButton::widget() ?>


                                        </div>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

<?php endif; ?>

<?php

$this->registerJsVar('language', Yii::$app->language);
$this->registerJsVar('currency', Utility::selected_currency('title'));
$this->registerJsVar('formId', $formId);

$script = <<< JS
   $(document).ready(function () {
    let direction = $("main").hasClass("arabic-version");
    
    $(".donation-flow-main-section .recurrence-type").on('click', function () {
        let interval = $(this).data('recurring');
        let total = $('.donation-items-total .price');
        $('.donation-flow-main-section .recurrence-type').removeClass('active');
        $(this).addClass('active');
        
        let items = $('.donation-item').each(function (index, item){
            item = $(item);
            let quantity = item.find("h4.quantity");
            quantity.text(0);
            item.find('input.item-recurrence-type').val(interval);
            item.find('input.quantity').val(0); 
            if (item.data('has-amount')){
                item.find('input.amount').val("");
                item.find('input.quantity').val(1);
            }
            item.find('h5.price').text((parseFloat(item.data('price')) * (interval === "yearly" ? 12 : 1)).toFixed(2) + " " + currency);
        });
        
        total.text(0);
    });
            
    $(".donation-form .add-transaction-fees").on('click', function (){
           let form = $(this).closest('form');
           form.find('.item-add-transaction-fees').remove();
           
           if ($(this).is(':checked')){
               form.find('.donation-item').each(function (index, element){
                   $(element).append("<input type='hidden' name='items[" + index + "][add_transaction_fees]' class='item-add-transaction-fees' value='1'/>");
               })
           }
    });

    $(".donation-flow-main-section .minus").on('click', function(){
        let item = $(this).closest('.donation-item');
        let quantity = item.find("h4.quantity");
        let _quantity = parseInt(quantity.text());
        let total = $('.donation-items-total .price');
        let _total = parseInt(total.text());
        if (_quantity === 0)
            return;
        quantity.text(_quantity - 1);
        total.text((_total - parseFloat($(this).data('price') * (item.find('.item-recurrence-type').val() === "yearly" ? 12 : 1))).toFixed(2))
        item.find('input.quantity').val(_quantity - 1);
        if (_quantity - 1 === 0) {
        $(this).addClass('disabled');
        }
    });

    $(".donation-flow-main-section .plus").on('click', function(){
        let item = $(this).closest('.donation-item');

        let quantity = item.find("h4.quantity");
        let _quantity = parseInt(quantity.text());
            let total = $('.donation-items-total .price');
        let _total = parseInt(total.text());
        quantity.text(_quantity + 1);
        total.text((_total + parseFloat($(this).data('price') * (item.find('.item-recurrence-type').val() === "yearly" ? 12 : 1))).toFixed(2))
        item.find('input.quantity').val(_quantity + 1);
        item.find('.minus').removeClass('disabled'); 
    });

    $('.donation-flow-main-section .donation-item').each(function(){
        let item = $(this);
        let quantity = parseInt(item.find('h4.quantity').text());
        if (quantity === 0) {
            item.find('.minus').addClass('disabled');
        }
        });

    $(".donation-flow-main-section .parents button").on('click', function(e){
            e.preventDefault();
            $(".select-currency-box").addClass("d-none").find('input').prop('disabled', 'disabled');
            $("#" + $(this).data('target')).removeClass('d-none').find('input').removeAttr('disabled');
            $(".parents button").removeClass("active");
            $(this).addClass('active');
            $('.donation-item').each(function (index, item){
                item = $(item);
                item.find("h4.quantity").text(0);
                item.find('input.quantity').val(0); 
                if (item.data('has-amount')){
                    item.find('input.amount').val("");
                    item.find('input.quantity').val(1);
                }  
            });
            $('.donation-items-total .price').text(0);
        });
    
    $(".donation-flow-main-section .recurring button").on('click', function(e){
            e.preventDefault();
            let form = $(this).closest('form');
            form.find('.item-recurrence-type').val($(this).data('recurring'));
            $(".recurring button").removeClass("active");
            $(this).addClass('active');
        });
    
  let sliderInitialized = false;

  $('.related-programs').on('shown.bs.modal', function () {
    const windowWidth = $(window).width();
    if (windowWidth > 992 && !sliderInitialized) {
      setTimeout(function() {
        $(".colored-slider").css({ "opacity": 1 });
        $(".colored-slider").slick({
          rtl: direction,
          arrows: true,
          dots: true,
          slidesToShow: promotions,
          slidesToScroll: 1,
          nextArrow:
              '<button class="slick-next"><i class="fa-solid fa-arrow-right"></i></button>',
          prevArrow:
              '<button class="slick-prev"><i class="fa-solid fa-arrow-left"></i></button>',
          responsive: [
            {
              breakpoint: 1400,
              settings: {
                slidesToShow: 3,
              },
            }
          ],
        });
        sliderInitialized = true;
      }, 500);
    }
  });

    $(".donation-flow-slider").slick({
                rtl: direction,
                dots: true,
                infinite: true,
                slidesToShow: 3,
                slidesToScroll: 1,
                nextArrow: $(".donation-flow-slider-next"),
                prevArrow: $(".donation-flow-slider-prev"),
                responsive: [
                    {
                        breakpoint: 992,
                        settings: {
                            slidesToShow: 2,
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
        });
JS;
$this->registerJs($script);

?>