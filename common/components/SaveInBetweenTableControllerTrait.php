<?php
namespace common\components;

use Yii;
use yii\helpers\ArrayHelper;

trait SaveInBetweenTableControllerTrait
{

    private function SaveInBetweenTable($inBetweenModel,$arrayIdValues,$singleIdValues,$arrayColumnName,$singleColumnName,$relation,$mainModel)
    {
        $deletedIDs =[];
        if( is_string($arrayIdValues) )
        {
            $arrayIdValues = [];
        }
        $newIDs = $arrayIdValues;
    
        if(!$mainModel->isNewRecord)
        {
            $oldIDs = ArrayHelper::getColumn($mainModel->$relation,$arrayColumnName);
            
            //var_dump($oldIDs);exit;
            
            $newIDs = array_diff($arrayIdValues, array_filter($oldIDs));
            $deletedIDs = array_diff($oldIDs, array_filter($arrayIdValues));

            // var_dump($deletedIDs); echo"<br>";
            // var_dump($newIDs);  echo"<br>";
            // exit;
        }
        if (!empty($deletedIDs)) 
        {
            $inBetweenModel::deleteAll([$singleColumnName => $singleIdValues, $arrayColumnName=>$deletedIDs]);
        }

        if(!empty($newIDs))
        {
            $data=[];
            foreach($newIDs as $key => $new_id)
            {
                $data[$key] = 
                [
                    $singleColumnName => $singleIdValues,
                    $arrayColumnName => $new_id
                ];
            }
            Yii::$app->db->createCommand()
                        ->batchInsert($inBetweenModel::tableName(), [$singleColumnName,$arrayColumnName], $data)
                        ->execute();
        }
        
    }
  

}