<?php

namespace backend\modules\bms\models;

use common\helpers\Purifier;
use Yii;

/**
 * This is the model class for table "card_features".
 *
 * @property int $id
 * @property int $card_id
 * @property string $title_en
 * @property string $title_ar
 * @property string $brief_en
 * @property string $brief_ar
 *
 * @property BMS $card
 */
class BmsFeature extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bms_feature';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title_en','title_ar', ], 'required'],
            [['created_at', 'updated_at','bms_id'], 'safe'],
            [['image', 'content_en', 'content_ar','brief_ar','brief_en', 'view', 'layout','second_title_en','second_title_ar'], 'string'],

            ['published_at', 'date', 'timestampAttribute' => 'published_at', 'format' => 'yyyy-MM-dd'],
            ['published_at', 'default', 'value' => time()],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'card_id' => 'Card ID',
            'title_en' => 'Title En',
            'title_ar' => 'Title Ar',
            'brief_en' => 'Brief En',
            'brief_ar' => 'Brief Ar',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBms()
    {
        return $this->hasOne(Bms::className(), ['id' => 'bms_id']);
    }
}
