<?php

use yeesoft\widgets\ActiveForm;
use backend\modules\subdistrict\models\Subdistrict;
use yeesoft\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\subdistrict\models\Subdistrict */
/* @var $form yeesoft\widgets\ActiveForm */
?>

<div class="subdistrict-form">

    <?php 
    $form = ActiveForm::begin([
            'id' => 'subdistrict-form',
            'validateOnBlur' => false,
        ])
    ?>

    <div class="row">
        <div class="col-md-9">

            <div class="panel panel-default">
                <div class="panel-body">



                    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                    <?php try {
                        echo $form->field($model, 'district_id')->dropDownList(\yii\helpers\ArrayHelper::map(\backend\modules\district\models\District::find()->all(), 'id', 'title'), ['prompt' => '', 'encodeSpaces' => true]);
                    } catch (\yii\base\InvalidConfigException $e) {
                    } ?>




                </div>

            </div>
        </div>


        <div class="col-md-3">

            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="record-info">
                        <div class="form-group clearfix">
                            <label class="control-label" style="float: left; padding-right: 5px;"><?=  $model->attributeLabels()['id'] ?>: </label>
                            <span><?=  $model->id ?></span>
                        </div>

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

                            <div class="form-group clearfix">
                                <label class="control-label" style="float: left; padding-right: 5px;">
                                    <?= $model->attributeLabels()['updated_by'] ?> :
                                </label>
                                <span><?= $model->updatedBy->username ?></span>
                            </div>

                        <?php endif; ?>


                        <div class="form-group">
                            <?php  if ($model->isNewRecord): ?>
                                <?= Html::submitButton(Yii::t('yee', 'Create'), ['class' => 'btn btn-primary']) ?>
                                <?= Html::a(Yii::t('yee', 'Cancel'), ['/subdistrict/default/index'], ['class' => 'btn btn-default']) ?>
                            <?php  else: ?>
                                <?= Html::submitButton(Yii::t('yee', 'Save'), ['class' => 'btn btn-primary']) ?>
                                <?= Html::a(Yii::t('yee', 'Delete'),
                                    ['/subdistrict/default/delete', 'id' => $model->id], [
                                    'class' => 'btn btn-default',
                                    'data' => [
                                        'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                        'method' => 'post',
                                    ],
                                ]) ?>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-body">

                    <div class="record-info">

                        <?= $form->field($model, 'status')->dropDownList(\yeesoft\page\models\Page::getStatusList()) ?>

                        <?php if (!$model->isNewRecord): ?>
                            <?= $form->field($model, 'created_by')->dropDownList(\common\models\User::getUsersList()) ?>
                        <?php endif; ?>

                    </div>
                </div>
            </div>

        </div>
    </div>

    <?php  ActiveForm::end(); ?>

</div>
