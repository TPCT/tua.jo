<?php

namespace frontend\actions;

use common\helpers\Utility;
use Yii;

/**
 * Description of PageAction
 */
class CareerAction extends \yii\web\ViewAction
{
    public $slug;
    public $page;
    public $footerBms;
    public $view = 'page';
    public $layout = 'main';

    public function run()
    {
        $this->controller->action = $this;
        $this->controller->layout = "//{$this->layout}";

        $headerImage = Utility::getHeaderImage($this->page, Yii::$app->request->url);

        return $this->controller->render($this->view, ['page' => $this->page, 'headerImage' => $headerImage, 'footerBms' => $this->footerBms]);
    }
}