<?php

namespace frontend\widgets;

use backend\modules\dropdown_list\models\DropdownList;
use backend\modules\webforms\models\RatingWebform;

class RatingWebformWidget extends \yii\base\Widget
{
    public $view= "rating_webform";

    public function run()
    {
        $model = new RatingWebform();
        $data['model'] = $model;



        return $this->render($this->view, $data);
    }
}