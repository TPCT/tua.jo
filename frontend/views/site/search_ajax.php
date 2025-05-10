<?php

use yii\helpers\Url;

$lng = Yii::$app->language;



?>


                        <?php if( isset($searchSections) && count($searchSections) ): ?>
                            <?php foreach($searchSections as $key=> $section): ?>
                                
                                <?php $section_id = explode("\\",$section['model']); $section_id = end($section_id) ?>


                                    <?php foreach($section["items"] as $item): ?>
                                        <div class="search-product__card">
                                            <h3>
                                                <a href="<?= $item['siteUrl']; ?>" > <?= $item['title'] ?> </a>
                                            </h3>
                                            <p> <?= $item['brief']??'' ?> </p>
                                        </div>
                                    <?php endforeach; ?>

                                    <?php if( isset($section["pagination"]) ): ?>
                                        <?php 
                                            if($section["pagination"]["pageCount"] -1 > $section["pagination"]["page"]): 
                                                $page = $section["pagination"]["page"] + 1;
                                        ?>

                                            <div class="search-read-more" id="<?= $section_id."_pagination"  ?>" >
                                                <div class="col-lg-12 col-md-12">
                                                    <div class="add--read_more">
                                                        <a href="<?= Url::to(['/site/search']) ?>" class="load-more" data-model="<?= $section['model'] ?>" data-page="<?= $page ?>" data-section="<?= $section_id ?>" >
                                                            <svg
                                                                xmlns="http://www.w3.org/2000/svg"
                                                                width="24"
                                                                height="24"
                                                                viewBox="0 0 24 24"
                                                                fill="#000"
                                                                stroke="#000"
                                                                stroke-width="2"
                                                                stroke-linecap="round"
                                                                stroke-linejoin="round"
                                                                class="lucide lucide-plus"
                                                            >
                                                                <path d="M5 12h14" />
                                                                <path d="M12 5v14" />
                                                            </svg>
                                                            <?= Yii::t("site","LOAD_MORE") ?>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>

                                        <?php endif; ?>
                                    <?php endif; ?>
                                

                            <?php endforeach; ?>
                        <?php endif; ?>
