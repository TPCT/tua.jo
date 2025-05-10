<?php

namespace backend\modules\city\models;

use backend\modules\countries\models\Country;
use bedezign\yii2\audit\AuditTrailBehavior;
use common\components\ModulesModelComponent;
use common\models\User;
use yeesoft\behaviors\MultilingualBehavior;
use yeesoft\db\ActiveRecord;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "city".
 *
 * @property int $id
 * @property string $slug
 * @property int $status 0-pending,1-published
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class City extends ActiveRecord
{
    use ModulesModelComponent;

    const STATUS_PENDING = 0;
    const STATUS_PUBLISHED = 1;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'city';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['slug', 'title','country_id'], 'required'],
            [['status', 'created_at', 'updated_at', 'created_by', 'updated_by','country_id'], 'integer'],
            [['slug'], 'string', 'max' => 255],

            [
                [
                'title','slug','status','country_id'
                ], function ($attribute) 
                {
                    if (preg_match('/<[^b][^r][^>]*>/', $this->$attribute)) {
                        $this->addError($attribute, Yii::t('site', 'HTML is invalid.'));
                    }
                }
            ],

            [[
                'title','slug','status'], function ($attribute) {
                $this->$attribute = \yii\helpers\HtmlPurifier::process($this->$attribute);
            }],
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            AuditTrailBehavior::class,
            TimestampBehavior::class,
            BlameableBehavior::class,
            'sluggable' => [
                 'class' => SluggableBehavior::class,
                 'attribute' => 'title',
             ],
            'multilingual' => [
                'class' => MultilingualBehavior::class,
                'langClassName' => CityLang::class,
                'langForeignKey' => 'city_id',
                'tableName' => "{{%city_lang}}",
                'attributes' => [
                    'title'
                ]
            ],
        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('site', 'ID'),
            'slug' => Yii::t('site', 'Slug'),
            'status' => Yii::t('site', 'Status'),
            'created_at' => Yii::t('site', 'Created At'),
            'updated_at' => Yii::t('site', 'Updated At'),
            'created_by' => Yii::t('site', 'Created By'),
            'updated_by' => Yii::t('site', 'Updated By'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return CityQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CityQuery(get_called_class());
    }

    public function getCountries()
    {
        return \yii\helpers\ArrayHelper::map(\backend\modules\countries\models\Country::find()->all(), 'id', 'title');
    }

    public function getCountry()
    {
        return $this->hasOne(Country::class, ['id' => 'country_id']);
    }
    

}
