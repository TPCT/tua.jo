<?php

namespace backend\modules\news\models;

use bedezign\yii2\audit\AuditTrailBehavior;
use common\components\behaviors\ReplacementBehavior;
use Yii;

/**
 * This is the model class for table "news_lang".
 *
 * @property int $id
 * @property int|null $parent_id
 * @property string|null $language
 * @property string $slug
 * @property int $status 0-pending 1-published
 * @property string $title
 * @property string|null $content
 * @property string|null $content_2
 * @property string|null $pdf_file
 *
 * @property News $parent
 */

class NewsLang extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'news_lang';
    }

    public function behaviors()
    {
        return [
            
//            AuditTrailBehavior::className(),

            'replacement' => [
                'class' => ReplacementBehavior::className(),
                'attributes' => [ 'title', 'content', 'brief', 'source', 'header_line'],
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
//            [['parent_id', 'status', 'promote_to_front', 'promote_to_our_story'], 'integer'],
//            [['slug', 'title'], 'required'],
//            [['language'], 'string', 'max' => 6],
//            [['slug', 'title', 'pdf_file', 'brief'], 'string', 'max' => 255],
//            [['status'], 'default', 'value' => 0],
//            [['slug'], 'unique'],
//            [['content','content_2'], 'string'],
//            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => News::class, 'targetAttribute' => ['parent_id' => 'id']],
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
            'image' => 'Image',
            'url' => 'Url',
            'button_text' => 'Button Text',
        ];
    }

    /**
     * Gets query for [[Parent]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(News::class, ['id' => 'parent_id']);
    }

}
