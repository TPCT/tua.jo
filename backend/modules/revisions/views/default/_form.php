<?php

use yeesoft\helpers\Html;
use yeesoft\models\User;
use yeesoft\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model \backend\modules\revisions\models\Revisions */
/* @var $form yeesoft\widgets\ActiveForm */

?>

    <div class="revisions-form">

        <?php
        $form = ActiveForm::begin([
            'id' => 'revisions-form',
            'validateOnBlur' => false,
        ])
        ?>
        <?= $form->errorSummary($model, ['class' => 'alert alert-danger']); ?>

        <div class="row">
            <div class="col-md-9">

                <div class="panel panel-default">
                    <div class="panel-body">
                        
                        <?= $form->field($model, 'model')->dropDownList($model->getAllActiveModlesandModuleKey(),["prompt"=>Yii::t("site","Select Model"), 'class'=>'form-select']) ?>

                        <?php // $form->field($model, 'module_key')->hiddenInput()->label(""); ?>


                    </div>
                </div>
            </div>


            <div class="col-md-3">

                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="record-info">
                            <?php if (!$model->isNewRecord): ?>

                                <div class="form-group clearfix">
                                    <label class="control-label" style="float: left; padding-right: 5px;">
                                        <?= $model->attributeLabels()['created_at'] ?> :
                                    </label>
                                    <span><?= $model->createdDatetime ?></span>
                                </div>

                                <div class="form-group clearfix">
                                    <label class="control-label" style="float: left; padding-right: 5px;">
                                        <?= $model->attributeLabels()['updated_at'] ?> :
                                    </label>
                                    <span><?= $model->updatedDatetime ?></span>
                                </div>


                            <?php endif; ?>

                            <div class="form-group">
                                <?php if ($model->isNewRecord): ?>
                                    <?= Html::submitButton(Yii::t('yee', 'Create'), ['class' => 'btn btn-primary']) ?>
                                    <?= Html::a(Yii::t('yee', 'Cancel'), ['/revisions/default/index'], ['class' => 'btn btn-default',]) ?>
                                <?php else: ?>
                                    <?= Html::submitButton(Yii::t('yee', 'Save'), ['class' => 'btn btn-primary']) ?>
                                    <?php
                                        //$this->render('//common/_preview-button', ["model"=>$model,"with_preview"=>true,"front_url"=>"/retail/revisionss/"]);
                                    ?>
                                    <?=
                                    Html::a(Yii::t('yee', 'Delete'), ['/revisions/default/delete', 'id' => $model->id], [
                                        'class' => 'btn btn-default',
                                        'data' => [
                                            'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                            'method' => 'post',
                                        ],
                                    ])
                                    ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div class="panel-body">

                        <div class="record-info">

                            <?php if (!$model->isNewRecord): ?>
                                <?php $form->field($model, 'created_by')->dropDownList(User::getUsersList(), ['class'=>'form-select'] ) ?>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>

            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>


<?php


$js = <<<JS
   
    
JS;

$this->registerJs($js, yii\web\View::POS_END);
?>