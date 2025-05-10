<?php

use yeesoft\helpers\Html;
use yii\helpers\Url;

?>


<div class="panel panel-default">
        <div class="panel-body">
        <?php $moduleName = $this->context->module->id; ?>
            <?php // if (!Yii::$app->getRequest()->getQueryParam('parent_id')): ?>
                <?= Html::a(Yii::t('yee', 'Edit'), ['/'. $this->context->module->id.'/default/update', 'id' => $model->id], ['class' => 'btn btn-sm btn-primary']) ?>
                <?= Html::a(Yii::t('yee', 'Delete'), ['/'. $this->context->module->id.'/default/delete', 'id' => $model->id], [
                    'class' => 'btn btn-sm btn-danger',
                    'data' => [
                        'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                        'method' => 'post',
                    ],
                ]) ?>
            <?php // endif?>

            <div class="float-end"> 
                
                <?php if (!Yii::$app->getRequest()->getQueryParam('parent_id')): ?>
                    
                    <?= Html::a(Yii::t('yee', 'Add New'), ['/'. $this->context->module->id.'/default/create'], ['class' => 'btn btn-sm btn-primary']) ?>
                    
                    <?=
                        $this->render('//common/_preview-button', ["model"=>$model,"with_preview"=>$with_preview,"front_url"=>$front_url]);
                    ?>
                    
                    

                <?php endif?>
                
                <?php $user = Yii::$app->user->identity; ?>
                <?php if ($model->revision && ( \yeesoft\models\User::hasPermission('checker', false) || $user->superadmin  )): ?>
                    <?php if(!$model->reject_note): ?>
                        <div class="dropdown" style="padding:0 5px; float: left;">
                            <button class="btn btn-sm btn-danger dropdown-toggle" type="button" id="dropdownMenu2" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Reject
                            </button>
                            <div class="dropdown-menu form-group" aria-labelledby="dropdownMenu2" style="padding: 10px;">
                                <form action="<?= Url::to(['/'.$this->context->module->id."/default/make-revision-action"]) ?>">
                                    <?= Html::csrfMetaTags() ?>
                                    <div class="form-group">
                                        <input type="hidden" value="<?= $model->id ?>" name="id">
                                        <textarea class="form-control" rows="2" name="reject_note"></textarea>
                                    </div>
                                    <input type="submit" class="btn btn-default">
                                </form>
                            </div>
                        </div>
                    <?php endif; ?>
                    
                    <?= Html::a(Yii::t('yee', 'Make published'), ['/'. $this->context->module->id.'/default/make-revision-action', 'id' => $model->id, 'revision_id' => $model->revision], ['class' => 'btn btn-sm btn-info']) ?>
                <?php elseif( $model->reject_note &&  \yeesoft\models\User::hasPermission('maker', false) ): ?>
                    <?= Html::a(Yii::t('yee', 'Remove Rejection'), Url::to(['/'. $this->context->module->id.'/default/remove-rejection/', 'id' => $model->id ]) , ['class' => 'btn btn-sm btn-danger']) ?>
                <?php endif ?>

            </div>

        </div>
    </div>
