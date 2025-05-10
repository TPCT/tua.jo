<?php

namespace frontend\widgets\footer_menu;

use Yii;
use yeesoft\models\Menu;
use yeesoft\models\MenuLink;

class FooterMenu extends \yii\base\Widget
{

    public function run()
    {

        $data['mainMenu'] = Menu::find()->activeWithCategory("footer-menu")->one();

        if($data['mainMenu'])
        {
            $data['footerParents'] = MenuLink::find()->where(["menu_id"=>$data['mainMenu']->id,"parent_id"=>"","alwaysVisible"=>0])
                                        ->orderBy(['order' => 'ASC'])
                                        ->all();
        }
                                    
        return $this->render('view', $data);
        
        
    }
}