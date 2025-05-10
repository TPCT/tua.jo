<?php

namespace backend\modules\countries\models;


use backend\modules\city\models\City;
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

class Country extends ActiveRecord
{
    use ModulesModelComponent;



    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'countries';
    }
    public static function labelAtView()
    {
        return Yii::t('site', 'countries');
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            // AuditTrailBehavior::className(),
            // TimestampBehavior::className(),
            // BlameableBehavior::className(),
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
            'id'
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

            
            [['num_code', 'alpha_2_code', 'alpha_3_code','en_short_name','ar_short_name','en_nationality','ar_nationality','status'], 'required'],
            [['guid', 'num_code','status'], 'integer'],
            [['guid', 'num_code','status'], 'number'],
            [['ar_nationality','en_nationality','ar_short_name','en_short_name'], 'string', 'max' => 255],
            
            [['num_code', 'alpha_2_code', 'alpha_3_code','en_short_name','ar_short_name','en_nationality','ar_nationality'], 'safe'],
            
          
         

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

            'created_at' => Yii::t('site', 'Created At'),
            'updated_at' => Yii::t('site', 'Updated At'),
            'created_by' => Yii::t('site', 'Created By'),
            'updated_by' => Yii::t('site', 'Updated By'),
            'revision' => Yii::t('site', 'Revision'),

        ];
    }

    /**
     * {@inheritdoc}
     * @return CountriesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CountriesQuery(get_called_class());
    }

    public function getCities(){
        return $this->hasMany(City::className(), ['country_id' => 'id']);
    }

    public function __toString()
    {
        return $this->en_short_name;
    }
}
