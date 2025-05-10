<?php

use dosamigos\fileupload\FileUploadUI;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel yeesoft\media\models\Media */

$this->title = Yii::t('yee/media', 'Upload New File');

if ($mode !== 'modal') {
    $this->params['breadcrumbs'][] = $this->title;
}
?>

<div class="panel panel-default">
    <div class="panel-body">
        <div id="uploadmanager">
            <p>
                <?= Html::a('← ' . Yii::t('yee/media', 'Back to file manager'), ($mode == 'modal') ? ['manage/index', 'mode' => 'modal'] : ['default/index']) ?>
            </p>

            <?= \kartik\widgets\FileInput::widget([
                'model' => $model,
                'attribute' => 'file',
                'options'=>[
                    'multiple'=>true
                ],
                'pluginOptions' => [
                    'uploadUrl' => ['upload'],
//                    'maxFileCount' => 10
                ]
            ]);
            ?>

        </div>
    </div>
</div>