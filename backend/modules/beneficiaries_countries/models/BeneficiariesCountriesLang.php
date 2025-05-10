<?php

namespace backend\modules\beneficiaries_countries\models;

use Yii;

/**
 * This is the model class for table "annual_report_lang".
 *
 * @property int $id
 * @property int $parent_id
 * @property string $language
 * @property string $title
 * @property string $content
 * @property string $brief
 *
 * @property beneficiaries_countries $parent
 */
class BeneficiariesCountriesLang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'beneficiaries_countries_lang';
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
            [['parent_id'], 'integer'],
            [['brief'], 'string'],
            [['language'], 'string', 'max' => 6],
            [
                [
                    'title'
                ], 'string', 'max' => 255
            ],
  
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => BeneficiariesCountries::className(), 'targetAttribute' => ['parent_id' => 'id']],
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
            'content' => 'Content',
            'brief' => 'Brief',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(BeneficiariesCountries::className(), ['id' => 'parent_id']);
    }
}
