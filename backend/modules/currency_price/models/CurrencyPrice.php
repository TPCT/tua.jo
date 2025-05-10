<?php

namespace backend\modules\currency_price\models;

use backend\modules\currency\models\Currency;
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
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "currency_price".
 *
 * @property int $id
 * @property int $currency_id
 * @property int $published_at
 * @property int $status 0-pending 1-published
 * @property string $sell_price
 * @property string $buy_price
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int $revision
 * @property int $changed
 * @property string $reject_note
 *
 * @property User $createdBy
 * @property Currency $currency
 * @property User $updatedBy
 */

class CurrencyPrice extends ActiveRecord
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
        return 'currency_price';
    }
    public static function labelAtView()
    {
        return Yii::t('site', 'currency_price');
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
            // 'multilingual' => [
            //     'class' => MultilingualBehavior::className(),
            //     'langForeignKey' => 'parent_id',
            //     'langClassName' => CurrencyLang::className(),
            //     'tableName' => "{{%currency_lang}}",
            //     'attributes' => [
            //         'title', 'symbol'
            //     ]
            // ],
        ];
    }

    public function getLangualAttributes()
    {
        return [];
    }

    public function getIgnoreAttributes()
    {
        return 
        [
            'id','status', 'created_at', 'updated_at', 'revision', 'comment_status',
            'published_at','created_by','updated_by','view','layout','revision',
            'reject_note','changed',

            //relational will be ignore and putl relational at additional
            'currency_id',
        ];
    }

    public function getAdditionalAttributes()
    {
        return ['currency'];
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return  [

            
            [['currency_id', 'sell_price', 'buy_price'], 'required'],
            [['currency_id', 'status', 'created_by', 'updated_by', 'revision', 'changed'], 'integer'],
            [['sell_price', 'buy_price'], 'number'],
            [['reject_note'], 'string', 'max' => 255],
            
            [['created_at', 'updated_at', 'reject_note', 'changed', 'revision'], 'safe'],
            
            ['published_at', 'date', 'timestampAttribute' => 'published_at', 'format' => 'yyyy-MM-dd'],
            ['published_at', 'default', 'value' => time()],
            
            [['currency_id', 'published_at'], 'unique', 'targetAttribute' => ['currency_id', 'published_at']],
         
            [['currency_id'], 'exist', 'skipOnError' => true, 'targetClass' => Currency::className(), 'targetAttribute' => ['currency_id' => 'id']],
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
            'symbol' => Yii::t('site', 'Symbol'),

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
     * @return CurrencyPriceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CurrencyPriceQuery(get_called_class());
    }


    /**
     * getCurrencyList
     * @return array
     */
    public static function getCurrencyList()
    {
        $currencies = Currency::find()->active()->all();
        return ArrayHelper::map($currencies,"id","title");
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCurrency()
    {
        return $this->hasOne(Currency::className(), ['id' => 'currency_id']);
    }

    
}
