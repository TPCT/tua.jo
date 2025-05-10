<?php

namespace frontend\widgets\siteMapMenu;

use Yii;
use yeesoft\models\Menu;
use yeesoft\models\MenuLink;

class SiteMapMenu extends \yii\base\Widget
{
    public $menu_id = "";
    public function run()
    {

        $data['siteMapMenu'] = Menu::getDb()->cache(function ($db) {
                                return Menu::find()->andWhere([Menu::tableName().".id" => $this->menu_id])
                                                    ->joinWith("translations")
                                                    ->one();
                            }, 3600);


        if($data['siteMapMenu'])
        {
            $data['siteMapMenuParents'] = MenuLink::getDb()->cache(function ($db) use($data) {
                                    return MenuLink::find()->where(["menu_id"=>$data['siteMapMenu']->id,"parent_id"=>"","alwaysVisible"=>0])
                                                            ->joinWith("translations")
                                                            ->with("childs")
                                                            ->orderBy(['order' => 'ASC'])
                                                            ->all();
                                }, 3600);

        }
                           
        return $this->render('view', $data);
        
        
    }
}