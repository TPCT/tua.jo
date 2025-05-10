<?php

namespace backend\modules\donation_programs\models;

use backend\modules\campaigns\models\Campaign;
use backend\modules\city\models\City;
use backend\modules\donation_types\models\DonationTypes;
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
 * This is the model class for table "donation".
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

class DonationProgram extends ActiveRecord
{
    use RevisionTrait;
    use ModulesModelComponent;

    const STATUS_PENDING = 0;
    const STATUS_PUBLISHED = 1;

    public array $TabsList = [];
    public array $ParentsList = [];

    public array $ItemsList = [];
    public array $FeaturesList = [];
    public array $PromotionsList = [];


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'donation_programs';
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
                'langClassName' => DonationProgramLang::className(),
                'tableName' => "{{%donation_programs_lang}}",
                'attributes' => [
                    'title', 'brief', 'tag', 'campaign_report', 'goal_achieved','image','fatwa_file'
                ]
            ],
        ];
    }

    public function getLangualAttributes()
    {
        return 
        [                    
            'title', 'brief', 'tag','header_image','header_mobile_image','header_image_title'
            ,'header_image_brief','image'
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
                    'title','brief','tag','tag_icon','slug' ,'published_at','status','weight','image','fatwa_file', 'raised', 'goal', 'campaign_report'
                ], function ($attribute) 
                {
                    if (preg_match('/<[^b][^r][^>]*>/', $this->$attribute)) {
                        $this->addError($attribute, Yii::t('site', 'HTML is invalid.'));
                    }
                }
            ],
            
            [
                [
                    'title','brief','tag', 'tag_icon','slug' ,'published_at','status','weight','image','fatwa_file', 'raised', 'goal', 'campaign_report'
                ], 
                function ($attribute) {
                    $this->$attribute = \yii\helpers\HtmlPurifier::process($this->$attribute);
                }
            ],

      
            [['title', 'image', 'color', 'tag', 'tag_icon'], 'required'],
            [['slug'], 'unique'],

            [['has_goal', 'promote_to_payment_page', 'raised', 'goal', 'weight', 'status', 'revision','changed', 'created_by', 'updated_by', 'is_recurring', 'has_amount'], 'integer'],

            [   
                [
                    'slug', 'title', 'brief', 'tag', 'background_color'
                ], 'string', 'max' => 255
            ],
            [   
                [
                    'image', 'tag_icon', 'campaign_report'
                ], 'string', 'max' => 500
            ],
            [['created_at', 'updated_at', 'reject_note', 'changed', 'revision'], 'safe'],
            
            ['published_at', 'date', 'timestampAttribute' => 'published_at', 'format' => 'yyyy-MM-dd'],
            ['published_at', 'default', 'value' => time()],

            ['weight', 'default', 'value' => 10],

            [
                ['goal'], function ($attribute) {
                    if ($this->has_goal == 1 && $this->$attribute <= 0) {
                        $this->addError($attribute, Yii::t('site', 'Goal must be greater than zero when "Has Goal" is checked.'));
                    }
                }
            ],

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
            'promote_to_payment_page' => Yii::t('site', 'Promote To Payment Page'),
            'published_at' => Yii::t('site', 'Published At'),
            'created_at' => Yii::t('site', 'Created At'),
            'updated_at' => Yii::t('site', 'Updated At'),
            'created_by' => Yii::t('site', 'Created By'),
            'updated_by' => Yii::t('site', 'Updated By'),
            'view' => Yii::t('site', 'View'),
            'layout' => Yii::t('site', 'Layout'),
            'title' => Yii::t('site', 'Title'),
            'brief' => Yii::t('site', 'Brief'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return DonationProgramQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DonationProgramQuery(get_called_class());
    }


    public function getDonationLang()
    {
        return $this->hasMany(DonationProgramLang::class, ['parent_id' => 'id']);
    }

    public static function getCampaigns($add_first_empty=true){
        if ($add_first_empty)
            return ArrayHelper::merge(['' => Yii::t('site', 'Select Campaign')], ArrayHelper::map(Campaign::find()->active()->all(),'id','title'));
        return  ArrayHelper::map(Campaign::find()->active()->all(),'id','title');
    }

    public function getTabs(){
        return $this->hasMany(DonationProgramTab::class, ['donation_program_id' => 'id']);
    }

    public function getParents(){
        return $this->hasMany(DonationProgramParent::class, ['donation_program_id' => 'id']);
    }

    public function getItems(){
        return $this->hasMany(DonationProgramItem::class, ['donation_program_id' => 'id']);
    }

    public function getFeatures(){
        return $this->hasMany(DonationProgramFeature::class, ['donation_program_id' => 'id']);
    }

    public function getPromotions(){
        return $this->hasMany(DonationProgramPromotion::class, ['parent_id' => 'id']);
    }

    public static function getDonationTypes($add_first_empty=true){
        if ($add_first_empty)
            return ArrayHelper::merge(['' => Yii::t('site', 'Select Donation Type')], ArrayHelper::map(DonationTypes::find()->all(),'id','title'));
        return ArrayHelper::map(DonationTypes::find()->active()->all(),'id','title');
    }

    public static function getDonationPrograms($except){
        return ArrayHelper::merge([-1 => Yii::t('site', 'Select Donation Promotional Program')], ArrayHelper::map(DonationProgram::find()->active()->andWhere(['!=', 'donation_programs.id', $except])->all(),'id','title'));
    }

    public function getHasParents(){
        $has_parents = true;
        foreach ($this->parents as $parent){
            if (!$parent->title){
                $has_parents = false;
                break;
            }
        }
        return $has_parents;
    }

    public function getProgress(){
        if ($this->has_goal && $this->goal){
            if ($this->raised >= $this->goal)
                return 100;
            return $this->raised / $this->goal * 100;
        }
        return -1;
    }

//    public static function getDonationProgramsTypes()
//    {
//        return [
//            'type_1' => Yii::t('site', 'Type 1'),
//            'type_2' => Yii::t('site', 'Type 2'),
//            'type_3' => Yii::t('site', 'Type 3'),
//            'type_4' => Yii::t('site', 'Type 4'),
//        ];
//    }

}
