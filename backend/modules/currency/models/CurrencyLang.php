<?php

namespace backend\modules\currency\models;

use Yii;

/**
 * This is the model class for table "currency_lang".
 *
 * @property int $id
 * @property int $parent_id
 * @property string $language
 * @property string $title
 *
 * @property Currency $parent
 */
class CurrencyLang extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'currency_lang';
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

            [['parent_id', 'language', 'title'], 'required'],
            [['parent_id'], 'integer'],
            [['language'], 'string', 'max' => 6],
            [['title',], 'string', 'max' => 255],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Currency::className(), 'targetAttribute' => ['parent_id' => 'id']],

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
            'title' => 'Title'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Currency::className(), ['id' => 'parent_id']);
    }
}
