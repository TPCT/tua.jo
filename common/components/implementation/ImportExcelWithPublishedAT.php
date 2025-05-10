<?php
namespace common\components\implementation;

use common\components\interfaces\ImportExcel;
use Yii;
use yii\web\UploadedFile;
use yeesoft\media\models\Media;
use common\helpers\Utility;



class ImportExcelWithPublishedAT implements ImportExcel
{

    public function importExcel($modelClass)
    {

        $model = new \yii\base\DynamicModel([
            'file','published_at'
        ]);
        $model->addRule(['file'],'file', ['skipOnEmpty' => false,'extensions' => 'xls,xlsx']);
        $model->addRule(['published_at'], 'required');
        $model->addRule(['published_at'], 'date', ['format' => 'yyyy-MM-dd']);

        if ($model->load(Yii::$app->request->post()))
        {
            $model->file = UploadedFile::getInstance(new \yii\base\DynamicModel(), "file");
            $errors = null;
            if($model->validate())
            {
                $routes = [
                    'baseUrl' => '', // Base absolute path to web directory
                    'basePath' => '@frontend/web', // Base web directory url
                    'uploadPath' => 'uploads/temperory', // Path for uploaded files in web directory
                ];
                try 
                {
                    if ($model->file) 
                    {
                        $media1 = Utility::saveUploadedFile($model->file, $routes);
                        $model->file = $media1->url;
                        
                    }
                } 
                catch (\Exception $e) 
                {
                    //var_dump($file1);
                    //var_dump($e->getMessage());die();
                    return false;
                }

                if ($model->file) 
                {
                    $basePath = Yii::getAlias('@frontend/web');
                    $filename = $basePath.$model->file;
                    
                    $fileType = \PHPExcel_IOFactory::identify($filename); // the file name automatically determines the type
                    $excelReader = \PHPExcel_IOFactory::createReader($fileType);
            
                    $phpexcel = $excelReader->Load($filename)->getsheet (0); // load the file and get the first sheet
                    $total_line = $phpexcel->gethighestrow(); // total number of rows
                    $total_column = $phpexcel->gethighestcolumn(); // total number of columns
        
                    if (1 < $total_line) 
                    {
                        //$cities =[];
                        for ($row = 2;$row <= $total_line;$row++) 
                        {
                            $data = [];
                            for ($column = 'A';$column <= $total_column;$column++) 
                            {
                                $data[] = trim($phpexcel->getCell($column.$row));
                            }

                            $itemToSave = new $modelClass;
                            $itemToSave->published_at = $model->published_at;
                            foreach($itemToSave->excelAttributes as $key => $item)
                            {
                                $itemToSave->$item = $data[$key];
                            }
                            if($itemToSave->validate())
                            {
                                $itemToSave->save();
                            }
                            else
                            {
                                $errors[] =$itemToSave->errors;
                            }
                            
                        }

                        // $info = Yii::$app->db->createCommand()
                        // ->insert('{{%shop_info}}',['shop_name' => $data[0],'shop_type' => $data[1]])
                        // ->execute();
                    }
                    $f = Media::findOne(['url' => $model->file]);
                    $f->delete();
                    unlink($filename);
                }
                if(!$errors)
                {
                    Yii::$app->session->setFlash('crudMessage', Yii::t('yee', 'Imported Successfully'));
                }
                else
                {
                    Yii::$app->session->setFlash('crudMessage', Yii::t('yee', 'Some rows not valid'));
                    $data['errors'] = $errors;
                    //var_dump($errors);exit;
                }
            }   
        }
        $data['model'] = $model;
        $data['currentModel'] = $modelClass;

        return $data;

    }

}