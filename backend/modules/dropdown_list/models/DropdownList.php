<?php

namespace backend\modules\dropdown_list\models;

use backend\modules\faq\models\Faq;
use backend\modules\media_gallery\models\MediaGallery;
use backend\modules\news\models\News;
use backend\modules\our_team\models\OurTeam;
use backend\modules\youtube\models\YoutubeLinks;
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
use common\helpers\Utility;
use yii\helpers\ArrayHelper;
use backend\modules\donation_types\models\DonationTypes;
use backend\modules\campaigns\models\Campaign;
/**
 * This is the model class for table "dropdown_list".
 *
 * @property int $id
 * @property string $slug
 * @property int $status 0-pending,1-published
 * @property string $category
 * @property int $parent_id
 * @property string $color
 * @property string $view
 * @property int $published_at
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int $revision
 * @property int $changed
 * @property string $reject_note
 *
 * @property DownloadableFile[] $downloadableFile
 * @property Bms[] $bms
 * @property BranchService[] $branchServices
 * @property ContactUsWebform[] $contactUsWebforms
 * @property User $createdBy
 * @property User $updatedBy
 * @property DropdownListLang[] $dropdownListLangs
 * @property MediaGallery[] $mediaGalleries
 * @property Menu[] $menus
 * @property News[] $news
 * @property YoutubeLinks[] $youtubeLinks
 */

class DropdownList extends ActiveRecord
{
    use RevisionTrait;
    use ModulesModelComponent;

    const STATUS_PENDING = 0;
    const STATUS_PUBLISHED = 1;

