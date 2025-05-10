<?php

namespace yeesoft\seo\components;

use Yii;
use yii\base\Behavior;
use yii\helpers\ArrayHelper;
use yii\web\View;
use yii\helpers\Html;

/**
 * Seo View Behavior
 *
 * @package yeesoft\seo\components
 */
class SeoViewBehavior extends Behavior
{
    public $preferUrlWithParams = true;

    /**
     * You can use {seo_title}, {view_title}, {site_title}
     * @var type
     */
    public $titleCallback;

    public function init()
    {
        parent::init();

        if (is_null($this->titleCallback)) {
            $this->titleCallback = function($siteName, $viewTitle, $seoTitle) {
                $title = ($seoTitle && !empty($seoTitle)) ? $seoTitle : $viewTitle;
                return implode(' - ', [$title, $siteName]);
            };
        }
    }

    public function renderMetaTags()
    {
        /* @var $view View */
        $view = $this->owner;

        Yii::$app->seo->loadMetaTags($this->preferUrlWithParams);

        $request = Yii::$app->getRequest();
        $path    = $request->getPathInfo();
        $url     = $request->getUrl();

        $titleCallback = $this->titleCallback;
        $siteTitle     = Yii::$app->settings->get('general.title', 'Yee Site', Yii::$app->language);
        
        if (is_callable($titleCallback)) {
            $title = $titleCallback($siteTitle, $view->title, Yii::$app->seo->title);
        } else {
            $title = $siteTitle;
        }

        echo "<title>{$title}</title>".PHP_EOL;

        $index  = (Yii::$app->seo->index) ? 'index' : 'noindex';
        $follow = (Yii::$app->seo->follow) ? 'follow' : 'nofollow';
        $view->registerMetaTag(['name' => 'robots', 'content' => "$index, $follow"], 'index');

        if (Yii::$app->seo->author) {
            $view->registerMetaTag(['name' => 'author', 'content' => Html::encode(Yii::$app->seo->author)], 'author');
        }

        if (Yii::$app->seo->keywords) {
            $view->registerMetaTag(['name' => 'keywords', 'content' => Html::encode(Yii::$app->seo->keywords)], 'keywords');
        }

        if (Yii::$app->seo->description) {
            $view->registerMetaTag(['name' => 'description', 'content' => Html::encode(Yii::$app->seo->description)], 'description');
        }
        else{

            $view->registerMetaTag(['name' => 'description', 'content' =>  html_entity_decode(substr(strip_tags( $view->description),0,1000)) ], 'description');

        }


        //canonical
        $currentRoute = Yii::$app->request->getUrl();
        $questionMarkExistsWithPostion = strpos($currentRoute, "?");
        if( $questionMarkExistsWithPostion)
        {
            $currentRoute = substr($currentRoute, 0, strpos($currentRoute, "?"));
        }
        $view->registerLinkTag(['rel' => 'canonical', 'href' => Yii::$app->urlManager->getHostInfo() .$currentRoute ]);

        //hreflang
        $languages = Yii::$app->yee->displayLanguages;
//        unset($languages[Yii::$app->language]);
        foreach ($languages as $key => $lang){
            list($route, $params) = Yii::$app->getUrlManager()->parseRequest(Yii::$app->getRequest());
            $params = ArrayHelper::merge(Yii::$app->getRequest()->get(), $params);
            $url = isset($params['route']) ? $params['route'] : $route;

            $link = Yii::$app->urlManager->createAbsoluteUrl(ArrayHelper::merge($params, [$url, 'language' => $key]));
            $view->registerLinkTag(['rel' => 'alternate', 'href' => $link, 'hreflang' => $key ]);

        }


    }
}