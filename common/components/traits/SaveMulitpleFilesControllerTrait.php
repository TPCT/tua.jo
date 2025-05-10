<?php
namespace common\components\traits;

use yeesoft\media\models\MediaUpload;
use Yii;
use yii\helpers\ArrayHelper;



trait SaveMulitpleFilesControllerTrait
{
  
    private function saveFiles($model,$column_multiple,$is_MultiLanguage)
    {
        
        $language = Yii::$app->language;
        $this->saveAtMediaUpload($model,$column_multiple,$language);

        if($is_MultiLanguage)
        {
            $allLanguages = array_keys(Yii::$app->yee->displayLanguages);
            $otherLanguages = array_diff($allLanguages,[$language]);
            foreach($otherLanguages as $lang)
            {
                
                $column_multiple_lang = $column_multiple."_".$lang;
                $this->saveAtMediaUpload($model,$column_multiple_lang,$lang);
            }
        }

    }

    private function saveAtMediaUpload($model,$column_multiple,$lng)
    {
        $files = explode("###",$model->$column_multiple) ;
        array_pop($files); //last item empty

        if (is_array($files)) 
        {
        
            $existedFiles =  MediaUpload::find()
                             ->select(["media_id"])
                             ->andWhere(['media_id'=>$files,'owner_id'=>$model->id,'owner_class'=>$model::className(),'language'=>$lng])
                             ->asArray()
                             ->all();
        
            $existedFiles = ArrayHelper::getColumn($existedFiles,'media_id'); 
            $newFiles =  array_diff($files, $existedFiles);
            
            $MediaUploadColumns = ['owner_class','owner_id','media_id','language'];
            $elementsToCreate =[];
            foreach ($newFiles as $key => $file) 
            {
                $elementsToCreate[$key]['owner_class'] = $model::className();
                $elementsToCreate[$key]['owner_id'] = $model->id;
                $elementsToCreate[$key]['media_id'] = intval($file);
                $elementsToCreate[$key]['language'] = $lng;

            }

            Yii::$app->db->createCommand()
            ->batchInsert(MediaUpload::tableName(), $MediaUploadColumns, $elementsToCreate)
            ->execute();
        }
        $model->updateAttributes([$column_multiple => ""]); 


    }


}