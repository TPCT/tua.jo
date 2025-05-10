<?php

namespace frontend\widgets\breadcrumbs;
use common\components\traits\BreadCrumbSchemaTrait;

use frontend\modules\account\models\client\Client;
use Yii;


class BreadCrumbs extends \yii\base\Widget
{
    use BreadCrumbSchemaTrait;

    public $is_inner= '';
    public $bread_crumb_title= '';
    public $bread_crumb_slug= '';
    public $is_clickable= '';

    public function run()
    {
        $data['crumbs'] = [];
    
       
        $urlPath = parse_url(Yii::$app->request->url, PHP_URL_PATH);

        $parts = explode('/', trim($urlPath, '/'));

        foreach ($parts as $index => $part) {
            if (in_array($part, ['', 'profile',$this->bread_crumb_slug]))
                unset($parts[$index]);
        }

        foreach ($parts as $index => $key) {
      
            if (in_array($key, ['en', 'ar'])){
                $data['crumbs'][Yii::t('site', 'Home')] = "/" . $key;
                continue;
            }
            if ($key === 'search') {
                break;
            }


            $data['crumbs'][ucwords(str_replace('-', ' ', $key))] = end($data['crumbs']) . "/" . $key;
    
        }

        

        $data['bread_crumb_title'] = $this->bread_crumb_title;
        $data['is_clickable'] = $this->is_clickable;
        if($this->is_inner === true)
        {
            $this->generateBreadSchema($data);

            return $this->render('inner', $data);
        }
        else
        {
            $this->generateBreadSchema($data);

            return $this->render('view', $data);

        }
    
    }
}