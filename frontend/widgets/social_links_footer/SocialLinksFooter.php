<?php

namespace frontend\widgets\social_links_footer;

use yeesoft\models\MenuLink;

class SocialLinksFooter extends \yii\base\Widget
{

    public function run()
    {
        return $this->render('social-links');        
        
    }
}