<?php
/**
 * @var yeesoft\widgets\ActiveForm $form
 * @var array $childRoles
 * @var array $allRoles
 * @var array $routes
 * @var array $currentRoutes
 * @var array $permissionsByGroup
 * @var array $currentPermissions
 * @var yii\rbac\Role $role
 */

use yeesoft\helpers\Html;
use yeesoft\models\Role;
use yeesoft\models\User;
use yii\helpers\ArrayHelper;

$this->title = Yii::t('yee/user', '{permission} Role Settings', ['permission' => $role->description]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('yee/user', 'Users'), 'url' => ['/user/default/index']];
$this->params['breadcrumbs'][] = ['label' => Yii::t('yee/user', 'Roles'), 'url' => ['/user/role/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

    <div class="row">
        <div class="col-sm-12">
            <h3 class="lte-hide-title page-title"><?= Html::encode($this->title) ?></h3>
            <?= Html::a(Yii::t('yee', 'Edit'), ['update', 'id' => $role->name], ['class' => 'btn btn-sm btn-primary']) ?>
            <?= Html::a(Yii::t('yee', 'Create'), ['create'], ['class' => 'btn btn-sm btn-primary']) ?>
        </div>
    </div>

    <div class="row">

        <div class="col-sm-10">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>
                        <span class="glyphicon glyphicon-th"></span>
                        <?= Yii::t('yee/user', 'Permissions') ?>
                    </strong>
                </div>
                <div class="panel-body">
                    <?= Html::beginForm(['set-child-permissions', 'id' => $role->name]) ?>

                    <div class="row">

                        <?php foreach($permissions as $permission): ?>
                            <?php $class = $permission->group_code? 'default-permission' : 'new-permission'; ?>
                            <?php $secondClass = in_array($permission->name,["maker","Maker"])? 'maker-permission' : ''; ?>
                            <?php $thirdClass = in_array($permission->name,["checker","Checker"])? 'checker-permission' : ''; ?>
                            <div class="col-sm-6">
                                <?= Html::checkbox('child_permissions[]', in_array ($permission->name,$currentPermissions) , [
                                    'label' => $permission->description,
                                    'value'=> $permission->name,
                                    'class' => "custom-class  {$class} {$secondClass} {$thirdClass}",
                                    'id' => $permission->name,
                                    'labelOptions' => [
                                        'for' => $permission->name,
                                    ],
                                ]) ?>
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
$this->registerJs(<<<JS

    $('.role-help-btn').off('mouseover mouseleave')
	.on('mouseover', function(){
		var _t = $(this);
		_t.popover('show');
	}).on('mouseleave', function(){
		var _t = $(this);
		_t.popover('hide');
	});

    function onChangeDisableAnoherElemnt(sourceElement, targetElement)
    {
        $(document).on("change",sourceElement,function(){
            if ($(this).is(':checked')) 
            {
                $(targetElement).attr("disabled",true);
            }
            else
            {
                $(targetElement).attr("disabled",false);
            }
        });

        if($(sourceElement).is(":checked"))
        {
            $(targetElement).attr("disabled",true);
        }
    }

    onChangeDisableAnoherElemnt(".new-permission", ".maker-permission");
    onChangeDisableAnoherElemnt(".maker-permission", ".new-permission");
    onChangeDisableAnoherElemnt(".maker-permission", ".checker-permission");
    onChangeDisableAnoherElemnt(".checker-permission", ".maker-permission");


JS
);
?>