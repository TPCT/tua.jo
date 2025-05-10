<?php

namespace frontend\widgets\share_button;

use Yii;
use yeesoft\models\Menu;
use yeesoft\models\MenuLink;

class ShareButton extends \yii\base\Widget
{

    public function run()
    {  
        return $this->render('view');
          
    }
}