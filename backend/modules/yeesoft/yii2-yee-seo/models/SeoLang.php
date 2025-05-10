<?php

namespace yeesoft\seo\models;

use bedezign\yii2\audit\AuditTrailBehavior;
use Yii;

/**
 * This is the model class for table "seo_lang".
 *
 * @property integer $id
 * @property string $title
 * @property string $author
 * @property string $keywords
 * @property string $description
 *
 */
class SeoLang extends \yii\db\ActiveRecord 
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%seo_lang}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['parent_id'], 'integer'],
            [['language'], 'string', 'max' => 6],
            [['keywords', 'description'], 'string', 'max' => 1000],
            [['url', 'title'], 'string', 'max' => 255],
        
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Seo::class, 'targetAttribute' => ['parent_id' => 'id']],

        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            AuditTrailBehavior::class
        ];
    }


    
    /**
     * Gets query for [[Parent]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Seo::class, ['id' => 'parent_id']);
    }


}