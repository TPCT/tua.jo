<?php

use yeesoft\comments\assets\CommentsAsset;
use yeesoft\comments\Comments;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $modelyeesoft \comments\models\Comment */
?>

<?php
$commentsAsset = CommentsAsset::register($this);
Comments::getInstance()->commentsAssetUrl = $commentsAsset->baseUrl;

$col12 = Comments::getInstance()->gridColumns;
$col6 = (int)($col12 / 2);

$formID = 'comment-form' . (($comment->parent_id) ? '-' . $comment->parent_id : '');
$replyClass = ($comment->parent_id) ? 'comment-form-reply' : '';
?>

<div class="comment-form <?= $replyClass ?> clearfix">

    <?php
    $form = ActiveForm::begin([
        'action' => NULL,
        'validateOnBlur' => FALSE,
        'validationUrl' => Url::to(['/' . Comments::getInstance()->commentsModuleID . '/validate/index']),
        'id' => $formID,
        'class' => 'com-form'
    ]);

    if ($comment->parent_id) {
        echo $form->field($comment, 'parent_id')->hiddenInput()->label(false);
    }
    ?>
    <!--    --><?php //if (false && Comments::getInstance()->displayAvatar): ?>
    <!--        <div class="avatar">-->
    <!--            <img src="--><?php //Comments::getInstance()->renderUserAvatar(Yii::$app->user->id) ?><!--"/>-->
    <!--        </div>-->
    <!--    --><?php //endif; ?>
    <!--    <div class="comment-fields-->
    <?php // (Comments::getInstance()->displayAvatar) ? ' display-avatar' : '' ?><!--">-->

    <div class="row">
        <div class="col-lg-<?= $col12 ?>">
            <?= $form->field($comment, 'content', [
                'template' => "{error}\n{input}",

            ])->textarea([
                'class' => 'form-control input-sm',
                'placeholder' => Yii::t('site', 'Write a comment')
            ])->label(false) ?>
            <?php if(!Yii::$app->user->isGuest): ?>
                <?= Html::submitButton(($comment->parent_id) ? Yii::t('site', 'Reply') : Yii::t('site', 'Post'), ['class' => 'button form-submit btn-primary btn icon-before']) ?>
            <?php else: ?>
                <?= Html::a( Yii::t('site', 'Login to Post'), ['/auth/login'], ['class' => 'btn btn-primary']) ?>
            <?php endif; ?>
        </div>
    </div>
    <!---->
    <!--        <div class="comment-fields-more">-->
    <!--            <div class="buttons text-right">-->
    <!--                --><?php //Html::button(Comments::t('comments', 'Cancel'), ['class' => 'btn btn-default btn-sm reply-cancel']) ?>
    <!--                --><?php //Html::submitButton(($comment->parent_id) ? Comments::t('comments', 'Reply') : Comments::t('comments', 'Post'), ['class' => 'btn btn-primary btn-sm']) ?>
    <!--            </div>-->
    <!--            <div class="fields">-->
    <!--                <div class="row">-->
    <!--                    --><?php //if (Yii::$app->user->isGuest): ?>
    <!--                        <div class="col-lg---><?php //$col6 ?><!--">-->
    <!--                            --><?php // $form->field($comment, 'username', ['enableClientValidation' => false, 'enableAjaxValidation' => true])->textInput([
    //                                'maxlength' => true,
    //                                'class' => 'form-control input-sm',
    //                                'placeholder' => Comments::t('comments', 'Your name')
    //                            ])->label(false) ?>
    <!--                        </div>-->
    <!--                        <div class="col-lg---><? //= $col6 ?><!--">-->
    <!--                            --><?php //$form->field($comment, 'email')->textInput([
    //                                'maxlength' => true,
    //                                'email' => true,
    //                                'class' => 'form-control input-sm',
    //                                'placeholder' => Comments::t('comments', 'Your email')
    //                            ])->label(false) ?>
    <!--                        </div>-->
    <!--                    --><?php //else: ?>
    <!--                        <div class="col-lg---><? //= $col6 ?><!--">-->
    <!--                            --><?php //(($comment->parent_id) ? Comments::t('comments', 'Reply as') : Comments::t('comments', 'Post as')) . ' <b>' . Yii::$app->user->identity->username . '</b>'; ?>
    <!--                        </div>-->
    <!--                    --><?php //endif; ?>
    <!--                </div>-->
    <!--            </div>-->
    <!--        </div>-->

</div>

<?php ActiveForm::end(); ?>

<!--</div>-->


<?php
//if (Yii::$app->getRequest()->post()) {
//$options    = Json::htmlEncode($form->getClientOptions());
//$attributes = Json::htmlEncode($form->attributes);
//\yii\widgets\ActiveFormAsset::register($this);
//$this->registerJs("jQuery('#$formID').yiiActiveForm($attributes, $options);");
//}
?>


