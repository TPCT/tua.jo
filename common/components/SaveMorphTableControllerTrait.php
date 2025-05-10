<?php
namespace common\components;

use Yii;
use yii\helpers\ArrayHelper;

trait SaveMorphTableControllerTrait
{

    private function SaveMorphTable($inBetweenModel, $singleIdValue,$singleColumnName, $arrayIdValues, $itemIdColumnName, $itemModelColumnName, $relation, $mainModel)
    {
        $deletedIDs =[];
        
        if(!$arrayIdValues)
        {
            $arrayIdValues = [];
        }
        $newIDs = $arrayIdValues;
    
        //converr values of singleIdValue to string because of error of database at production to be exactly like database type
        $singleIdValue = strval($singleIdValue);

        if(!$mainModel->isNewRecord)
        {
            $oldIDs = ArrayHelper::getColumn($mainModel->$relation,"id");
            
            //var_dump($arrayIdValues,$oldIDs);exit;
            
            $newIDs = array_diff($arrayIdValues, array_filter($oldIDs));
            $deletedIDs = array_diff($oldIDs, array_filter($arrayIdValues));


            // var_dump($deletedIDs); echo"<br>";
            // var_dump($newIDs);  echo"<br>";
            // exit;
        }
        if (!empty($deletedIDs)) 
        {
            $inBetweenModel::deleteAll([$singleColumnName => $singleIdValue, $itemIdColumnName=>$deletedIDs, $itemModelColumnName=>$mainModel->className()]);
        }

        if(!empty($newIDs))
        {
            $data=[];
            foreach($newIDs as $key => $new_id)
            {
                $data[$key] = 
                [
                    $singleColumnName => $singleIdValue,
                    $itemIdColumnName => $new_id,
                    $itemModelColumnName => $mainModel->className()
                ];
            }
            Yii::$app->db->createCommand()
                        ->batchInsert($inBetweenModel::tableName(), [$singleColumnName,$itemIdColumnName,$itemModelColumnName], $data)
                        ->execute();
        }
        
    }
  

}