

    <div class="panel panel-default">
        <div class="panel-body">
            <h5>SEO</h5>
            <div class="row">
                <div class="col-md-12">
                    <?= $form->field($seoModel, 'title')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($seoModel, 'author')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($seoModel, 'keywords')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($seoModel, 'description')->textInput(['maxlength' => true]) ?>

                </div>
            </div>
        </div>
    </div>