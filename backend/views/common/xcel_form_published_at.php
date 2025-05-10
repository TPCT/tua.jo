<?php

use yeesoft\helpers\Html;
use yeesoft\models\User;
use yeesoft\widgets\ActiveForm;
use yeesoft\widgets\LanguagePills;
use yii\helpers\ArrayHelper;
use yii\jui\DatePicker;
use kartik\number\NumberControl;

/* @var $this yii\web\View */
/* @var $model \backend\modules\merchant\models\Merchant */
/* @var $form yeesoft\widgets\ActiveForm */

$modelParts = explode("\\",$currentModel);
$modelname = end($modelParts);
$modelRoute = $modelParts[2];

$this->title = Yii::t('site', 'Import Excel Sheet');
$this->params['breadcrumbs'][] = ['label' => Yii::t('site', $modelname ), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="page-create">
    <h3 class="lte-hide-title"><?= Html::encode($this->title) ?></h3>
    <div class="page-form">

        <?php
        $form = ActiveForm::begin([
            'id' => 'page-form',
            'validateOnBlur' => false,
        ]);
        ?>
        <?= $form->errorSummary($model, ['class' => 'alert alert-danger']); ?>
        <?php if( isset($errors) ): ?>
            <div class="alert alert-danger error-summary">
                <p> <?= Yii::t("site","Some not stored have following errors:") ?> </p>
                <ul>
                    <?php foreach($errors as $error): ?>
                        <?php foreach($error as $key): ?>
                            <?php foreach($key as $value):  ?>
                                <li>  <?= $value ?> </li>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-9">

                <div class="panel panel-default">
                    <div class="panel-body">
                    
                        <?= $form->field($model, 'file')->fileInput()  ?>

                        <?=
                            $form->field($model, 'published_at')
                            ->widget(DatePicker::className(), ['dateFormat' => 'yyyy-MM-dd', 'options' => ['class' => 'form-control']]);
                        ?>

                    </div>
                </div>
            </div>

            <div class="col-md-3">

                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="record-info">
    

                            <div class="form-group">
                                <?= Html::submitButton(Yii::t('yee', 'Save'), ['class' => 'btn btn-primary']) ?>
                                <?= Html::a(Yii::t('yee', 'Cancel'), ["/{$modelRoute}/index"], ['class' => 'btn btn-default',]) ?>
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>

<?php
$script = <<< JS
$(document).ready(function(){
    
});

JS;
$this->registerJs($script);
?>
