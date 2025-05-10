<?php

namespace frontend\widgets\header_image_2;

use backend\modules\header_image\models\HeaderImage;
use Yii;

class HeaderImage2 extends \yii\base\Widget
{    
    public $model = false;
    public $path;
    public $defaulImage = "/images/Headers/Mask group-3.png";
    public $defaulMobileImage = "/uploads/2024/10/header-6.jpg"; 

    public function run()
    {

        $data['webp_image'] = \frontend\widgets\WebpImage::widget(["src" => $this->defaulImage , "alt" =>'' ,"loading" => "lazy",'css'=>"","just_image"=>true]) ;
        $data['webp_mobile_image'] = \frontend\widgets\WebpImage::widget(["src" => $this->defaulMobileImage , "alt" =>'' ,"loading" => "lazy",'css'=>"","just_image"=>true]);

        if($this->model)
        {
            if( isset($this->model->header_image) && $this->model->header_image)
            {
                $data['webp_image'] = \frontend\widgets\WebpImage::widget(["src" => $this->model->header_image , "alt" =>'' ,"loading" => "lazy",'css'=>"","just_image"=>true]);
            }
            if( isset($this->model->mobile_image) && $this->model->mobile_image)
            {
                $data['webp_mobile_image'] = \frontend\widgets\WebpImage::widget(["src" => $this->model->mobile_image , "alt" =>'' ,"loading" => "lazy",'css'=>"","just_image"=>true]);
            }
            $data['title'] = $this->model->header_image_title;
            $data['brief'] = $this->model->header_image_brief;
        }
        else
        {
            $this->path = $this->path?? strstr(Yii::$app->request->pathInfo, "/");

            $headerImage = HeaderImage::findOne(['path' => $this->path]);

            if ($headerImage)
            {
                $data['webp_image'] = \frontend\widgets\WebpImage::widget(["src" => $headerImage->image , "alt" =>'' ,"loading" => "lazy",'css'=>"","just_image"=>true]) ;
                $data['webp_mobile_image'] = \frontend\widgets\WebpImage::widget(["src" => $headerImage->mobile_image , "alt" =>'' ,"loading" => "lazy",'css'=>"","just_image"=>true]);  
            }
        }
    
        if($data)
        {
            return $this->render('view', $data);
        }

    }
}