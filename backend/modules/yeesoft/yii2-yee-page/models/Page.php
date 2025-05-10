<?php

namespace yeesoft\page\models;

use backend\modules\bms\models\Bms;
use backend\modules\city\models\City;
use backend\modules\countries\models\Country;
use backend\modules\dropdown_list\models\DropdownList;
use bedezign\yii2\audit\AuditTrailBehavior;
use common\components\ModulesModelComponent;
use common\components\RevisionTrait;
use yeesoft\behaviors\MultilingualBehavior;
use yeesoft\db\ActiveRecord;
use yeesoft\models\OwnerAccess;
use yeesoft\models\User;
use yeesoft\seo\components\SeoModelBehavior;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;

/**
 * This is the model class for table "page".
 *
 * @property int $id
 * @property string $slug
 * @property int $status 0-pending,1-published
 * @property int $bms_category_id
 * @property int $published_at
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property string $view
 * @property string $layout
 * @property int $revision
 * @property int $changed
 * @property float $sitemap_priority
 * @property string $reject_note
 *
 * @property User $createdBy
 * @property User $updatedBy
 * @property DropdownList $bmsCategory
 * @property PageAccordion[] $pageAccordions
 * @property PageLang[] $pageLangs
 * @property PageSection[] $pageSections
 */

class Page extends ActiveRecord implements OwnerAccess
{
    use RevisionTrait;
    use ModulesModelComponent;

    const STATUS_PENDING = 0;
    const STATUS_PUBLISHED = 1;

    public $accordionList;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'page';
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
                'langForeignKey' => 'page_id',
                'langClassName' => PageLang::className(),
                'tableName' => "{{%page_lang}}",
                'attributes' => [
                    'title', 'content', 'brief', 'image',
                    'keywords', 'footer_content', 'second_title',
                    'header_image', 'header_image_title', 'header_image_brief',
                ]
            ],
            'SeoModel' => [
                'class' => SeoModelBehavior::className(),
                'meta' => [
                    'title' => 'title',
                    'description' => 'brief',
                    'keywords' => 'keywords',
                ]

            ],
        ];
    }

    public function getLangualAttributes()
    {
        return 
        [                    
            'title','second_title','content', 'brief', 'image', 
            'keywords', 'footer_content',
            'header_image','header_image_title',
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
            'bms_category_id','accordionList',
        ];
    }

    public function getAdditionalAttributes()
    {
        return ['bmsCategory'];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'title','slug', 'brief', 'keywords','video','city_id','country_id','second_title', 
                    'header_image', 'header_image_title','header_image_brief','published_at','status','view','layout','image'
                ], function ($attribute) 
                {
                    if (preg_match('/<[^b][^r][^>]*>/', $this->$attribute)) {
                        $this->addError($attribute, Yii::t('site', 'HTML is invalid.'));
                    }
                }
            ],
            [
                [
                    'title','slug', 'brief', 'keywords','video', 'city_id','country_id','second_title',
                    'header_image', 'header_image_title','header_image_brief','published_at','status','view','layout','image'
                ], function ($attribute) 
                {
                    $this->$attribute = \yii\helpers\HtmlPurifier::process($this->$attribute);
                }
            ],
            [['title'], 'required'],
            
            [
                [
                    'title', 'slug', 'image', 'keywords', 
                    'header_image','header_image_title','header_image_brief',
                    'video','second_title',
                    'view', 'layout', 'reject_note'
                ],  'string', 'max' => 255
            ],
            [[ 'content', 'footer_content', 'brief',], 'string'],
            ['slug', 'unique'],
            [
                ['status','created_by', 'updated_by', 'changed' ,'country_id','city_id'], 'integer'
            ],
            [['created_at', 'updated_at', 'reject_note', 'changed', 'revision'], 'safe'],

            ['published_at', 'date', 'timestampAttribute' => 'published_at', 'format' => 'yyyy-MM-dd'],
            ['published_at', 'default', 'value' => time()],
            ['sitemap_priority', 'number', 'max' => 1, 'min' => 0],

            [['bms_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => DropdownList::className(), 'targetAttribute' => ['bms_category_id' => 'id']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('yee', 'ID'),
            'created_by' => Yii::t('yee', 'Author'),
            'updated_by' => Yii::t('yee', 'Updated By'),
            'slug' => Yii::t('yee', 'Slug'),
            'title' => Yii::t('yee', 'Title'),
            'status' => Yii::t('yee', 'Status'),
            'content' => Yii::t('yee', 'Content'),
            'published_at' => Yii::t('yee', 'Published'),
            'created_at' => Yii::t('yee', 'Created'),
            'updated_at' => Yii::t('yee', 'Updated'),
            'revision' => Yii::t('yee', 'Revision'),
            'view' => Yii::t('yee', 'View'),
            'video' => Yii::t('yee', 'Video | Audio'),
            'layout' => Yii::t('yee', 'Layout'),
            'image_header' => Yii::t('yee', 'Image Header'),
            'bms_category_id' => Yii::t("site","Bms"),
            
        ];
    }


    /**
     * @inheritdoc
     * @return PageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PageQuery(get_called_class());
    }


    public function save($runValidation = true, $attributeNames = null)
    {
        // To insure replace all spaces if user add the slug
        $this->slug = Inflector::slug($this->slug);

        \Yii::$app->cache->flush();
        return parent::save($runValidation, $attributeNames);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccordions()
    {
        return $this->hasMany(PageAccordion::className(), ['page_id' => 'id']);
    }


    public static function getBmsCategoryList()
    {
        $bmses = DropdownList::find()->active()->andWhere(["category"=>DropdownList::BMS_CATEGORY])->all();
        return ArrayHelper::map($bmses,"id","title");
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBmsCategory()
    {
        return $this->hasOne(DropdownList::className(), ['id' => 'bms_category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBmses()
    {
        return $this->hasMany(Bms::className(), ['category' => 'slug'])->viaTable( "dropdown_list", ['id' => 'bms_category_id'])
                    ->orderBy(['weight' => SORT_ASC]);
    }


    public function getFirstSections()
    {
        return $this->hasMany(Bms::class, ['module_id' => 'id'])->onCondition([
            "module_class"=>self::class, 
            "category_slug"=>"first-section",
            "status" => true,
        ])
        ->orderBy(['weight' => SORT_ASC]);
    }

    public function getSecondSections()
    {
        return $this->hasMany(Bms::class, ['module_id' => 'id'])->onCondition([
            "module_class"=>self::class, 
            "category_slug"=>"second-section",
            "status" => true,
        ])
        ->orderBy(['weight' => SORT_ASC]);
    }

    public function getThirdSections()
    {
        return $this->hasMany(Bms::class, ['module_id' => 'id'])->onCondition([
            "module_class"=>self::class, 
            "category_slug"=>"third-section",
            "status" => true,
        ])
        ->orderBy(['weight' => SORT_ASC]);
    }

    public function getFourthSections()
    {
        return $this->hasMany(Bms::class, ['module_id' => 'id'])->onCondition([
            "module_class"=>self::class, 
            "category_slug"=>"fourth-section",
            "status" => true,
        ])
        ->orderBy(['weight' => SORT_ASC]);
    }

    public function getCity()
    {
        return $this->hasOne(City::class, ['id' => 'city_id']);
    }
    public function getCountry()
    {
        return $this->hasOne(Country::class, ['id' => 'country_id']);
    }


}
