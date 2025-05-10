<?php

namespace yeesoft\page\models;

use Yii;

/**
 * This is the model class for table "page_accordion".
 *
 * @property int $id
 * @property int $page_id
 * @property string $title_en
 * @property string $brief_en
 * @property string $title_ar
 * @property string $brief_ar
 *
 * @property LawRegulation $lawRegulation
 */
class PageAccordion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'page_accordion';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            \bedezign\yii2\audit\AuditTrailBehavior::className(),

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['page_id', 'title_en', 'brief_en', 'title_ar', 'brief_ar'], 'required'],
            [['page_id'], 'integer'],
            [['title_en', 'title_ar','image_en','image_ar'], 'string', 'max' => 255],
            [['brief_en','brief_ar'], 'string'],
            [['page_id'], 'exist', 'skipOnError' => true, 'targetClass' => Page::className(), 'targetAttribute' => ['page_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'page_id' => 'Page ID',
            'title_en' => 'Title En',
            'brief_en' => 'Brief En',
            'title_ar' => 'Title Ar',
            'brief_ar' => 'Brief Ar',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPage()
    {
        return $this->hasOne(Page::className(), ['id' => 'page_id']);
    }
}
