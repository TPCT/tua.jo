<?php
namespace common\components;

use Yii;
use yii\helpers\ArrayHelper;



trait SaveDynamicFormControllerTrait
{
  
    private function DynamicFormCreateUpdate($items,$modelToCreateOrUpdate,$model,$foreign_column)
    {
        if(!$items) //null
        {
            return;
        }
                
        $repeatChapterIDs=[];
        $elementsToCreate=[];
        $elementsToUpdate=[];
        $valuesToUpdate=[];
        foreach($items as $itemCouter => $item)
        {
            $item[$foreign_column] =  $model->id;
            $this->createOrUpdateModel($repeatChapterIDs,$modelToCreateOrUpdate,$item,$elementsToCreate,$elementsToUpdate,$valuesToUpdate);                  
        }

        if($elementsToCreate)
        {
            foreach($elementsToCreate as $key => $item)
            {
                unset($elementsToCreate[$key]['id']);
            }
            $columns = array_keys($elementsToCreate[0]);

            
            Yii::$app->db->createCommand()
            ->batchInsert($modelToCreateOrUpdate::tableName(), $columns, $elementsToCreate)
            ->execute();
            
        }

        if($elementsToUpdate)
        {
            foreach($elementsToUpdate as $key => $item)
            {
                $item->updateAttributes($valuesToUpdate[$key]);
            }
        }

    }

    private function createOrUpdateModel(&$repeatIDs,$modelToCreateOrUpdate,$item,&$elementsToCreate,&$elementsToUpdate,&$valuesToUpdate)
    {
        $model = $modelToCreateOrUpdate::findOne(["id"=>$item["id"] ] );
        if($model)
        {
            $repeatIDs[$model->id] = isset($repeatIDs[$model->id])? $repeatIDs[$model->id]++ : 1; 
            
            if($repeatIDs[$model->id] == 1 && $model)
            {
                $oldValues = ArrayHelper::toArray( $model );
                $newValues =  array_diff_assoc($item, $oldValues);
                if($newValues)
                {
                    $elementsToUpdate[] = $model;
                    $valuesToUpdate[] = $newValues;

                    //$model->updateAttributes($newValues);
                }

            }
            else
            {
                $elementsToCreate[] = $item;
                //$model = $this->createElement($modelToCreateOrUpdate,$model,$item);
            }
        
        }
        else
        {
            $elementsToCreate[] = $item;
            //$model = $this->createElement($modelToCreateOrUpdate,$model,$item);
        }
        
        return $model;

    }
    

    private function deleteOldData($oldWithRelation,$postData,$modelToDeleteFrom)
    {
        $oldIDs = ArrayHelper::getColumn( $oldWithRelation,'id');

        if(!$postData)//null
        {
            $modelToDeleteFrom::deleteAll(["id" => $oldIDs ]);
            return;
        }

        $postIDs = ArrayHelper::getColumn( $postData, 'id');
        $deleteIDs =  array_diff_assoc($oldIDs, $postIDs);        
        if($deleteIDs)
        {
            $modelToDeleteFrom::deleteAll(["id" => $deleteIDs ]);
        }
    }



}