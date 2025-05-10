<?php

namespace frontend\modules\account\controllers;

use backend\modules\currency\models\Currency;
use backend\modules\discussion_papers\models\DiscussionPapers;
use backend\modules\discussion_papers\models\DiscussionPapersLang;
use backend\modules\op_eds\models\Opeds;
use backend\modules\speeches\models\Speeches;
use frontend\components\classes\CustomErrorAction;
use Yii;

;

/**
 * Site controller
 */
class SettingsController extends \yeesoft\controllers\BaseController
{
    public $freeAccess = true;


    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => CustomErrorAction::class,
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'sitemap' => [
                'class' => 'yeesoft\seo\actions\SitemapAction',
            ],
        ];
    }

    public function actionCurrencySwitch($slug){
        $currency = Currency::find()->active()->where(['slug' => $slug])->one();
        $currency ??= Currency::find()->active()->where(['is_default' => 1])->one();
        $currency ??= Currency::find()->active()->one();
        Yii::$app->response->cookies->add(new \yii\web\Cookie([
            'name' => 'currency',
            'value' => $currency->slug,
            'expire' => 'session',
            'httpOnly' => true,
            'secure' => YII_ENV_PROD ? true : false,
            'sameSite' => 'Lax',
        ]));
        Yii::$app->session->set('e_card_step_one_data', []);

        return $this->goBack(Yii::$app->request->referrer);
    }
}