<?php

namespace backend\modules\district\models;

use Yii;

/**
 * This is the model class for table "district_lang".
 *
 * @property int $id
 * @property int $district_id
 * @property string $language
 * @property string|null $title
 *
 * @property District $district
 */
class DistrictLang extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'district_lang';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'default', 'value' => null],
            [['district_id', 'language'], 'required'],
            [['district_id'], 'integer'],
            [['language'], 'string', 'max' => 6],
            [['title'], 'string', 'max' => 255],
            [['district_id'], 'exist', 'skipOnError' => true, 'targetClass' => District::class, 'targetAttribute' => ['district_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'district_id' => 'District ID',
            'language' => 'Language',
            'title' => 'Title',
        ];
    }

    /**
     * Gets query for [[District]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getDistrict()
    {
        return $this->hasOne(District::class, ['id' => 'district_id']);
    }

}
