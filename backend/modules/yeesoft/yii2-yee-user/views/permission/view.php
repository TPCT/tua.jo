<?php
/**
 * @var $this yii\web\View
 * @var yeesoft\widgets\ActiveForm $form
 * @var array $childRoutes
 * @var yii\rbac\Permission $item
 */

use yeesoft\helpers\Html;
use yeesoft\models\User;
use yii\helpers\ArrayHelper;

$this->title = Yii::t('yee/user', '{permission} Permission Settings', ['permission' => $item->description]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('yee/user', 'Users'), 'url' => ['/user/default/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('yee/user', 'Permissions'), 'url' => ['/user/permission']];
$this->params['breadcrumbs'][] = $this->title;
?>

    <div class="row">
        <div class="col-sm-12">
            <h3 class="lte-hide-title page-title"><?= Html::encode($this->title) ?></h3>
            <?= Html::a(Yii::t('yee', 'Auto Add Permissions'), ['auto-add-permissions'], ['class' => 'btn btn-sm btn-success']) ?>
        </div>
    </div>

    <div class="row">

        <div class="col-sm-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>
                        <span class="glyphicon glyphicon-th"></span><?= Yii::t('yee/user', 'Routes') ?>
                    </strong>
                </div>

                <div class="panel-body">

                    <?= Html::beginForm(['set-child-routes', 'id' => $item->name]) ?>

                    <div class="row">
                        <div class="col-sm-3">
                            <?php if (User::hasPermission('manageRolesAndPermissions')): ?>
                                <?= Html::submitButton(Yii::t('yee', 'Save'), ['class' => 'btn btn-primary btn-sm']) ?>
                            <?php endif; ?>
                        </div>

                    </div>

                    <hr/>

                    <div class="container">


                        <?php foreach($mainModule as $module):  ?>

                            <div class="row moduel-heading">

                                <a class="btn d-block" data-bs-toggle="collapse" href="#collapseMain-<?= $module->module  ?>" role="button" aria-expanded="false" aria-controls="collapseMain-<?= $module->module  ?>">
                                    <h3 class="module-title"> <?= $module->module ?> </h3>
                                </a>

                                <div class="collapse" id="collapseMain-<?= $module->module  ?>">
                                    <?= Html::checkbox('child_routes[]', in_array ('/*',$values) , [
                                        'label' => 'all links',
                                        'value'=> '/*',
                                        'class' => 'custom-class',
                                    ]) ?>

                                    <?php foreach($module->mainControllers as $controller): ?>
                                        <div class="col-sm-6">
                                            <a class="btn d-block" data-bs-toggle="collapse" href="#collapseMain-<?= $module->module  ?>-<?= $controller->mainControllerName  ?>" role="button" aria-expanded="false" aria-controls="collapseMain-<?= $module->module  ?>-<?= $controller->mainControllerName  ?>">
                                                <h4 class="controller-title"> <?= $controller->mainControllerName ?> </h4>  
                                            </a>

                                            <div class="collapse" id="collapseMain-<?= $module->module  ?>-<?= $controller->mainControllerName  ?>">
                                                <?= Html::checkbox('child_routes[]', in_array ($controller->name,$values) , [
                                                    'label' => $controller->action,
                                                    'value'=> $controller->name,
                                                    'class' => 'custom-class',
                                                ]) ?>

                                                <?php foreach($controller->mainControllerActions as $action): ?>
                                                    <div class="col-sm-6">
                                                        <?= Html::checkbox('child_routes[]', in_array ($action->name,$values) , [
                                                            'label' => $action->action,
                                                            'value'=> $action->name,
                                                            'class' => 'custom-class',
                                                        ]) ?>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>

                                        </div>
                                    <?php endforeach; ?>
                                    
                                </div>
                                    
                            </div>

                        <?php endforeach; ?>

                        
                        <?php foreach($modules as $module):  ?>

                            <div class="row moduel-heading">

                                <a class="btn d-block" data-bs-toggle="collapse" href="#collapseAll-<?= $module->module  ?>" role="button" aria-expanded="false" aria-controls="collapseAll-<?= $module->module  ?>">
                                    <h3 class="module-title"> <?= $module->module ?> </h3>
                                </a>

                                <div class="collapse" id="collapseAll-<?= $module->module  ?>">
                                    <?= Html::checkbox('child_routes[]', in_array ($module->name,$values) , [
                                        'label' => $module->action,
                                        'value'=> $module->name,
                                        'class' => 'custom-class',
                                    ]) ?>


                                    <?php foreach($module->controllers as $controller): ?>
                                        <div class="col-sm-6">
                                            <a class="btn d-block" data-bs-toggle="collapse" href="#collapseAll-<?= $module->module  ?>-<?= $controller->controller  ?>" role="button" aria-expanded="false" aria-controls="-<?= $module->module  ?>-<?= $controller->controller  ?>">
                                                <h4 class="controller-title"> <?= $controller->controller ?> </h4>  
                                            </a>
                                            
                                            <div class="collapse" id="collapseAll-<?= $module->module  ?>-<?= $controller->controller  ?>">
                                                <?= Html::checkbox('child_routes[]', in_array ($controller->name,$values) , [
                                                    'label' => $controller->action,
                                                    'value'=> $controller->name,
                                                    'class' => 'custom-class',
                                                ]) ?>

                                                <?php foreach($controller->actions as $action): ?>
                                                    <div class="col-sm-6">
                                                        <?= Html::checkbox('child_routes[]', in_array ($action->name,$values) , [
                                                            'label' => $action->action,
                                                            'value'=> $action->name,
                                                            'class' => 'custom-class',
                                                        ]) ?>
                                                    </div>
                                                <?php endforeach; ?>
                                            </div>

                                        </div>
                                    <?php endforeach; ?>

                                </div>

                                    
                            </div>
                            
                        <?php endforeach; ?>
                            
                    </div>

                    

                    <hr/>
                    <?php if (User::hasPermission('manageRolesAndPermissions')): ?>
                        <?= Html::submitButton(Yii::t('yee', 'Save'), ['class' => 'btn btn-primary btn-sm']) ?>
                    <?php endif; ?>

                    <?= Html::endForm() ?>

                </div>
            </div>
        </div>
    </div>

<?php
$js = <<<JS


JS;

$this->registerJs($js);
?>