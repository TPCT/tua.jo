<?php

namespace backend\modules\beneficiaries_countries\models;

use backend\modules\dropdown_list\models\DropdownList;
use bedezign\yii2\audit\AuditTrailBehavior;
use yeesoft\behaviors\MultilingualBehavior;
use yeesoft\db\ActiveRecord;
use yeesoft\models\User;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use common\components\ModulesModelComponent;
use common\components\RevisionTrait;

/**
 * This is the model class for table "beneficiaries_countries".
 *
 * @property int $id
 * @property string $slug
 * @property string $image
 * @property int $status 0-pending,1-published
 * @property int $published_at
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int $revision
 * @property int $changed
 * @property string $reject_note
 * @property string $view
 * @property string $layout
 *
 * @property User $createdBy
 * @property User $updatedBy
 * @property BeneficiariesCountries[] $beneficiaries_countries
 */

class BeneficiariesCountries extends ActiveRecord
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
        return 'beneficiaries_countries';
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
            'sluggable' => [
                'class' => SluggableBehavior::className(),
                'attribute' => 'title',
                'ensureUnique' => true,
            ],
     
            'multilingual' => [
                'class' => MultilingualBehavior::className(),
                'langForeignKey' => 'parent_id',
                'langClassName' => BeneficiariesCountriesLang::className(),
                'tableName' => "{{%beneficiaries_countries_lang}}",
                'attributes' => [
                    'title', 'brief'
                ]
            ],
        ];
    }

    public function getLangualAttributes()
    {
        return 
        [                    
            'title', 'brief'
        ];
    }

    public function getIgnoreAttributes()
    {
        return 
        [
            'id','status', 'created_at', 'updated_at',
            'published_at','created_by','updated_by','revision',
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
        return [
            [
                [
                    'title','brief','name','img' ,'published_at','status','slug'
                
                ], function ($attribute) 
                {
                    if (preg_match('/<[^b][^r][^>]*>/', $this->$attribute)) {
                        $this->addError($attribute, Yii::t('site', 'HTML is invalid.'));
                    }
                }
            ],
            
            [
                [
                    'title','brief','name','img' ,'published_at','status','slug'
                ], 
                function ($attribute) {
                    $this->$attribute = \yii\helpers\HtmlPurifier::process($this->$attribute);
                }
            ],

      
            [['title', 'brief', 'name'], 'required'],


            [[ 'status', 'revision', 'changed', 'created_by', 'updated_by'], 'integer'],
            [   
                [
            
                    'title','name','img','slug'
                ], 'string', 'max' => 255
            ],

            [['brief'],'string'],
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

            'status' => Yii::t('site', 'Status'),
            'published_at' => Yii::t('site', 'Published At'),
            'created_at' => Yii::t('site', 'Created At'),
            'updated_at' => Yii::t('site', 'Updated At'),
            'created_by' => Yii::t('site', 'Created By'),
            'updated_by' => Yii::t('site', 'Updated By'),
            'category_id' => Yii::t('site', 'category'),
            'view' => Yii::t('site', 'View'),
            'layout' => Yii::t('site', 'Layout'),
            'title' => Yii::t('site', 'Title'),
            'content' => Yii::t('site', 'Content'),
            'promoted_to_our_impact' => Yii::t('site', 'PROMOTED_TO_OUR_IMPACT'),
            'brief' => Yii::t('site', 'Brief'),

        ];
    }

    /**
     * {@inheritdoc}
     * @return BeneficiariesCountriesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BeneficiariesCountriesQuery(get_called_class());
    }



}
