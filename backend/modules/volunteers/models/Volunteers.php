<?php

namespace backend\modules\volunteers\models;

use backend\modules\city\models\City;
use backend\modules\countries\models\Country;
use backend\modules\dropdown_list\models\DropdownList;
use bedezign\yii2\audit\AuditTrailBehavior;
use common\components\behaviors\CustomSluggableBehaviorForArabic;
use common\components\behaviors\CustomSluggableBehaviorForEnglish;
use common\components\behaviors\ReplacementBehavior;
use common\components\behaviors\WebpImageBehavior;
use Yii;
use common\components\ModulesModelComponent;
use common\components\RevisionTrait;
use developit\slug\PesianSluggableBehavior;
use yeesoft\behaviors\MultilingualBehavior;
use yeesoft\db\ActiveRecord;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yeesoft\models\User;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;
use backend\modules\donation_types\models\DonationTypes;
use backend\modules\campaigns\models\Campaign;
/**
 * This is the model class for table "volunteers".
 *
 * @property int $id
 * @property string|null $image
 * @property int|null $published_at
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int $revision
 * @property int $changed
 * @property string|null $reject_note
 *
 * @property User $createdBy
 * @property volunteer_langLang[] $volunteer_langLangs
 * @property User $updatedBy
 */
class Volunteers extends ActiveRecord
{
    use ModulesModelComponent;
    use RevisionTrait;


    const STATUS_PENDING = 0;
    const STATUS_PUBLISHED = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'volunteer';
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
                'langClassName' => VolunteersLang::className(),
                'tableName' => "{{%volunteer_lang}}",
                'attributes' => [
                    'title', 'brief', 'content','header_image','header_mobile_image','header_image_title'
                    ,'header_image_brief','file','file_label'
                ]
            ],
        ];
    }

    public function getLangualAttributes()
    {
        return 
        [                    
           'title', 'content', 'brief','file'
        ];
    }

    public function getIgnoreAttributes()
    {
        return 
        [
            'id','status', 'created_at', 'updated_at', 'revision', 
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
        return [
            [
                [
                    'image', 'weight',
                    'slug', 'promoted_to_volunteer',  'title',
                    'status', 'brief', 'object_fit', 'object_position',
                    'published_at','created_at', 'updated_at', 'created_by',
                    'updated_by', 'revision', 'changed', 'reject_note','file','donation_type_id','campaign_id'
                ], function ($attribute)
                {
                    if (preg_match('/<[^b][^r][^>]*>/', $this->$attribute)) {
                        $this->addError($attribute, Yii::t('site', 'HTML is invalid.'));
                    }
                }
            ],

            [
                [
                    'image', 'weight',
                    'slug', 'promoted_to_volunteer',  'title',
                    'status', 'brief', 'object_fit', 'object_position',
                    'published_at','created_at', 'updated_at', 'created_by',
                    'updated_by', 'revision', 'changed', 'reject_note','file','donation_type_id','campaign_id'
                ], function ($attribute) {
                $this->$attribute = \yii\helpers\HtmlPurifier::process($this->$attribute);
            }],


            [
                [
                     'promoted_to_volunteer', 'weight',
                    'created_by', 'updated_by', 'status', 'revision','donation_type_id','campaign_id'
                ], 'integer'
            ],

            [['slug'], 'unique'],
            [
                [
                    'slug', 'status', 'title', 'image',
                    'reject_note','file','file_label'
                ],
                'string', 'max' => 255
            ],
            [['object_fit', 'object_position',],'string','max'=>50],
            [['brief', 'content',], 'string',],

            [
                [
                    'created_at', 'updated_at','default',
                ], 'safe'
            ],

            [['weight'], 'default', 'value' => 10],


            ['published_at', 'date', 'timestampAttribute' => 'published_at', 'format' => 'yyyy-MM-dd'],
            ['published_at', 'default', 'value' => time()],

            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
            ['sitemap_priority', 'number', 'max' => 1, 'min' => 0],
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
            'comment_status' => Yii::t('site', 'Comment Status'),
            'published_at' => Yii::t('site', 'Release Date'),
            'created_at' => Yii::t('site', 'Created At'),
            'updated_at' => Yii::t('site', 'Updated At'),
            'created_by' => Yii::t('site', 'Created By'),
            'updated_by' => Yii::t('site', 'Updated By'),
            'revision' => Yii::t('site', 'Revision'),
            'view' => Yii::t('site', 'View'),
            'weight' => Yii::t('site', 'Weight Order'),
            'image' => Yii::t('site', 'Image'),
            'image_brief' => Yii::t('site', 'Image Brief'),
            'author_ids' => Yii::t('site', 'Authors'),
            'region_id' => Yii::t('site', 'Region'),
            'country_id' => Yii::t('site', 'Country'),
            'image_header' => Yii::t('site', 'Header Image'),
            'image_campaign' => Yii::t('site', 'Campaign Image'),
            'start_date' => Yii::t('site', 'Start Campaign Date'),
            'end_date' => Yii::t('site', 'End Campaign Date'),

        ];
    }


    /**
     * {@inheritdoc}
     * @return VolunteersQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new VolunteersQuery(get_called_class());
    }
    public function getDonationType(){
        return $this->hasOne(DonationTypes::className(), ['id' => 'donation_type_id']);
    }

    public function getCampaign(){
        return $this->hasOne(Campaign::className(), ['id' => 'campaign_id']);
    }


}
