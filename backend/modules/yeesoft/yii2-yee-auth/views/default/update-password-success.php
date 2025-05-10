<?php

/**
 * @var yii\web\View $this
 */

use yii\helpers\Url;

$this->title = Yii::t('yee/auth', 'Update Password');

$this->title = Yii::t('yee/auth', 'Password Updated Successfully');

$col12 = $this->context->module->gridColumns;
$col9 = (int) ($col12 * 3 / 4);
$col6 = (int) ($col12 / 2);
$col3 = (int) ($col12 / 4);
?>


<div id="update-wrapper">
    <div class="row">
        <div class="col-md-<?= $col6 ?> offset-md-<?= $col3 ?>">
            <div class="panel panel-default">
                <div class="change-own-password-success">
                    <div class="container-fluid my-5 py-5">
                        <div class="alert alert-success text-center">
                            <?= Yii::t('yee/auth', 'Password has been updated') ?>
                        </div>
                        <div class="text-center">
                            <a class="btn btn-success" href="<?= Url::to(['/auth/login']) ?>"> <?= Yii::t("site","Login") ?> </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$css = <<<CSS
#update-wrapper {
	position: relative;
	top: 30%;
}
.py-5{
    padding:20%;
}
.alert-success {
    margin-bottom: 55px;
}
CSS;

$this->registerCss($css);
?>