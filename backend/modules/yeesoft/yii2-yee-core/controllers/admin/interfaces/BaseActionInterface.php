<?php

namespace yeesoft\controllers\admin\interfaces;


interface BaseActionInterface
{
    
    public function actionIndex();

    public function actionView($id);

    public function actionCreate($model);

    public function actionUpdate($model);

    public function actionMakeRevisionAction();

    public function actionRemoveRejection();

    public function actionDelete($id);

    public function actionToggleAttribute($attribute, $id);

    public function actionBulkActivate();

    public function actionBulkDeactivate();

    public function actionBulkDelete();

    public function actionHistory($id);


    // public function actionGridSort();

    // public function actionGridPageSize();
    
}