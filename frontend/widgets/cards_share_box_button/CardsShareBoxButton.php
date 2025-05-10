<?php

namespace frontend\widgets\cards_share_box_button;

use Yii;
use yeesoft\models\Menu;
use yeesoft\models\MenuLink;

class CardsShareBoxButton extends \yii\base\Widget
{
    public $url = '';
    public function run()
    {  
        $data['url'] = $this->url;
        return $this->render('view',$data);
          
    }
}