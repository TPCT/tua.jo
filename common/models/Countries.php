<?php

namespace common\models;

use backend\modules\city\models\City;
use Yii;

/**
 * This is the model class for table "countries".
 *
 * @property int $num_code
 * @property string $alpha_2_code
 * @property string $alpha_3_code
 * @property string $en_short_name
 * @property string $nationality
 */
class Countries extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'countries';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['num_code'], 'required'],
            [['num_code'], 'integer'],
            [['alpha_2_code'], 'string', 'max' => 2],
            [['alpha_3_code'], 'string', 'max' => 3],
            [['en_short_name'], 'string', 'max' => 52],
            [['nationality'], 'string', 'max' => 39],
            [['alpha_2_code'], 'unique'],
            [['alpha_3_code'], 'unique'],
            [['num_code'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'num_code' => Yii::t('site', 'Num Code'),
            'alpha_2_code' => Yii::t('site', 'Alpha 2 Code'),
            'alpha_3_code' => Yii::t('site', 'Alpha 3 Code'),
            'en_short_name' => Yii::t('site', 'En Short Name'),
            'nationality' => Yii::t('site', 'Nationality'),
        ];
    }

    public function getCities(){
        return $this->hasMany(City::className(), ['country_id' => 'id']);
    }

    public function __toString()
    {
        return $this->nationality;
    }
}
