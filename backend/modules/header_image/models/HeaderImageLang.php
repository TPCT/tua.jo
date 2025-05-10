<?php

namespace backend\modules\header_image\models;

use Yii;

/**
 * This is the model class for table "header_image_lang".
 *
 * @property int $id
 * @property int $parent_id
 * @property string $language
 * @property string $title
 *
 * @property HeaderImage $parent
 */
class HeaderImageLang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'header_image_lang';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['parent_id'], 'integer'],
            [['language'], 'string', 'max' => 6],
            [['title', 'brief', 'button_text', 'button_url', 'image', 'mobile_image'], 'string', 'max' => 255],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => HeaderImage::className(), 'targetAttribute' => ['parent_id' => 'id']],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(HeaderImage::className(), ['id' => 'parent_id']);
    }
}
