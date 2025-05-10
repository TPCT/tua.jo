<?php

namespace backend\modules\campaigns\models;

use backend\modules\donation_types\models\DonationTypes;
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
 * This is the model class for table "campaigns".
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
 */

class Campaign extends ActiveRecord
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
        return 'campaigns';
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
                'langClassName' => CampaignLang::className(),
                'tableName' => "{{%campaigns_lang}}",
                'attributes' => [
                    'title', 'image', 'reason','header_image','header_mobile_image','header_image_title'
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
                    'title','slug','published_at','status','weight','image',
                    'object_fit', 'object_position','header_image','header_mobile_image','header_image_title'
                    ,'header_image_brief','guid', 'reason', 'donation_type_id', 'start_date', 'end_date', 'estimated_amount','cms_title'
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
                    ,'header_image_brief','guid', 'reason', 'donation_type_id', 'start_date', 'end_date', 'estimated_amount','cms_title'
                ], 
                function ($attribute) {
                    $this->$attribute = \yii\helpers\HtmlPurifier::process($this->$attribute);
                }
            ],

      
            [['title','guid', 'donation_type_id'], 'required'],
            [['slug'], 'unique'],

            [['weight', 'status', 'revision','changed', 'created_by', 'updated_by'
        ], 'integer'],
            [   
                [
            
                    'slug',
                    'title', 'image','cms_title'
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

            [['donation_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => DonationTypes::className(), 'targetAttribute' => ['donation_type_id' => 'id']],
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
            'title' => Yii::t('site', 'Title')
        ];
    }

    /**
     * {@inheritdoc}
     * @return CampaignQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CampaignQuery(get_called_class());
    }

    public function getDonationType(){
        return $this->hasOne(DonationTypes::className(), ['id' => 'donation_type_id']);
    }

    public function getAmount(){
        $currency = Utility::selected_currency('slug');
        if (isset($this->donationType->{"amount_" . $currency}))
            return $this->donationType->{"amount_" . $currency};
        return $this->donationType->amount_jod * 1 / Utility::selected_currency('rate');
    }


    public function getCampaignLang()
    {
        return $this->hasMany(CampaignLang::class, ['parent_id' => 'id']);
    }

    public function getDonationTypeList()
    {
        $items = DonationTypes::find()->active()->all();
        return ArrayHelper::map($items, "id","title");
    }

}
