<?php

namespace backend\modules\donation_types\models;

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
 * @property donation_types $parent
 */
class DonationTypesLang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'donation_types_lang';
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

            [['language'], 'string', 'max' => 6],
            [
                [
                    'title','cms_title',
                ], 'string', 'max' => 255
            ],
            [   
                [
                    'header_image',
                    'header_mobile_image', 'header_image_title','header_image_brief'
                ], 'string', 'max' => 500
            ],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => DonationTypes::className(), 'targetAttribute' => ['parent_id' => 'id']],
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
            'cms_title' => 'cms title',

        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(DonationTypes::className(), ['id' => 'parent_id']);
    }
}
