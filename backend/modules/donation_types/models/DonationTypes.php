<?php

namespace backend\modules\donation_types\models;

use backend\modules\city\models\City;
use backend\modules\dropdown_list\models\DropdownList;
use bedezign\yii2\audit\AuditTrailBehavior;
use common\helpers\Utility;
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
 * This is the model class for table "donation_types".
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
 * @property BlogsLang[] $newsLangs
 */

class DonationTypes extends ActiveRecord
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
        return 'donation_types';
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
                'langClassName' => DonationTypesLang::className(),
                'tableName' => "{{%donation_types_lang}}",
                'attributes' => [
                    'title','header_image','header_mobile_image','header_image_title'
                    ,'header_image_brief','cms_title'
                ]
            ],
        ];
    }

    public function getLangualAttributes()
    {
        return 
        [                    
            'title','header_image','header_mobile_image','header_image_title'
            ,'header_image_brief','cms_title'
        ];
    }

    public function getIgnoreAttributes()
    {
        return 
        [
            'id','status', 'created_at', 'updated_at', 'revision', 'comment_status',
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
                    'title','slug' ,'published_at','status','weight','image',
                    'object_fit', 'object_position','header_image','header_mobile_image','header_image_title'
                    ,'header_image_brief','guid','image','amount_jod','amount_usd','cms_title'
                ], function ($attribute) 
                {
                    if (preg_match('/<[^b][^r][^>]*>/', $this->$attribute)) {
                        $this->addError($attribute, Yii::t('site', 'HTML is invalid.'));
                    }
                }
            ],
            
            [
                [
                    'title','slug' ,'published_at','status','weight','image',
                    'object_fit', 'object_position','header_image','header_mobile_image','header_image_title'
                    ,'header_image_brief','guid','image','amount_jod','amount_usd','cms_title'
                ], 
                function ($attribute) {
                    $this->$attribute = \yii\helpers\HtmlPurifier::process($this->$attribute);
                }
            ],

      
            [['title','image','guid','amount_usd','amount_jod'], 'required'],
            [['amount_usd','amount_jod'],'number'],
            [['slug'], 'unique'],

            [['weight', 'status', 'revision','changed', 'created_by', 'updated_by'
        ], 'integer'],
            [   
                [
            
                    'slug','cms_title',
                    'title', 'image',
                ], 'string', 'max' => 255
            ],
            [   
                [
                    'header_image',
                    'header_mobile_image', 'header_image_title','header_image_brief'
                ], 'string', 'max' => 500
            ],
            [['object_fit', 'object_position',],'string','max'=>50],
  
            [['created_at', 'updated_at', 'reject_note', 'changed', 'revision'], 'safe'],
            
            ['published_at', 'date', 'timestampAttribute' => 'published_at', 'format' => 'yyyy-MM-dd'],
            ['published_at', 'default', 'value' => time()],

            ['weight', 'default', 'value' => 10],


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
            'slug' => Yii::t('site', 'Slug'),
            'status' => Yii::t('site', 'Status'),
            'published_at' => Yii::t('site', 'Published At'),
            'created_at' => Yii::t('site', 'Created At'),
            'updated_at' => Yii::t('site', 'Updated At'),
            'created_by' => Yii::t('site', 'Created By'),
            'updated_by' => Yii::t('site', 'Updated By'),
            'view' => Yii::t('site', 'View'),
            'layout' => Yii::t('site', 'Layout'),
            'title' => Yii::t('site', 'Title'),


        ];
    }

    /**
     * {@inheritdoc}
     * @return DonationTypesQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DonationTypesQuery(get_called_class());
    }


    public function getDonationTypesLang()
    {
        return $this->hasMany(DonationTypesLang::class, ['parent_id' => 'id']);
    }

    public function getAmount(){
        $currency = Utility::selected_currency('slug');
        if (isset($this->{"amount_" . $currency}))
            return $this->{"amount_" . $currency};
        return number_format($this->amount_jod * 1 / Utility::selected_currency('rate'), 2);
    }
}
