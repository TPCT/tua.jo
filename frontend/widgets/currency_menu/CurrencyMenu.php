<?php

namespace frontend\widgets\currency_menu;

use common\helpers\Utility;
use Yii;
use backend\modules\currency\models\Currency;
class CurrencyMenu extends \yii\base\Widget
{


    public function run()
    {
        $data['selected_currency'] = Currency::find()->active()->where(['slug' => Yii::$app->request->cookies->getValue('currency')])->one();
        $data['selected_currency'] ??= Currency::find()->active()->where(['is_default' => 1])->one();
        $data['selected_currency'] ??= Currency::find()->active()->one();
        $data['currencies'] = Currency::find()->where(['!=', 'slug', $data['selected_currency']->slug])->active()->all();
        return $this->render('view',$data);
    }
}