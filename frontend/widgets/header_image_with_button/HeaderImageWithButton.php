<?php

namespace frontend\widgets\header_image_with_button;

use backend\modules\header_image\models\HeaderImage;
use Yii;

class HeaderImageWithButton extends \yii\base\Widget
{

    public $model = false;

    public function run()
    {

        $data = null;
        if($this->model)
        {
            $data['webp_iamge'] = \frontend\widgets\WebpImage::widget(["src" => $this->model->header_image , "alt" =>'' ,"loading" => "lazy",'css'=>"","just_image"=>true]) ;
            $data['title'] = $this->model->header_image_title;
            $data['brief'] = $this->model->header_image_brief;
            $data['buttonText'] = $this->model->header_image_button_text;
            $data['url'] = $this->model->header_image_url;
        }
        else
        {
            $path = strstr(Yii::$app->request->pathInfo, "/");

            $headerImage = HeaderImage::findOne(['path' => $path]);

            if ($headerImage)
            {
                $data['webp_iamge'] = \frontend\widgets\WebpImage::widget(["src" => $headerImage->image , "alt" =>'' ,"loading" => "lazy",'css'=>"","just_image"=>true]) ;
                $data['title'] = $headerImage->title;
                $data['brief'] = $headerImage->brief;

            }
        }
    
        if($data)
        {
            return $this->render('view', $data);
        }


        
    }
}