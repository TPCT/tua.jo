<?php
namespace common\components\implementation;

use common\components\interfaces\ImportExcel;
use Yii;
use yii\web\UploadedFile;
use yeesoft\media\models\Media;
use common\helpers\Utility;
use yii\helpers\ArrayHelper;
use yii\helpers\HtmlPurifier;
use yii\helpers\VarDumper;

class ImportExcelNoraml implements ImportExcel
{

    public function importExcel($modelClass)
    {

        $model = new \yii\base\DynamicModel([
            'file'
        ]);


        $model->addRule(['file'],'file', ['skipOnEmpty' => false]);

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
                    return false;
                }

                if ($model->file)
                {
                    $basePath = Yii::getAlias('@frontend/web');
                    $filename = $basePath.$model->file;

                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                    $spreadsheet = $reader->load($filename);
                    $sheetData = $spreadsheet->getActiveSheet()->toArray();
                    $max_column = $spreadsheet->getActiveSheet()->getHighestColumn();
                    $max_column =\PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($max_column);
                    $errors = null;

                    if (1 < $sheetData)
                    {
                        $database_column_name = $sheetData[0];
                        $database_column_name = array_filter($database_column_name);

                        $allItemsToSave = [];
                        for ($row = 1;$row < count($sheetData);$row++)
                        {
                            $data = $sheetData[$row];
                            $allItemsToSave[] = $this->prepareNewItem($modelClass,$max_column,$data,$database_column_name,$errors);
                        }
                        //Yii::$app->db->createCommand()->insert($modelClass::tableName(), $allItemsToSave)->execute();

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
                }
            }
        }
        $data['model'] = $model;
        $data['currentModel'] = $modelClass;

        return $data;

    }



    private function prepareNewItem($modelClass,$max_column,$data,$database_column_name, &$errors)
    {
        $itemToSave = new $modelClass;
        $arrayToSend=[];

        foreach($database_column_name as $index => $name){
            $value = HtmlPurifier::process(trim($data[$index]));
            $itemToSave->$name = $value;
            $arrayToSend[$name] = $value;
        }

        if($itemToSave->validate())
        {
            $itemToSave->save(false);
            //return $arrayToSend;
        }
        else
        {
            //var_dump($itemToSave->errors);exit;
            $errors[] =$itemToSave->errors;
        }
        
    }


}