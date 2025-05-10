<?php

namespace backend\modules\news\models;

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
 * This is the model class for table "news".
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
 * @property NewsLang[] $newsLangs
 * @property User $updatedBy
 */
class News extends ActiveRecord
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
        return 'news';
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
                'langClassName' => NewsLang::className(),
                'tableName' => "{{%news_lang}}",
                'attributes' => [
                    'title', 'brief', 'content','header_image','header_mobile_image','header_image_title'
                    ,'header_image_brief','image'
                ]
            ],
        ];
    }

    public function getLangualAttributes()
    {
        return 
        [                    
           'title', 'content', 'brief','image'
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
            'category_id',
        ];
    }

    public function getAdditionalAttributes()
    {
        return ['category'];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'image', 'category_id', 'weight_order',
                    'slug',  'title',
                    'status', 'brief', 'object_fit', 'object_position',
                    'published_at','created_at', 'updated_at', 'created_by',
                    'updated_by', 'revision', 'changed', 'reject_note','donation_type_id','campaign_id'
                ], function ($attribute)
                {
                    if (preg_match('/<[^b][^r][^>]*>/', $this->$attribute)) {
                        $this->addError($attribute, Yii::t('site', 'HTML is invalid.'));
                    }
                }
            ],

            [
                [
                    'image', 'category_id', 'weight_order',
                    'slug',  'title',
                    'status', 'brief', 'object_fit', 'object_position',
                    'published_at','created_at', 'updated_at', 'created_by',
                    'updated_by', 'revision', 'changed', 'reject_note','donation_type_id','campaign_id'
                ], function ($attribute) {
                $this->$attribute = \yii\helpers\HtmlPurifier::process($this->$attribute);
            }],


            [
                [
                  'category_id', 'weight_order',
                    'created_by', 'updated_by', 'status', 'revision','donation_type_id','campaign_id'
                ], 'integer'
            ],

            [['slug'], 'unique'],
            [
                [
                    'slug', 'status', 'title', 'image',
                    'reject_note',
                ],
                'string', 'max' => 255
            ],
            [['object_fit', 'object_position',],'string','max'=>50],
            [['brief', 'content'], 'string',],

            [
                [
                    'created_at', 'updated_at',
                    'default',
                ], 'safe'
            ],

            [['weight_order'], 'default', 'value' => 10],


            ['published_at', 'date', 'timestampAttribute' => 'published_at', 'format' => 'yyyy-MM-dd'],
            ['published_at', 'default', 'value' => time()],

            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => DropdownList::class, 'targetAttribute' => ['category_id' => 'id']],
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
            'weight_order' => Yii::t('site', 'Weight Order'),
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
     * @return NewsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NewsQuery(get_called_class());
    }

    public function getDonationType(){
        return $this->hasOne(DonationTypes::className(), ['id' => 'donation_type_id']);
    }

    public function getCampaign(){
        return $this->hasOne(Campaign::className(), ['id' => 'campaign_id']);
    }



    public function getCategory()
    {
        return $this->hasOne(DropdownList::class,['id' => 'category_id'])
                    ->joinWith("translations")
                    ->onCondition([
                                    DropdownList::tableName().'.status' => DropdownList::STATUS_PUBLISHED, 
                                    'category' => DropdownList::NEWS_CATEGORY,
                                ]);
    }



    public function getCountry()
    {
        return $this->hasOne(Country::class, ['id' => 'country_id']);
    }

    public function getCountryList()
    {
        $items = Country::find()->all();
        return ArrayHelper::map($items,"id","title");
    }

    public function getCategoryList()
    {
        $items = DropdownList::find()->active()->andWhere(['category' => DropdownList::NEWS_CATEGORY])->all();
        return ArrayHelper::map($items, "id","title");
    }

    public static function getYearsList()
    {
        $items = self::find()->active()
                    ->select(['year' => 'concat(YEAR(FROM_UNIXTIME(published_at)))'])
                    ->groupBy('year')
                    ->asArray()
                    ->all();
        return ArrayHelper::map($items, 'year', 'year');
    }


}
