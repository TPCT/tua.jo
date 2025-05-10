<?php

namespace yeesoft\page\models;
use common\components\behaviors\ReplacementBehavior;

use Yii;

/**
 * This is the model class for table "page_lang".
 *
 * @property int $id
 * @property int $page_id
 * @property string $language
 * @property string $title
 * @property string $second_title
 * @property string $brief
 * @property string $content
 * @property string $image
 * @property string $keywords
 * @property string $footer_content
 *
 * @property Page $page
 */
class PageLang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'page_lang';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            \bedezign\yii2\audit\AuditTrailBehavior::className(),
            'replacement' => [
                'class' => ReplacementBehavior::className(),
                'attributes' => [ 'title', 'second_title', 'brief'],
                'from' => ['الله', 'عبداللَّه'],
                'to' => ['ﷲ', 'عبدﷲ'],
            ],

        ];
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['page_id', 'language'], 'required'],
            [['page_id'], 'integer'],
            [['content', 'footer_content', 'brief',], 'string'],
            [['language'], 'string', 'max' => 6],
            [
                [
                    'title','second_title', 'image', 'keywords', 'header_image', 'header_image_title',
                    'header_image_brief',
                ], 'string', 'max' => 255
            ],
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
            'language' => 'Language',
            'title' => 'Title',
            'second_title' => 'Second Title',
            'brief' => 'Brief',
            'content' => 'Content',
            'image' => 'Image',
            'keywords' => 'Keywords',
            'footer_content' => 'Footer Content',
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