    const HAVE_SUB_CATEGORY = [];



    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'dropdown_list';
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
                //                'immutable' => true,
            ],
            'multilingual' => [
                'class' => MultilingualBehavior::className(),
                'langForeignKey' => 'parent_id',
                'langClassName' => DropdownListLang::className(),
                'tableName' => "{{%dropdown_list_lang}}",
                'attributes' => [
                    'title',
                    'brief',
                    'image',
                    'pdf_file',
                    'content',
                    'promote_to_front',
                    'object_fit', 'object_position'


                    ,'header_image','header_mobile_image','header_image_title'
                    ,'header_image_brief','button_image_2','button_image_1'
                    ,'button_2_text','button_text'
                

                    
                ]
            ],
        ];
    }

    public function getLangualAttributes()
    {
        return ['title', 'brief', 'image', 'content', 'promote_to_front','object_fit', 'object_position'  ,'header_image','header_mobile_image','header_image_title'
        ,'header_image_brief'];
    }

    public function getIgnoreAttributes()
    {
        return [
            'id',
            'status',
            'created_at',
            'updated_at',
            'revision',
            'comment_status',
            'published_at',
            'created_by',
            'updated_by',
            'layout',
            'revision',
            'reject_note',
            'changed',

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
                    'title',
                    'slug',
                    'brief',
                    'image',
                    'published_at',
                    'category',
                    'status',
                    'weight',
                    'color',
                    'promote_to_front',
                    'object_fit', 'object_position','pdf_file',
                    'url_2','url_1','button_image_2','button_image_1'
                    ,'button_2_text','button_text' ,'donation_type_id','campaign_id'
                ],
                function ($attribute) {
                    if (preg_match('/<[^b][^r][^>]*>/', $this->$attribute)) {
                        $this->addError($attribute, Yii::t('site', 'HTML is invalid.'));
                    }
                }
            ],

            [
                [
                    'title',
                    'slug',
                    'brief',
                    'image',
                    'published_at',
                    'category',
                    'status',
                    'weight',
                    'color',
                    'promote_to_front',
                    'object_fit', 'object_position','pdf_file'
                    ,'header_image','header_mobile_image','header_image_title'
                    ,'header_image_brief',
                    'url_2','url_1','button_image_2','button_image_1'
                    ,'button_2_text','button_text' ,'donation_type_id','campaign_id'
                ],
                function ($attribute) {
                    $this->$attribute = \yii\helpers\HtmlPurifier::process($this->$attribute);
                }
            ],



            [['title', 'category'], 'required'],
            [['weight', 'promote_to_front', 'status', 'parent_id', 'created_by', 'updated_by', 'revision', 'changed' ,'donation_type_id','campaign_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [[/*'slug',*/ 'title', 'category', 'image' ,'pdf_file' , 'color', 'reject_note', 'view','api_id'
            ,'url_2','url_1','button_image_2','button_image_1','button_2_text','button_text'
            ], 'string', 'max' => 255],
            [['object_fit', 'object_position',],'string','max'=>50],
            //[['slug'], 'unique'],
            [['content', 'brief',], 'string'],

            ['published_at', 'date', 'timestampAttribute' => 'published_at', 'format' => 'yyyy-MM-dd'],
            ['published_at', 'default', 'value' => time()],

            [
                ['parent_id'],
                'required',
                'when' => function ($model) {
                    if (in_array($model->category, self::HAVE_SUB_CATEGORY)) {
                        return true;
                    }
                },
                'whenClient' => "function (attribute, value) {
                if(RELATED_FEATURE.includes( $('#dropdownlist-category').val() )){
                    return true;
                }
            }"
            ],

            // [['view'],'required', 'when' => function ($model) {
            //     if($model->category == self::OUR_TEAM_CATEGORY)
            //     {return true;}
            // },'whenClient' => "function (attribute, value) {
            //     if( $('#dropdownlist-category').val() == 'Our Team Category' ){
            //         return true;
            //     }
            // }"],

            ['weight', 'default', 'value' => 10],


            [   
                [
                    'header_image',
                    'header_mobile_image', 'header_image_title','header_image_brief'
                ], 'string', 'max' => 500
            ],
            [['category'], 'in', 'range' => array_keys($this->getCategoryList()), 'allowArray' => false],
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
            'published_at' => Yii::t('site', 'Published At'),
            'created_at' => Yii::t('site', 'Created At'),
            'updated_at' => Yii::t('site', 'Updated At'),
            'created_by' => Yii::t('site', 'Created By'),
            'updated_by' => Yii::t('site', 'Updated By'),
            'parent_id' => Yii::t("site", "Parent"),

        ];
    }


    /**
     * {@inheritdoc}
     * @return DropdownListQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DropdownListQuery(get_called_class());
    }



    const MENU_CATEGORY = 'Menu Category';

    const MEDIA_CATEGORY = 'Media Gallery';
    const VIDEO_ALBUM = "Video Album";
    const BMS_CATEGORY = "Bms Category";
    const PAGE_BMS_CATEGORY = "Page Bms Category";
    const NEWS_CATEGORY = "News Category";
    const FAQ_CATEGORY = "Faqs Category";
    const ZAKAT_CATEGORY = "Zakat Category";
    const EMPOWERMENT_PRODUCTS = "Empowerment Products ";
    const OFFER_TENDERS_CATEGORY = "Offer Tenders Category";
    const BLOGS_CATEGORY = "Blogs Category";
    const ANNUAL_REPORT = "Annual Report";
    const OUR_PARTNER = "Our Partner";

    const PURPOSE_OF_CONTACT = "Purpose Of Contact";

    const COMPLAINT_METHOD = "Contact Method";
    const MESSAGE_TYPE = "Message Type";
    const DONATION_TOOLS = "Donation Tools";

    const PROTECTION_CONTACT_WEBFORM = "Protection contact Webform";

    const VOLUNTEER_OCCUPATION_TYPE = "Volunteer Occupation Type Webform";
    const HEAR_ABOUT_VOLUNTEER = "Hear Abuot Volunteer Webform";

    const DONATION_CAMPAIN_REASON = "Donation Campain Reason";


    const MediaOutlet_List = "MediaOutlet_List";

    const QUESTION_ONE = "QUESTION_ONE";
    const QUESTION_TWO = "QUESTION_TWO";
    const QUESTION_THREE = "QUESTION_THEER";
    const QUESTION_FIVE = "QUESTION_FIVE";
    const QUESTION_SIX = "QUESTION_SIX";
    const QUESTION_SEVEN = "QUESTION_SEVEN";

    /**
     * getTypeList
     * @return array
     */
    public static function getCategoryList()
    {
        return
            [
                self::MENU_CATEGORY => Yii::t("site", "Menu Category"),
                self::MEDIA_CATEGORY => Yii::t("site", "Media Gallery"),
                self::VIDEO_ALBUM => Yii::t("site", "Video Album"),
                self::BMS_CATEGORY => Yii::t("site", "Bms Category"),
                
                self::PAGE_BMS_CATEGORY => Yii::t("site", "Page Bms Category"),

                self::NEWS_CATEGORY => Yii::t("site", "News Category"),
                self::FAQ_CATEGORY => Yii::t("site", "Faqs Category"),
                self::ZAKAT_CATEGORY => Yii::t("site", "Zakat Category"),
                self::EMPOWERMENT_PRODUCTS => Yii::t("site", "Empowerment Products"),
                self::OFFER_TENDERS_CATEGORY => Yii::t("site", "Offer Tenders Category"),
                self::BLOGS_CATEGORY => Yii::t("site", "Blogs Category"),
                self::ANNUAL_REPORT => Yii::t("site", "Annual Report"),
                self::OUR_PARTNER => Yii::t("site", "Our Partner"),
                
                self::DONATION_TOOLS => Yii::t("site", "Donation Tools"),

                self::MESSAGE_TYPE => Yii::t("site", "Complaint Message Type"),

                self::COMPLAINT_METHOD => Yii::t("site", "Complaint Method"),

                self::PROTECTION_CONTACT_WEBFORM => Yii::t("site", "Protection Webform"),

                self::VOLUNTEER_OCCUPATION_TYPE => Yii::t("site", "Volunteer Occupation Type Webform"),
                self::HEAR_ABOUT_VOLUNTEER => Yii::t("site", "Hear Abuot Volunteer Webform"),

                self::PURPOSE_OF_CONTACT => Yii::t("site", "Purpose Of Contact"),

                self::QUESTION_ONE => Yii::t("site", "Question One"),
                self::QUESTION_TWO => Yii::t("site", "Question TwO"),
                self::QUESTION_THREE => Yii::t("site", "Question Three"),
                self::QUESTION_FIVE => Yii::t("site", "Question Five"),
                self::QUESTION_SIX => Yii::t("site", "Question Six"),
                self::QUESTION_SEVEN => Yii::t("site", "Question Seven"),

 
                self::DONATION_CAMPAIN_REASON => Yii::t("site", "Donation Campain Reason"),
                
                self::MediaOutlet_List => Yii::t("site", "MediaOutlet List"),


            ];
    }



    public static function getParentCategory($category)
    {
        switch ($category) {
        }
    }

    public static function getSubCategoryList($category)
    {
        return ArrayHelper::map(DropdownList::find()->active()->andWhere(['category' => DropdownList::getParentCategory($category)])->all(), 'id', 'title');
    }

    public function getDonationToolList()
    {
        $items = DropdownList::find()->active()->andWhere(['category' => DropdownList::DONATION_TOOLS])->all();
        return ArrayHelper::map($items, "slug","title");
    }

    public function getMediaGalleries()
    {
        return $this->hasMany(MediaGallery::class, ['category_id' => 'id'])
            ->joinWith("translations")
            ->onCondition([MediaGallery::tableName() . '.status' => Utility::STATUS_PUBLISHED])
            ->orderBy(['published_at' => SORT_DESC]);

    }
    public function getVideoGalleries()
    {
        return $this->hasMany(DropdownList::class, ['parent_id' => 'id'])
            ->joinWith("translations")
            ->onCondition([DropdownList::tableName() . '.status' => Utility::STATUS_PUBLISHED, DropdownList::tableName() . ".category" => self::VIDEO_ALBUM])

            ->orderBy(['published_at' => SORT_DESC]);

    }

    public function getFaqs()
    {
        return $this->hasMany(Faq::class, ['category_id' => 'id']);
    }

    public function getDonationType(){
        return $this->hasOne(DonationTypes::className(), ['id' => 'donation_type_id']);
    }

    public function getCampaign(){
        return $this->hasOne(Campaign::className(), ['id' => 'campaign_id']);
    }




}
