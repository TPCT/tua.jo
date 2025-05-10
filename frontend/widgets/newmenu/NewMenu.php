<?php

namespace frontend\widgets\newmenu;

use Yii;
use yeesoft\models\Menu;
use yeesoft\models\MenuLink;

class NewMenu extends \yii\base\Widget
{
    public $menu_id = "main-menu";

    public function run()
    {

        $data['headerMenu'] = Menu::getDb()->cache(function ($db) {
                                return Menu::find()->andWhere([Menu::tableName().".id" => $this->menu_id])
                                                    ->joinWith("translations")
                                                    ->one();
                            }, 3600);


        if($data['headerMenu'])
        {
            $data['headerMenuParents'] = MenuLink::getDb()->cache(function ($db) use($data) {
                                    return MenuLink::find()->where(["menu_id"=>$data['headerMenu']->id,"parent_id"=>"","alwaysVisible"=>0])
                                                            ->joinWith("translations")
                                                            ->with("childs")
                                                            ->orderBy(['order' => 'ASC'])
                                                            ->all();
                                }, 3600);

        }

        $data['links'] = [];

        foreach ($data['headerMenuParents'] as $parent){
            $link = [
                'label' => $parent->label,
                'url' => $parent->link,
                'has_children' => !empty($parent->childs),
                'has_grandsons' => false,
                'children' => $parent->childs
            ];

            foreach ($parent->childs as $child){
                if (!empty($child->childs)){
                    $link['has_grandsons'] = true;
                    break;
                }
            }

            $data['links'][] = $link;
        }

        return $this->render('view', $data);
    }
}