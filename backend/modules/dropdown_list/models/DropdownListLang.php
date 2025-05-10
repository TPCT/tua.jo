<?php

namespace backend\modules\dropdown_list\models;

use Yii;

/**
 * This is the model class for table "dropdown_list_lang".
 *
 * @property int $id
 * @property int $parent_id
 * @property string $language
 * @property string $title
 *
 * @property DropdownList $parent
 */
class DropdownListLang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dropdown_list_lang';
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
            [['parent_id', 'promote_to_front', ], 'integer'],
            [['title','image','pdf_file'], 'string','max'=>255],
            [['object_fit', 'object_position',],'string','max'=>50],
            [['language'], 'string', 'max' => 6],
            [['content', 'brief',],'string'],
            [   
                [
                    'header_image',
                    'header_mobile_image', 'header_image_title','header_image_brief'
                ], 'string', 'max' => 500
            ],
            
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => DropdownList::className(), 'targetAttribute' => ['parent_id' => 'id']],
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
        return $this->hasOne(DropdownList::className(), ['id' => 'parent_id']);
    }
}
