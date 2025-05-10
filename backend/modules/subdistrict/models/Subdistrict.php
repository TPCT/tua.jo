<?php

namespace backend\modules\subdistrict\models;

use backend\modules\district\models\District;
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
 * This is the model class for table "subdistrict".
 *
 * @property int $id
 * @property string $slug
 * @property int $status 0-pending,1-published
 * @property int $district_id
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 */
class Subdistrict extends ActiveRecord
{
    use ModulesModelComponent;
    const STATUS_PENDING = 0;
    const STATUS_PUBLISHED = 1;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'subdistrict';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['slug', 'title'], 'required'],
            [['district_id', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'], 'integer'],
            [['slug'], 'string', 'max' => 255],

            [
                [
                'title','district_id','status'
                ], function ($attribute) 
                {
                    if (preg_match('/<[^b][^r][^>]*>/', $this->$attribute)) {
                        $this->addError($attribute, Yii::t('site', 'HTML is invalid.'));
                    }
                }
            ],

            [[
                'title','district_id','status'], function ($attribute) {
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
                'langClassName'=>SubdistrictLang::class,
                'langForeignKey' => 'subdistrict_id',
                'tableName' => "{{%subdistrict_lang}}",
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
     * @return SubdistrictQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SubdistrictQuery(get_called_class());
    }



    public function getDistrict()
    {
        return $this->hasOne(District::className(), ['id' => 'district_id']);
    }

   
}
