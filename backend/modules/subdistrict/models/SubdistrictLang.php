<?php

namespace backend\modules\subdistrict\models;

use Yii;

/**
 * This is the model class for table "subdistrict_lang".
 *
 * @property int $id
 * @property int $subdistrict_id
 * @property string $language
 * @property string|null $title
 *
 * @property Subdistrict $subdistrict
 */
class SubdistrictLang extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'subdistrict_lang';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'default', 'value' => null],
            [['subdistrict_id', 'language'], 'required'],
            [['subdistrict_id'], 'integer'],
            [['language'], 'string', 'max' => 6],
            [['title'], 'string', 'max' => 255],
            [['subdistrict_id'], 'exist', 'skipOnError' => true, 'targetClass' => Subdistrict::class, 'targetAttribute' => ['subdistrict_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'subdistrict_id' => 'Subdistrict ID',
            'language' => 'Language',
            'title' => 'Title',
        ];
    }

    /**
     * Gets query for [[Subdistrict]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getSubdistrict()
    {
        return $this->hasOne(Subdistrict::class, ['id' => 'subdistrict_id']);
    }

}
