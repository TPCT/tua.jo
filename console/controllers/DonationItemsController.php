<?php

namespace console\controllers;


use backend\modules\recurring_items\models\RecurringItems;
use backend\modules\transaction\models\Transaction;
use backend\modules\transaction\models\TransactionItem;
use common\components\TuaClient;
use frontend\components\HyperPay;
use Yii;
use yii\console\Controller;
use yii\db\Exception;

class DonationItemsController extends Controller
{
    public function actionInsert(){
        $items = TransactionItem::find()->where(['status' => 0])->all();
        foreach ($items as $item){
            TuaClient::Donate($item);
        }
    }
}
