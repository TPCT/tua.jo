<?php

namespace backend\modules\blogs\models;

use backend\modules\city\models\City;
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
use backend\modules\donation_types\models\DonationTypes;
use backend\modules\campaigns\models\Campaign;
/**
 * This is the model class for table "blogs".
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

class Blogs extends ActiveRecord
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
        return 'blogs';
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
                'langClassName' => BlogsLang::className(),
                'tableName' => "{{%blogs_lang}}",
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
            'title', 'brief', 'content','header_image','header_mobile_image','header_image_title'
            ,'header_image_brief'
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
                    'title','slug','category_id' ,'published_at','status','weight','image',
                    'object_fit', 'object_position','header_image','header_mobile_image','header_image_title'
                    ,'header_image_brief','donation_type_id','campaign_id'
                ], function ($attribute) 
                {
                    if (preg_match('/<[^b][^r][^>]*>/', $this->$attribute)) {
                        $this->addError($attribute, Yii::t('site', 'HTML is invalid.'));
                    }
                }
            ],
            
            [
                [
                    'title','slug','category_id' ,'published_at','status','weight','image',
                    'object_fit', 'object_position','header_image','header_mobile_image','header_image_title'
                    ,'header_image_brief','donation_type_id','campaign_id'
                ], 
                function ($attribute) {
                    $this->$attribute = \yii\helpers\HtmlPurifier::process($this->$attribute);
                }
            ],

      
            [['title', 'content', 'image'], 'required'],
            [['slug'], 'unique'],

            [['weight', 'status', 'revision', 'category_id','changed', 'created_by', 'updated_by'], 'integer'],
            [   
                [
            
                    'slug',
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
            [['brief'],'string'],
            [['created_at', 'updated_at', 'reject_note', 'changed', 'revision'], 'safe'],
            
            ['published_at', 'date', 'timestampAttribute' => 'published_at', 'format' => 'yyyy-MM-dd'],
            ['published_at', 'default', 'value' => time()],

            ['weight', 'default', 'value' => 10],

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
            'published_at' => Yii::t('site', 'Published At'),
            'created_at' => Yii::t('site', 'Created At'),
            'updated_at' => Yii::t('site', 'Updated At'),
            'created_by' => Yii::t('site', 'Created By'),
            'updated_by' => Yii::t('site', 'Updated By'),
            'view' => Yii::t('site', 'View'),
            'layout' => Yii::t('site', 'Layout'),
            'title' => Yii::t('site', 'Title'),
            'content' => Yii::t('site', 'Content'),
            'brief' => Yii::t('site', 'Brief'),

        ];
    }

    /**
     * {@inheritdoc}
     * @return BlogsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BlogsQuery(get_called_class());
    }

    public function getDonationType(){
        return $this->hasOne(DonationTypes::className(), ['id' => 'donation_type_id']);
    }

    public function getCampaign(){
        return $this->hasOne(Campaign::className(), ['id' => 'campaign_id']);
    }



    public function getBlogsLang()
    {
        return $this->hasMany(BlogsLang::class, ['parent_id' => 'id']);
    }


    public function getCategory()
    {
        return $this->hasOne(DropdownList::class,['id' => 'category_id'])
                    ->joinWith("translations")
                    ->onCondition([
                                    DropdownList::tableName().'.status' => DropdownList::STATUS_PUBLISHED, 
                                    'category' => DropdownList::BLOGS_CATEGORY,
                                ]);
    }

    
    public function getCategoryList()
    {
        $items = DropdownList::find()->active()->andWhere(['category' => DropdownList::BLOGS_CATEGORY])->all();
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
