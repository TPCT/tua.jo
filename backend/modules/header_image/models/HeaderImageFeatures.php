<?php

namespace backend\modules\header_image\models;

use Yii;
use common\helpers\Utility;
use common\models\User;
use backend\modules\header_image\models\HeaderImage;
use yeesoft\behaviors\MultilingualBehavior;
use yeesoft\db\ActiveRecord;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "material".
 *
 *
 * @property Service[] $services
 */
class HeaderImageFeatures extends ActiveRecord
{
    public $header_image_bread_crumbs;
    /**
     * {@inheritdoc}
     */

    public static function tableName()
    {
        return 'header_image_bread_crumb';
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
  
            [['created_at', 'updated_at','header_image_id'], 'safe'],
            [['button_text_ar', 'button_text_en','button_url', 'view', 'layout','slug'], 'string'],

            ['published_at', 'date', 'timestampAttribute' => 'published_at', 'format' => 'yyyy-MM-dd'],
            ['published_at', 'default', 'value' => time()],
        ];
    }


    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }




    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'slug' => Yii::t('app', 'Slug'),
            'status' => Yii::t('app', 'Status'),
            'published_at' => Yii::t('app', 'Published At'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'updated_by' => Yii::t('app', 'Updated By'),
            'revision' => Yii::t('app', 'Revision'),
            'view' => Yii::t('app', 'View'),
            'layout' => Yii::t('app', 'Layout'),
            'type' => Yii::t('app', 'Type'),
        ];
    }


    

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHeaderimage()
    {
        return $this->hasOne(HeaderImage::className(), ['id' => 'header_image_id']);
    }


    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    public function getTransBody()
    {
        $body = $this->body;
        if (\Yii::$app->language == 'ar') {
            $body = $this->body_ar;
        }
        return $body;
    }

    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    public function getPublishedDate()
    {
        return Yii::$app->formatter->asDate(($this->isNewRecord) ? time() : $this->published_at);
    }

    public function getCreatedDate()
    {
        return Yii::$app->formatter->asDate(($this->isNewRecord) ? time() : $this->created_at);
    }

    public function getUpdatedDate()
    {
        return Yii::$app->formatter->asDate(($this->isNewRecord) ? time() : $this->updated_at);
    }

    public function getPublishedTime()
    {
        return Yii::$app->formatter->asTime(($this->isNewRecord) ? time() : $this->published_at);
    }

    public function getCreatedTime()
    {
        return Yii::$app->formatter->asTime(($this->isNewRecord) ? time() : $this->created_at);
    }

    public function getUpdatedTime()
    {
        return Yii::$app->formatter->asTime(($this->isNewRecord) ? time() : $this->updated_at);
    }

    public function getPublishedDatetime()
    {
        return "{$this->publishedDate} {$this->publishedTime}";
    }

    public function getCreatedDatetime()
    {
        return "{$this->createdDate} {$this->createdTime}";
    }

    public function getUpdatedDatetime()
    {
        return "{$this->updatedDate} {$this->updatedTime}";
    }

    public function getStatusText()
    {
        return $this->getStatusList()[$this->status];
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
     * getTypeList
     * @return array
     */
    public static function getStatusList()
    {
        return [
            Utility::STATUS_PENDING => Yii::t('yee', 'Pending'),
            Utility::STATUS_PUBLISHED => Yii::t('yee', 'Published'),
        ];
    }


    /**
     * getStatusOptionsList
     * @return array
     */
    public static function getStatusOptionsList()
    {
        return [
            [Utility::STATUS_PENDING, Yii::t('yee', 'Pending'), 'default'],
            [Utility::STATUS_PUBLISHED, Yii::t('yee', 'Published'), 'primary']
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

    /**
     * getStatusOptionsList
     * @return string
     */
    public function __toString()
    {
        return $this->title;
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        \Yii::$app->cache->flush();
        return parent::save($runValidation, $attributeNames);
    }
}
