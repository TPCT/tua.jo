<?php

namespace backend\modules\currency\models;

use backend\modules\currency_price\models\CurrencyPrice;
use bedezign\yii2\audit\AuditTrailBehavior;
use yeesoft\behaviors\MultilingualBehavior;
use yeesoft\db\ActiveRecord;
use yeesoft\models\User;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use common\components\ModulesModelComponent;
use common\components\RevisionTrait;

/**
 * This is the model class for table "currency".
 *
 * @property int $id
 * @property int $status 0-pending 1-published
 * @property decimal $price
 * @property int $published_at
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int $revision
 * @property int $changed
 * @property string $reject_note
 *
 * @property User $createdBy
 * @property User $updatedBy
 * @property CurrencyLang[] $CurrencyLangs
 */

class Currency extends ActiveRecord
{
    use RevisionTrait;
    use ModulesModelComponent;

    const STATUS_PENDING = 0;
    const STATUS_PUBLISHED = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'currency';
    }
    public static function labelAtView()
    {
        return Yii::t('site', 'currency');
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            AuditTrailBehavior::className(),
            TimestampBehavior::className(),
            BlameableBehavior::className(),
            // 'sluggable' => [
            //     'class' => SluggableBehavior::className(),
            //     'attribute' => 'title',
            //     'ensureUnique' => true,
            // ],
            'multilingual' => [
                'class' => MultilingualBehavior::className(),
                'langForeignKey' => 'parent_id',
                'langClassName' => CurrencyLang::className(),
                'tableName' => "{{%currency_lang}}",
                'attributes' => [
                    'title',
                ]
            ],
        ];
    }

    public function getLangualAttributes()
    {
        return 
        [                    
            'title',
        ];
    }

    public function getIgnoreAttributes()
    {
        return 
        [
            'id','status', 'created_at', 'updated_at', 'revision', 'comment_status',
            'published_at','created_by','updated_by','view','layout','revision',
            'reject_note','changed',

            //relational will be ignore and putl relational at additional
            
        ];
    }

    public function getAdditionalAttributes()
    {
        return [];
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return 
        [

            [
                [
                      'national_currency', 'title','api_id','rate','is_default',
                    'status','reject_note','created_at', 'updated_at', 'created_by', 'updated_by',
                ], 
                function ($attribute) 
                {
                    if (preg_match('/<[^b][^r][^>]*>/', $this->$attribute)) {
                        $this->addError($attribute, Yii::t('site', 'HTML is invalid.'));
                    }
                }
            ],
            
            [   
                [
                       'national_currency',
                    'title','api_id','rate','is_default',
                    'status','reject_note','created_at', 'updated_at', 'created_by', 'updated_by',
                ], function ($attribute) {
                $this->$attribute = \yii\helpers\HtmlPurifier::process($this->$attribute);
            }],
            [['slug'], 'unique'],

            [
                [
                    'slug', 'status', 'title', 'api_id'
                ],
                'string', 'max' => 255
            ],

            [['title','rate','is_default','api_id'],'required'],
            [['rate'], 'number'],


            [['status', 'national_currency', 'revision', 'changed', 'created_by', 'updated_by'], 'integer'],
            [['title', 'reject_note'], 'string', 'max' => 255],
            [['created_at', 'updated_at', 'reject_note', 'changed', 'revision'], 'safe'],
            
            ['published_at', 'date', 'timestampAttribute' => 'published_at', 'format' => 'yyyy-MM-dd'],
            ['published_at', 'default', 'value' => time()],
            
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('site', 'ID'),
            'title' => Yii::t('site', 'Title'),
            'status' => Yii::t('site', 'Status'),
            'published_at' => Yii::t('site', 'Published At'),
            'created_at' => Yii::t('site', 'Created At'),
            'updated_at' => Yii::t('site', 'Updated At'),
            'created_by' => Yii::t('site', 'Created By'),
            'updated_by' => Yii::t('site', 'Updated By'),
            'revision' => Yii::t('site', 'Revision'),

        ];
    }

    /**
     * {@inheritdoc}
     * @return CurrencyQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CurrencyQuery(get_called_class());
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrencyPrices()
    {
        return $this->hasMany(CurrencyPrice::className(), ['currency_id' => 'id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrencyPrice()
    {
        return $this->hasOne(CurrencyPrice::className(), ['currency_id' => 'id'])
                    ->andWhere([CurrencyPrice::tableName().".status"=>CurrencyPrice::STATUS_PUBLISHED])
                    ->orderBy(['published_at' => SORT_DESC]);
    }

    
}
