<?php

namespace frontend\widgets;

use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

class LanguageSelectorMobile extends \yii\base\Widget
{
    /**
     *
     * @var string  links | pills
     */
    public $view = 'language_switcher_mobile';

    /**
     *
     * @var string  code | title
     */
    public $display = 'label';

    public function run()
    {
        if (!Yii::$app->yee->isMultilingual) {
            return;
        }

        $language = Yii::$app->language;
        $languages = Yii::$app->yee->displayLanguages;

        list($route, $params) = Yii::$app->getUrlManager()->parseRequest(Yii::$app->getRequest());
        $params = ArrayHelper::merge(Yii::$app->getRequest()->get(), $params);
        $url = isset($params['route']) ? $params['route'] : $route;

        return $this->render($this->view, [
            'language' => $language,
            'languages' => $languages,
            'url' => Html::encode($url),//Cross-site Scripting
            'params' => $params,
            'display' => $this->display,
        ]);
    }
}