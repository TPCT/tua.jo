<?php

namespace frontend\widgets;

use backend\modules\header_image\models\HeaderImage as ModelsHeaderImage;
use common\helpers\Utility;
use Yii;

class HeaderImage extends \yii\base\Widget
{

    public $model = false;
    public $path;
    public $is_inner;
    public $selected_image = "header_image";
    public $selected_mobile_image = "header_mobile_image";
    public $view= "header_image";
    public $innerUrl = null;
    public $innerTitle = null;

    public $bread_crumb_title;
    public $is_clickable;
    public $bread_crumb_slug;

    public $currentBreadCrump;

    public function run()
    {

        $data = null;
        if($this->model)
        {
            $headerImageAttribute = $this->selected_image;
            $mobileHeaderImageAttribute = $this->selected_mobile_image;


            $data['title'] = (isset($this->model->header_image_title) && $this->model->header_image_title ) ?  $this->model->header_image_title : $this->model->title ;
            $data['brief'] = (isset($this->model->header_image_brief) && $this->model->header_image_brief ) ? $this->model->header_image_brief : '';
            $headerImage = ModelsHeaderImage::findOne(['path' => $this->path]);


            if( $this->model->header_image || $this->model->$headerImageAttribute)
            {
                if($this->model->header_image)
                {
                    $data['webp_iamge'] =  \frontend\widgets\WebpImage::widget(["src" => $this->model->header_image , "alt" =>'' ,"loading" => "lazy",'css'=>"","just_image"=>true]) ;
                }
                else
                {
                    $data['webp_iamge'] =  \frontend\widgets\WebpImage::widget(["src" => $this->model->$headerImageAttribute , "alt" =>'' ,"loading" => "lazy",'css'=>"","just_image"=>true]) ;
                }

            }
            else
            {
                $main_header_image = Yii::$app->settings->get('site.main_header_image', null, Yii::$app->language);
                $data['webp_iamge'] =  $headerImage? $headerImage->image : $main_header_image;
            }

            if( $this->model->header_mobile_image || $this->model->$mobileHeaderImageAttribute)
            {
                if($this->model->header_mobile_image)
                {
                    $data['webp_mobile_image'] =  \frontend\widgets\WebpImage::widget(["src" => $this->model->header_mobile_image , "alt" =>'' ,"loading" => "lazy",'css'=>"","just_image"=>true]) ;
                }
                else
                {
                    $data['webp_mobile_image'] = \frontend\widgets\WebpImage::widget(["src" => $this->model->$mobileHeaderImageAttribute , "alt" =>'' ,"loading" => "lazy",'css'=>"","just_image"=>true])  ;
                }
            }
            else
            {
                $mobile_header_image = Yii::$app->settings->get('site.header_image_mobile', null, Yii::$app->language);
                $data['webp_mobile_image'] =  $headerImage? $headerImage->mobile_image : $mobile_header_image ;
            }

        }
        else
        {
            $this->path = $this->path?? strstr(Yii::$app->request->pathInfo, "/");

            $headerImage = ModelsHeaderImage::findOne(['path' => $this->path]);


          
            if ($headerImage)
            {
                $data['webp_iamge'] = \frontend\widgets\WebpImage::widget(["src" => $headerImage->image , "alt" =>'' ,"loading" => "lazy",'css'=>"","just_image"=>true]) ;
                $data['webp_mobile_image'] = \frontend\widgets\WebpImage::widget(["src" => $headerImage->mobile_image , "alt" =>'' ,"loading" => "lazy",'css'=>"","just_image"=>true]);
                $data['title'] = $headerImage->title;
                $data['brief'] = $headerImage->brief;

            }
            else{
                $main_header_image = Yii::$app->settings->get('site.main_header_image', null, Yii::$app->language);
                $mobile_header_image = Yii::$app->settings->get('site.header_image_mobile', null, Yii::$app->language);
                $data['webp_iamge'] = \frontend\widgets\WebpImage::widget(["src" => $main_header_image , "alt" =>'' ,"loading" => "lazy",'css'=>"","just_image"=>true]) ;
                $data['webp_mobile_image'] = \frontend\widgets\WebpImage::widget(["src" => $mobile_header_image , "alt" =>'' ,"loading" => "lazy",'css'=>"","just_image"=>true]);
                $data['title'] =  Yii::$app->settings->get('site.header_image_title', null, Yii::$app->language) ;
                $data['brief'] =  Yii::$app->settings->get('site.header_image_brief', null, Yii::$app->language) ;
            }
        }
    
        if($data)
        {
            $data['headerImage'] = $headerImage;
            if($headerImage && $headerImage->view)
            {
                $this->view = $headerImage->view;
            }
            $data['currentBreadCrump'] = $this->currentBreadCrump;
            $data['innerUrl'] = $this->innerUrl;
            $data['innerTitle'] = $this->innerTitle;
            $data['is_inner']= $this->is_inner;
            $data['bread_crumb_title']= $this->bread_crumb_title;
            $data['bread_crumb_slug']= $this->bread_crumb_slug;
            $data['is_clickable']= $this->is_clickable;
            return $this->render($this->view, $data);
        }


        
    }
}