<?php
namespace common\components;

use backend\modules\section\models\Section;
use common\helpers\Utility;
use common\models\User;
use Yii;
use common\models\DynamicModel;
use yeesoft\db\ActiveRecord;
use yeesoft\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;

trait  ModulesModelComponent 
{
    
    
     /**
     * @return string
     */
    public function __toString()
    {
        return $this->title;
    }

    public function getHaveRevision()
    {
        if( $this->hasAttribute('revision') )
        {
            return $this::find()->where(['revision' => $this->id])->andWhere(['<>', 'revision', 0])->one();
        }

    }


    public function getCreator()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    public function getCreatedDate()
    {
        return Yii::$app->formatter->asDate(($this->isNewRecord) ? time() : $this->created_at);
    }

    public function getCreatedTime()
    {
        return Yii::$app->formatter->asTime(($this->isNewRecord) ? time() : $this->created_at);
    }

    public function getCreatedDatetime()
    {
        return "{$this->createdDate} {$this->createdTime}";
    }
    public function getCreatedDateYear()
    {
        Yii::$app->formatter->locale = "en";
        return Yii::$app->formatter->asDate(($this->isNewRecord) ? time() : $this->created_at, 'php:Y');
    }

    public function getCreatedDateMonth()
    {
        Yii::$app->formatter->locale = Yii::$app->language;
        return Yii::$app->formatter->asDate(($this->isNewRecord) ? time() : $this->created_at, 'php:F');
    }

    public function getCreatedDateDay()
    {
        Yii::$app->formatter->locale = "en";
        return Yii::$app->formatter->asDate(($this->isNewRecord) ? time() : $this->created_at, 'php:d');
    }

    public function getCreatedDateDayName()
    {
        Yii::$app->formatter->locale = Yii::$app->language;
        return Yii::$app->formatter->asDate(($this->isNewRecord) ? time() : $this->created_at, 'php:D');
    }

    public function getFullCreatedDate()
    {
        return $this->createdDateDayName .",". $this->createdDateDay ." ". $this->createdDateMonth ." ". $this->createdDateYear ;                               
    }

    public function getUpdatedDate()
    {
        return Yii::$app->formatter->asDate(($this->isNewRecord) ? time() : $this->updated_at);
    }

    public function getUpdatedTime()
    {
        return Yii::$app->formatter->asTime(($this->isNewRecord) ? time() : $this->updated_at);
    }

    public function getUpdatedDatetime()
    {
        return "{$this->updatedDate} {$this->updatedTime}";
    }

    public function getPublishedDate()
    {
        Yii::$app->formatter->locale = "en";
        return Yii::$app->formatter->asDate(($this->isNewRecord) ? time() : $this->published_at);
    }

    public function getPublishedDate2()
    {
        Yii::$app->formatter->locale = "en";
        $montNameLevantin = $this->publishedDateMonth;
        if(Yii::$app->language == "ar")
        {
            if(intval($this->PublishedDateMonthNumber) != 0)
            {
                $montNameLevantin = Utility::$levantineMonths[ intval($this->PublishedDateMonthNumber) ];
            }
        }

        return "{$this->publishedDateDay} {$montNameLevantin} {$this->publishedDateYear}";
    }

    public function getPublishedDateNewFormat()
    {
        Yii::$app->formatter->locale = "en";
        return "{$this->PublishedDateDay}/$this->PublishedDateMonthNumber/$this->PublishedDateYear";
    }

    public function getPublishedTime()
    {
        return Yii::$app->formatter->asTime(($this->isNewRecord) ? time() : $this->published_at);
    }

    public function getPublishedDatetime()
    {
        return "{$this->publishedDate} {$this->publishedTime}";
    }

    public function getPublishedDateYear()
    {
        Yii::$app->formatter->locale = "en";
        if($this->published_at)
        {
            return Yii::$app->formatter->asDate(($this->isNewRecord) ? time() : $this->published_at, 'php:Y');
        }

    }

    public function getPublishedDateMonth()
    {
        Yii::$app->formatter->locale = Yii::$app->language;
        if($this->published_at)
        {
            return Yii::$app->formatter->asDate(($this->isNewRecord) ? time() : $this->published_at, 'php:F');
        }
    }

    public function getPublishedDateMonthNumber()
    {
        Yii::$app->formatter->locale = "en";
        return Yii::$app->formatter->asDate(($this->isNewRecord) ? time() : $this->published_at, 'php:m');
    }

    public function getPublishedDateDay()
    {
        Yii::$app->formatter->locale = "en";
        if($this->published_at)
        {
            return Yii::$app->formatter->asDate(($this->isNewRecord) ? time() : $this->published_at, 'php:d');
        }

    }

    public function getPublishedDateDayName()
    {
        Yii::$app->formatter->locale = Yii::$app->language;
        return Yii::$app->formatter->asDate(($this->isNewRecord) ? time() : $this->published_at, 'php:D');
    }

