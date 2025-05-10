<?php

use yeesoft\comments\Comments as CommentsModule;
use yeesoft\comments\Comments;
use yeesoft\comments\components\CommentsHelper;
use yeesoft\comments\models\Comment;
use yii\timeago\TimeAgo;
use \frontend\widgets\CommentsForm;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model yeesoft\comments\models\Comment */
$commentsPage = Yii::$app->getRequest()->get("comment-page", 1);
$cacheKey = 'comment' . $model . $model_id . $commentsPage;
$cacheProperties = CommentsHelper::getCacheProperties($model, $model_id);
?>

<div class="comment">
    <h2>Comments</h2>

    <?= CommentsForm::widget(); ?>


    <?php

    Pjax::begin();

    echo ListView::widget([
        'dataProvider' => $dataProvider,
        'emptyText' => '',//Yii::t('site', 'No Comments'),
        'itemView' => function ($model, $key, $index, $widget) {
            $nested_level = 1;
            return $this->render('comment', compact('model', 'widget', 'nested_level', 'index'));
        },
        'options' => ['class' => 'comments-list'],
//        'itemOptions' => ['class' => 'comment'],
        'layout' => '{items}<div class="text-center">{pager}</div>',
        'pager' => [
            'class' => yii\widgets\LinkPager::className(),
            'options' => ['class' => 'pagination pagination-sm'],
        ],
    ]);

    Pjax::end();

    ?>

</div>
