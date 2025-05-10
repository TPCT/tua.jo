<?php

use backend\assets\SweetAlertAsset;
use backend\modules\home_page_item\models\HomePageItem;
use yeesoft\helpers\Html;
use yii\jui\DatePicker;
SweetAlertAsset::register($this);

?>

<!-- Modal -->
<div class="modal fade" id="first-section-modal" tabindex="-1" aria-labelledby="first-section-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="first-section-modal-label" >Promote To First Section at Home Page</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php
                    $firstModel = $model->firstHomePage??  new HomePageItem();

                    $firstForm = \kartik\form\ActiveForm::begin([
                        'id' => 'homepage-first-form',
                        'action'=> $firstModel->isNewRecord? ["/home_page_item/default/create"] : ["/home_page_item/default/update/{$firstModel->id}"],
                        'method' =>'post',
                        'options'=>[
                            'class' => 'modal-form',
                        ],
                    ]); 
                    
                
                ?>

                    <?= $firstForm->errorSummary($firstModel, ['class' => 'alert alert-danger']); ?>

                    <div class="row">
                        <div class="col-md-12">

                            <div class="panel panel-default">
                                <div class="panel-body">


                                    <?= $firstForm->field($firstModel, 'model')->hiddenInput(['value' => $model::class])->label(false) ?>
                                    <?= $firstForm->field($firstModel, 'model_id')->hiddenInput(['value' => $model->id])->label(false) ?>

                                    <?= $firstForm->field($firstModel, 'type')->hiddenInput(["value"=>$firstModel::FIRST_HOME_PAGE_SECTION])->label(false) ?>


                                    <?= $firstForm->field($firstModel, 'weight_order')->textInput(["type"=>"number"]) ?>

                                    <?= $firstForm->field($firstModel, 'language_en')->checkbox() ?>
                                    <?= $firstForm->field($firstModel, 'language_ar')->checkbox() ?>

                                    <?= $firstForm->field($firstModel, 'published_at')
                                        ->widget(DatePicker::className(), ['dateFormat' => 'yyyy-MM-dd', 'options' => ['class' => 'form-control']]);
                                    ?>

                                    <?php if( $firstModel->canMakerSeeStatus() ): ?>
                                        <?= $firstForm->field($firstModel, 'status')->dropDownList(HomePageItem::getStatusList()) ?>
                                    <?php endif; ?>

                                </div>
                            </div>


                        </div>

                    </div>


                <?php \kartik\form\ActiveForm::end(); ?>

            </div>
            <div class="modal-footer">
                <?= Html::button(Yii::t('site', 'SAVE'), ['class' => 'btn btn-primary submit-modal-form', ]) ?>
            </div>
        </div>
    </div>
</div>



<!-- Modal -->
<div class="modal fade" id="files-section-modal" tabindex="-1" aria-labelledby="files-section-modal-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="files-section-modal-label" >Promote To Files Section at Home Page</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php
                    $filesModel = $model->filesHomePage??  new HomePageItem();

                    $filesForm = \kartik\form\ActiveForm::begin([
                        'id' => 'homepage-files-form',
                        'action'=> $filesModel->isNewRecord? ["/home_page_item/default/create"] : ["/home_page_item/default/update/{$filesModel->id}"],
                        'method' =>'post',
                        'options'=>[
                            'class' => 'modal-form',
                        ],
                    ]); 
                    
                
                ?>

                    <?= $filesForm->errorSummary($filesModel, ['class' => 'alert alert-danger']); ?>

                    <div class="row">
                        <div class="col-md-12">

                            <div class="panel panel-default">
                                <div class="panel-body">


                                    <?= $filesForm->field($filesModel, 'model')->hiddenInput(['value' => $model::class])->label(false) ?>
                                    <?= $filesForm->field($filesModel, 'model_id')->hiddenInput(['value' => $model->id])->label(false) ?>

                                    <?= $filesForm->field($filesModel, 'type')->hiddenInput(["value"=>$filesModel::FILES_HOME_PAGE_SECTION])->label(false) ?>

                                    <?= $filesForm->field($filesModel, 'weight_order')->textInput(["type"=>"number"]) ?>

                                    <?= $filesForm->field($filesModel, 'language_en')->checkbox() ?>
                                    <?= $filesForm->field($filesModel, 'language_ar')->checkbox() ?>
                                    
                                    <?= $filesForm->field($filesModel, 'published_at')
                                        ->widget(DatePicker::className(), ['dateFormat' => 'yyyy-MM-dd', 'options' => ['class' => 'form-control']]);
                                    ?>

                                    <?php if( $filesModel->canMakerSeeStatus() ): ?>
                                        <?= $filesForm->field($filesModel, 'status')->dropDownList(HomePageItem::getStatusList()) ?>
                                    <?php endif; ?>

                                </div>
                            </div>


                        </div>

                    </div>


                <?php \kartik\form\ActiveForm::end(); ?>

            </div>
            <div class="modal-footer">
                <?= Html::button(Yii::t('site', 'SAVE'), ['class' => 'btn btn-primary submit-modal-form', ]) ?>
            </div>
        </div>
    </div>
</div>



