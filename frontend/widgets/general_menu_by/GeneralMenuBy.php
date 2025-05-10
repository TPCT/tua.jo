<?php

namespace frontend\widgets\general_menu_by;

use Yii;
use yeesoft\models\Menu;
use yeesoft\models\MenuLink;

class GeneralMenuBy extends \yii\base\Widget
{
    public $menu_id = "";
    public $view_name = "";

    

    public function run()
    {

        

        $menuLinks = Menu::getMenuItems($this->menu_id);
        return $this->render($this->view_name, ['menuLinks' => $menuLinks]);


    }
}