<?php

namespace backend\modules\bms\models;

use bedezign\yii2\audit\AuditTrailBehavior;
use common\components\behaviors\ReplacementBehavior;
use Yii;

/**
 * This is the model class for table "bms_lang".
 *
 * @property int $id
 * @property int $parent_id
 * @property string $language
 * @property string $title
 * @property string $second_title
 * @property string $brief
 * @property string $image
 * @property string $button_text
 * @property string $button_2_text
 * @property string $button_image_1
 * @property string $button_image_2
 *
 * @property Bms $parent
 */
class BmsLang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bms_lang';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            AuditTrailBehavior::className(),

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
            [['brief', 'second_title','content'], 'string'],
            [['language'], 'string', 'max' => 6],
            [
                [
                    'title', 'image', 'button_text', 'button_2_text', 'button_image_1',
                    'button_image_2', 'mobile_image'
                ], 'string', 'max' => 255
            ],
            [['object_fit', 'object_position',],'string','max'=>50],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Bms::className(), 'targetAttribute' => ['parent_id' => 'id']],
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
            'second_title' => 'Second Title',
            'brief' => 'Brief',
            'image' => 'Image',
            'button_text' => 'Button Text',
            'button_2_text' => 'Button 2 Text',
            'button_image_1' => 'Button Image 1',
            'button_image_2' => 'Button Image 2'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Bms::className(), ['id' => 'parent_id']);
    }
}
