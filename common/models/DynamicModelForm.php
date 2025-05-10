<?php

namespace common\models;

use common\helpers\Utility;
use Yii;
use yii\base\DynamicModel;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use kartik\detail\DetailView;

class DynamicModelForm extends DynamicModel
{
    

    public function reset()
    {
        // Loop through each attribute and set it to null or a default value
        foreach ($this->attributes as $attribute => $value) {
            $this->$attribute = null;
        }
    }
    
    public function getFileInstance($fileAttibutes)
    {
        foreach($fileAttibutes as $attribute)
        {
            $this->$attribute = UploadedFile::getInstance(new self(), $attribute );
        }

    }

    public function uploadFiles($folder,$fileAttibutes)
    {
        $routes = [
            'baseUrl' => '', // Base absolute path to web directory
            'basePath' => '@frontend/web', // Base web directory url
            'uploadPath' => 'uploads/'.$folder, // Path for uploaded files in web directory
        ];
        try 
        {

            foreach($fileAttibutes as $attribute)
            {
                if($this->$attribute)
                {
                    $media1 = Utility::saveUploadedFile($this->$attribute, $routes);
                    $this->$attribute = $media1->url;
                }
            }


        } 
        catch (\Exception $e) 
        {
            return false;
        }

        return true;

    }



        /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param string $email the target email address
     * @return boolean whether the email was sent
     */
    public function sendEmail($email,$modelAttributes,$fileAttributes, $microForm)
    {
        try {
            $output = DetailView::widget([
                'model' => $this,
                'formatter' => [
                    'class' => '\yii\i18n\Formatter',
                    'dateFormat' => 'MM/dd/yyyy',
                    'datetimeFormat' => 'MM/dd/yyyy HH:mm:ss',
                ],
                'attributes' => $modelAttributes,
            ]);


            $message = Yii::$app->mailer->compose()
                ->setTo($email)
                ->setFrom([Yii::$app->params['fromEmail'] => Yii::$app->params['fromName']])
//           ->setReplyTo([$this->email => $this->name])
                ->setSubject(Yii::$app->name .' '.$microForm->title_en)
                ->setHtmlBody($output)
                ->setTextBody('--');

                foreach($fileAttributes as $attr)
                {
                    if ($this->$attr) {
                        $message->attach(Yii::getAlias('@frontend') . '/web' . $this->$attr);
                    }
                }
                
            $status = $message->send();

            return $status;
        } catch (\Exception $e) {
            var_dump($e->getMessage());exit;
            return false;
        }
    }



}
