<?php

use common\helpers\Utility;

?>


    <div class="row">
        <div class="col-md-6">
            <?= $form->field($model, 'object_fit')->dropDownList(Utility::$objectFitArray,["prompt"=>"Select Object Fit"]) ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'object_position')->textInput(['maxlength' => true]) ?>
        </div>
    </div>