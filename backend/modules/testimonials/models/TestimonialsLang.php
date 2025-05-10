<?php

namespace backend\modules\testimonials\models;

use Yii;

/**
 * This is the model class for table "news_lang".
 *
 * @property int $id
 * @property int $parent_id
 * @property string $language
 * @property string $title
 * @property string $content
 * @property string $brief
 *
 * @property testimonials $parent
 */
class TestimonialsLang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'testimonial_lang';
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
            [['parent_id', 'language'], 'required'],
            [['parent_id'], 'integer'],
            [['brief'], 'string'],
            [['language'], 'string', 'max' => 6],
            [
                [
                    'title'
                ], 'string', 'max' => 255
            ],

            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Testimonials::className(), 'targetAttribute' => ['parent_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'language' => 'Language',
            'title' => 'Title',
            'brief' => 'Brief',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Testimonials::className(), ['id' => 'parent_id']);
    }
}
