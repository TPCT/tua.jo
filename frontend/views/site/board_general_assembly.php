<?php

use frontend\widgets\HeaderImage;



$this->title = Yii::t('site', 'BOARD_GENERAL_ASSEMBLY');
$this->description = Yii::t('site', 'BOARD_GENERAL_ASSEMBLY_DESCRIPTION');


$this->registerCssFile("/theme/css/board-general-assembly.css", ['depends' => [\frontend\assets\AppAsset::className()],]);

$lng = Yii::$app->language;

?>


<?= HeaderImage::widget(['is_inner'=> true , 'path'=>'/board-general-assembly' ]) ?>


<?php if($boardGeneralAssemblySection): ?>

    <section>
        <div class="container assembly-main-container">
               
                <?= \frontend\widgets\WebpImage::widget(["src" => $boardGeneralAssemblySection->image, "alt" => $boardGeneralAssemblySection->title, "loading" => "lazy", 'css' => ""]) ?>

            <div>
                <h2> <?= $boardGeneralAssemblySection->title ?></h2>
                <h3 class="assemply-1st-p"><?= $boardGeneralAssemblySection->second_title ?></h3>

                <?= $boardGeneralAssemblySection->content ?>
                
                <p class="assemply-2nd-p"> <?= $boardGeneralAssemblySection->brief ?></p>
            </div>
        </div>
    </section>
    <?php endif; ?>
    <?php if($boardGeneralAssemblySections): ?>

    <section>
        <div class="conatiner assembly-accordion">
                <div
                  class="container accordion accordion-flush custom-accordion"
                  id="faqsFlushExample"
                >
                <?php foreach ($boardGeneralAssemblySections as $key => $item): ?>

                    <div class="accordion-item">
                      <h2 class="accordion-header" id="flush-heading<?= $key ?>">
                        <button
                          class="accordion-button collapsed"
                          type="button"
                          data-bs-toggle="collapse"
                          data-bs-target="#flush-collapse<?= $key ?>"
                          aria-expanded="false"
                          aria-controls="flush-collapse<?= $key ?>"
                        >
                   
                        <?= $item->title ?> 
                          <span class="accordion-btn">
                            <i class="fa-solid fa-plus"></i>
                            <i class="fa-solid fa-minus"></i>
                          </span>
                        </button>
                      </h2>
                      <div
                        id="flush-collapse<?= $key ?>"
                        class="accordion-collapse collapse"
                        aria-labelledby="flush-heading<?= $key ?>"
                        data-bs-parent="#faqsFlushExample"
                      >
                        <div class="accordion-body">
                            <div class="assembly-accordion-body">
                            <?php foreach ($item->bmsFeatures as $features): ?>
                                <div>
                                    <h3><?= $features["title_" . $lng] ?> </h3>
                                    <p><?= $features["second_title_" . $lng] ?></p>
                                </div>
                                <?php endforeach; ?>

                            </div>
                        </div>
                      </div>
                    </div>

                    <?php endforeach; ?>

                </div>
        </div>
    </section>

    <?php endif; ?>