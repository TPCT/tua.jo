<?php
/**
 * Created by PhpStorm.
 * User: ajoudeh
 * Date: 7/5/18
 * Time: 10:05 PM
 */

use backend\modules\news\models\News;
use backend\modules\faq\models\FAQ;
use kartik\helpers\Html;
use yeesoft\media\widgets\TinyMce;
use yeesoft\settings\assets\SettingsAsset;
use yeesoft\widgets\ActiveForm;
use kartik\number\NumberControl;

/* @var $this yii\web\View */
/* @var $model backend\models\SiteSettings */
/* @var $form yeesoft\widgets\ActiveForm */


$this->title = Yii::t('yee/settings', 'Gold Prices');
$this->params['breadcrumbs'][] = $this->title;


SettingsAsset::register($this);
?>

    <div class="clearfix"></div>
    <div class="page-form">
        <?php
        $form = ActiveForm::begin([
            'id' => 'setting-form',
            'validateOnBlur' => false,
        ])
        ?>
        <?= $form->errorSummary($model, ['class' => 'alert alert-danger']); ?>

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="record-info">
                            <div class="form-group">

                                <?= $form->field($model, 'gold_24_price')->widget(NumberControl::classname(), [
                                    'displayOptions' => [
                                        'placeholder' => '100'
                                    ],
                                    'maskedInputOptions' => [
                                        'min' => 0,
                                        'rightAlign' => false,

                                    ],
                                ]); ?>

                                <?= $form->field($model, 'gold_22_price')->widget(NumberControl::classname(), [
                                    'displayOptions' => [
                                        'placeholder' => '100'
                                    ],
                                    'maskedInputOptions' => [
                                        'min' => 0,
                                        'rightAlign' => false,

                                    ],
                                ]); ?>


                                <?= $form->field($model, 'gold_21_price')->widget(NumberControl::classname(), [
                                    'displayOptions' => [
                                        'placeholder' => '100'
                                    ],
                                    'maskedInputOptions' => [
                                        'min' => 0,
                                        'rightAlign' => false,

                                    ],
                                ]); ?>


                                <?= $form->field($model, 'gold_18_price')->widget(NumberControl::classname(), [
                                    'displayOptions' => [
                                        'placeholder' => '100'
                                    ],
                                    'maskedInputOptions' => [
                                        'min' => 0,
                                        'rightAlign' => false,

                                    ],
                                ]); ?>


                            </div>
                        </div>
                    </div>
                </div>



            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <?= Html::submitButton(Yii::t('yee', 'Save'), ['class' => 'btn btn-primary']) ?>
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