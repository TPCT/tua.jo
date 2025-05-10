<?php

namespace frontend\actions;

use common\helpers\Utility;
use Yii;

/**
 * Description of PageAction
 */
class PageAction extends \yii\web\ViewAction
{
    public $slug;
    public $page;
    public $view = 'page';
    public $layout = 'main';

    public function run()
    {
        $this->controller->action = $this;
        $this->controller->layout = "//{$this->layout}";

        $headerImage = Utility::getHeaderImage($this->page, Yii::$app->request->url);
        // \Yii::$app->view->registerMetaTag(['name' => 'og:url', 'content' => Yii::$app->urlManager->createAbsoluteUrl([Yii::$app->request->url])]);
        // \Yii::$app->view->registerMetaTag(['name' => 'og:title', 'content' => $this->page->title]);
        // \Yii::$app->view->registerMetaTag(['name' => 'og:updated_time', 'content' => (time())]);
        // \Yii::$app->view->registerMetaTag(['name' => 'og:type', 'content' => ('article')]);
        // \Yii::$app->view->registerMetaTag(['name' => 'og:image', 'content' => Yii::$app->urlManager->createAbsoluteUrl([$this->page->image])]);
        // \Yii::$app->view->registerMetaTag(['name' => 'og:description', 'content' => $this->page->brief]);

        return $this->controller->render($this->view, ['page' => $this->page, 'headerImage' => $headerImage]);
    }
}