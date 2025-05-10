<?php

use yeesoft\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \yeesoft\post\models\Post */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('yee/post', 'Posts'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-view">

    <h3 class="lte-hide-title"><?= Html::encode($this->title) ?></h3>

    <div class="panel panel-default">
        <div class="panel-body">

            <?= Html::a(Yii::t('yee', 'Edit'), ['update', 'id' => $model->id], ['class' => 'btn btn-sm btn-primary']) ?>

            <?= Html::a(Yii::t('yee', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-sm btn-default',
                'data' => [
                    'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]) ?>

            <?= Html::a(Yii::t('yee', 'Add New'), ['create'], ['class' => 'btn btn-sm btn-primary float-end']) ?>

        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-body">
            <h2><?= $model->title ?></h2>
            <?= $model->getThumbnail(['class' => 'thumbnail float-start', 'style' => 'width: 240px; margin:0 7px 7px 0;']) ?>
            <?= $model->content ?>
            <table role="presentation" class="table table-striped">
                <tbody class="files">
                <?php
                foreach ($model->images as $img):
                    /* @var $img \yeesoft\post\models\PostImages */
                    $imgRefObj = \yeesoft\media\models\Media::findOne(['url' => $img->path]);
                    if(!$imgRefObj) continue;
                    ?>

                    <tr class="template-download fade in">
                        <td>
                            <span class="preview">

                                    <a href="<?= $img->path ?>"
                                       data-gallery=""><img src="<?= $img->imageRef->getDefaultThumbUrl() ?>" draggable="true"
                                                            data-bukket-ext-bukket-draggable="true"></a>

                            </span>
                        </td>
                        <td>

                            <?php echo Html::a('Delete', \yii\helpers\Url::to(["/media/manage/delete/{$imgRefObj->id}"]), ['data-method' => 'POST', 'class' => 'btn btn-danger delete']) ?>

                        </td>
                    </tr>


                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>


</div>
