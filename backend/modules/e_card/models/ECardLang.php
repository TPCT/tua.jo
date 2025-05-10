<?php

namespace backend\modules\e_card\models;

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

class ECardLang extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'e_cards_lang';
    }



    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
           [['parent_id'], 'integer'],
           [['title'], 'required'],
           [['language'], 'string', 'max' => 6],
           [['title', 'image'], 'string', 'max' => 255],

           [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => ECard::class, 'targetAttribute' => ['parent_id' => 'id']],
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
            'image' => 'Image',

        ];
    }

    /**
     * Gets query for [[Parent]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(ECard::class, ['id' => 'parent_id']);
    }

}
