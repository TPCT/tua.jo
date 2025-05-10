<?php

namespace backend\modules\city\models;

use Yii;

/**
 * This is the model class for table "city_lang".
 *
 * @property int $id
 * @property int $city_id
 * @property string $language
 * @property string|null $title
 *
 * @property City $city
 */
class CityLang extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'city_lang';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'default', 'value' => null],
            [['city_id', 'language'], 'required'],
            [['city_id'], 'integer'],
            [['language'], 'string', 'max' => 6],
            [['title'], 'string', 'max' => 255],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => City::class, 'targetAttribute' => ['city_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'city_id' => 'City ID',
            'language' => 'Language',
            'title' => 'Title',
        ];
    }

    /**
     * Gets query for [[City]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(City::class, ['id' => 'city_id']);
    }

}
