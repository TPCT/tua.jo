<?php

namespace console\controllers;

use yeesoft\media\models\Media;
use Yii;
use yii\console\Controller;

class CovertImagesToWebpController extends Controller
{

    public function actionConvert()
    {

        $mediaItems = Media::find()->all();
        foreach($mediaItems as $mediaItem)
        {
            Yii::setAlias('@webroot', Yii::getAlias('@frontend') . '/web');
            $imageWebp = \frontend\widgets\WebpImage::widget(["src" => $mediaItem->url , "alt" => '' ,"loading" => "lazy",'css' => "", "just_image" => true, "disable"=>false, 'forceCreate' => true]);
            if(substr($mediaItem->url, -4) != 'webp')
            {
                echo($imageWebp). " ";
                echo "not done:". $mediaItem->id ."\n";
            }
        }

    }

}
