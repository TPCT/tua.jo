<?php

namespace frontend\widgets\general_menu_ha;

use Yii;
use yeesoft\models\Menu;
use yeesoft\models\MenuLink;

class GeneralMenuHA extends \yii\base\Widget
{
    public $menu_id = "";
    public $view_name = "";
    public $active_header_url = null;
    public $title = "";
    public $break_point= 1199;
    public $type="";

    

    public function run()
    {
        $menuLinks = Menu::getMenuItems($this->menu_id);
        $this->active_header_url = Menu::find()->active()->andWhere(["id"=>$this->menu_id])->one()?->active_header_url;
        return $this->render($this->view_name, ['menuLinks' => $menuLinks, 'active_header_url'=>$this->active_header_url, "title"=>$this->title, "break_point"=>$this->break_point, "type"=> $this->type ]);
    }
}