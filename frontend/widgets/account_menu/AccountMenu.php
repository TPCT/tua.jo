<?php

namespace frontend\widgets\account_menu;

use frontend\modules\account\models\client\Client;
use Yii;
use backend\modules\currency\models\Currency;
class AccountMenu extends \yii\base\Widget
{


    public function run()
    {
        $data['is_guest'] = Yii::$app->user->isGuest;
        $data['user'] = Client::findOne(Yii::$app->user->id);
        return $this->render('view',$data);
    }
}