    public function getPublishedDateFullDayName()
    {
        Yii::$app->formatter->locale = Yii::$app->language;
        return Yii::$app->formatter->asDate(($this->isNewRecord) ? time() : $this->published_at, 'php:l');
    }

    public function getFullPublishedDate()
    {
        return $this->publishedDateFullDayName .",". $this->publishedDateDay ." ". $this->publishedDateMonth ." ". $this->publishedDateYear ;                               
    }

    public function getPublishedAtFullDate($published_at){
        return  Yii::$app->formatter->asDate($published_at, 'php:d M Y') ;
    }
    public function getPublishedAtFullYear($published_at){
        return Yii::$app->formatter->asDate($published_at, 'php: Y');
    }
    public function getStatusText()
    {
        return $this->getStatusList()[$this->status];
    }

    public function getCommentStatusText()
    {
        return $this->getCommentStatusList()[$this->comment_status];
    }

    
    public function getRevision()
    {
        return ($this->isNewRecord) ? 1 : $this->revision;
    }

    public function updateRevision()
    {
        $this->updateCounters(['revision' => 1]);
    }


        /**
     * getStatusList
     * @return array
     */
    public static function getStatusList()
    {
        return [
            self::STATUS_PENDING => Yii::t('yee', 'Pending'),
            self::STATUS_PUBLISHED => Yii::t('yee', 'Published'),
        ];
    }

    /**
     * getStatusOptionsList
     * @return array
     */
    public static function getStatusOptionsList()
    {
        return [
            [self::STATUS_PENDING, Yii::t('yee', 'Pending'), 'default'],
            [self::STATUS_PUBLISHED, Yii::t('yee', 'Published'), 'primary']
        ];
    }

    /**
     * getCommentStatusList
     * @return array
     */
    public static function getCommentStatusList()
    {
        return [
            self::COMMENT_STATUS_OPEN => Yii::t('yee', 'Open'),
            self::COMMENT_STATUS_CLOSED => Yii::t('yee', 'Closed')
        ];
    }

    

    public function getThumbnail($options = ['class' => 'thumbnail pull-left', 'style' => 'width: 240px'])
    {

        if (!empty($this->image)) {
            return Html::img($this->image, $options);
        }

        return;
    }

    

    /**
     * getTypeList
     * @return array
     */
    public static function getGridSizeList()
    {
        return [
            '' => Yii::t('site', ''),
            'col-lg-8' => Yii::t('site', 'col-lg-8'),
            'col-lg-4' => Yii::t('site', 'col-lg-4'),
            'col-lg-12' => Yii::t('site', 'col-lg-12'),
        ];
    }

    /**
     *
     * @inheritdoc
     */
    public static function getFullAccessPermission()
    {
        return 'fullPageAccess';
    }

    /**
     *
     * @inheritdoc
     */
    public static function getOwnerField()
    {
        return 'created_by';
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        // To insure replace all spaces if user add the slug
        if(isset($this->slug))
        {
            $this->slug = Inflector::slug($this->slug);
        }


        \Yii::$app->cache->flush();
        return parent::save($runValidation, $attributeNames);
    }

    public function getModelName()
    {
        $model = get_class($this);
        $names = explode("\\",$model);
        return Yii::t("site",end($names));
    }

    public function getSections()
    {
        return $this->hasMany(Section::className(), ['id' => 'section_id'])->viaTable( $this->tableName().'_section', [$this->tableName().'_id' => 'id']);
    }

    public function setSections()
    {
        $this->section_ids = $this->getSections()->select('id')->column();
    }


    //to save dyanmic forms
    public function saveDynamic($relation,$model,$parent_column)
    {
        $model::deleteAll([$parent_column => $this->id]);

        $model_name = (end(explode("\\",$model)));
        $posted_data = Yii::$app->getRequest()->post();
        if(!$posted_data[$model_name]) // null
        {
            return ;
        }
        for($i=0; $i< count($posted_data[$model_name]); $i++)
        {
            $posted_data[$model_name][$i][$parent_column] =  $this->id;
        }

        
       
        $values = $this[$relation];
        
        if($this->isNewRecord)
        {
            $values = DynamicModel::createMultiple($model);
        }
        else
        {
            $values = DynamicModel::createMultiple($model, $values);
        }
        DynamicModel::loadMultiple($values, $posted_data);
        
        if(!empty($values) )
        {
            //$new_model = new $model;
            //$columns = array_keys($new_model->attributeLabels());

            $rows = ArrayHelper::getColumn($values, 'attributes');
            //print_r($columns); exit;
            for($i=0; $i<count($rows); $i++)
            {
                unset($rows[$i]['id']);
            }
            $columns = array_keys($rows[0]);
            
            
            Yii::$app->db->createCommand()
                    ->batchInsert($model::tableName(), $columns, $rows)
                    ->execute();
        }
                    
    }


}