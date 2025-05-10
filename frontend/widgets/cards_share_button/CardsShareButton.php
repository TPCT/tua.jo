<?php

namespace frontend\widgets\cards_share_button;

use Yii;
use yeesoft\models\Menu;
use yeesoft\models\MenuLink;

class CardsShareButton extends \yii\base\Widget
{

    public function run()
    {  
        return $this->render('view');
          
    }
}