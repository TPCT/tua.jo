<?php

namespace frontend\widgets\social_links;

use yeesoft\models\MenuLink;

class SocialLinks extends \yii\base\Widget
{

    public function run()
    {
        return $this->render('social-links');        
        
    }
}