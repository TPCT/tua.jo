<?php

namespace backend\modules\youtube\models;

use bedezign\yii2\audit\AuditTrailBehavior;
use common\components\behaviors\ReplacementBehavior;
use Yii;

/**
 * This is the model class for table "youtube_links_lang".
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
 * @property YoutubeLinks $parent
 */
class YoutubeLinksLang extends \yii\db\ActiveRecord
{

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'youtube_links_lang';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            AuditTrailBehavior::className(),
            'replacement' => [
                'class' => ReplacementBehavior::className(),
                'attributes' => [ 'title', 'brief'],
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
            [['parent_id', 'language', 'title'], 'required'],
            [['parent_id', 'promote_to_front', ], 'integer'],
            [['language'], 'string', 'max' => 6],
            [
                [
                    'title', 'media_path', 
                    'header_image', 'header_image_title',
                ], 'string', 'max' => 255
            ],
            [['brief',],'string'],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => YoutubeLinks::className(), 'targetAttribute' => ['parent_id' => 'id']],
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
        return $this->hasOne(YoutubeLinks::className(), ['id' => 'parent_id']);
    }
}
