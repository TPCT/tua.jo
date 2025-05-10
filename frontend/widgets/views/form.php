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

<div class="form-group">

    <?php
    $form = ActiveForm::begin([
        'action' => NULL,
        'validateOnBlur' => FALSE,
        'validationUrl' => Url::to(['/' . Comments::getInstance()->commentsModuleID . '/validate/index']),
        'id' => $formID,
        'class' => 'com-form'
    ]);

    ?>
    <div class="row">
        <div class="col-lg-<?= $col12 ?>">
            <?= $form->field($comment, 'content', [
                'template' => "{error}\n{input}",

            ])->textarea([
                'class' => 'form-control input-sm',
                'placeholder' => Yii::t('site', 'Enter your comments...')
            ])->label(false) ?>
            <?= Html::submitButton(Yii::t('site', 'add comment') . ' ' . Html::img("/images/right-arrow-small.png"), ['class' => 'btn btn-danger small']) ?>

        </div>
    </div>

</div>

<?php ActiveForm::end(); ?>

