<?php
/**
 * @var $this yii\web\View
 * @var yeesoft\widgets\ActiveForm $form
 * @var array $childRoutes
 * @var yii\rbac\Permission $item
 */

 use yeesoft\widgets\ActiveForm;
use yeesoft\helpers\Html;
use yeesoft\models\User;
use yii\helpers\ArrayHelper;

$this->title = Yii::t('yee/user', 'Add New Route', ['permission' => $item->description]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('yee/user', 'Users'), 'url' => ['/user/default/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('yee/user', 'Permissions'), 'url' => ['/user/permission']];
$this->params['breadcrumbs'][] = $this->title;
?>

    <div class="row">
        <div class="col-sm-12">
            <h3 class="lte-hide-title page-title"><?= Html::encode($this->title) ?></h3>
        </div>
    </div>


    <?php
        $form = ActiveForm::begin([
            'id' => 'account-form',
            'validateOnBlur' => true,
        ])
        ?>
        <?= $form->errorSummary($model, ['class' => 'alert alert-danger']); ?>

        <div class="row">
            <div class="col-md-9">

                <div class="panel panel-default">
                    <div class="panel-body">

                        <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'module')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'action')->textInput(['maxlength' => true]) ?>

                        <?= Html::submitButton(Yii::t('yee', 'Save'), ['class' => 'btn btn-primary']) ?>
        
                    </div>
                </div>
            </div>
        </div>

    <?php ActiveForm::end(); ?>


<?php
$js = <<<JS


JS;

$this->registerJs($js);
?>