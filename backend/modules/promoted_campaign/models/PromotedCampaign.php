<?php

namespace backend\modules\promoted_campaign\models;

use backend\modules\city\models\City;
use backend\modules\countries\models\Country;
use backend\modules\dropdown_list\models\DropdownList;
use bedezign\yii2\audit\AuditTrailBehavior;
use common\components\behaviors\CustomSluggableBehaviorForArabic;
use common\components\behaviors\CustomSluggableBehaviorForEnglish;
use common\components\behaviors\ReplacementBehavior;
use common\components\behaviors\WebpImageBehavior;
use Yii;
use backend\modules\donation_types\models\DonationTypes;
use backend\modules\campaigns\models\Campaign;
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
use  backend\modules\donation_programs\models\DonationProgramParent;
/**
 * This is the model class for table "PromotedCampaign".
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
class PromotedCampaign extends ActiveRecord
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
        return 'promoted_campaigns';
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
                'langClassName' => PromotedCampaignLang::className(),
                'tableName' => "{{%promoted_campaigns_lang}}",
                'attributes' => [
                    'title', 'brief','button_label','backgroumd_image'
                ]
            ],
        ];
    }

    public function getLangualAttributes()
    {
        return 
        [                    
             'title','brief','button_label'
        ];
    }

    public function getIgnoreAttributes()
    {
        return 
        [
            'id','status', 'created_at', 'updated_at', 'revision',
            'published_at','created_by','updated_by','view','layout','revision',
            'reject_note','changed',

       
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
                   'weight_order', 'slug',   'title', 'brief','button_url','button_label',
                    'status', 'brief', 'published_at','created_at', 'updated_at', 'created_by','backgroumd_image',
                    'updated_by', 'revision', 'changed', 'reject_note','campaign_id','donation_type_id','promoted_to_front','image'
                ], function ($attribute)
                {
                    if (preg_match('/<[^b][^r][^>]*>/', $this->$attribute)) {
                        $this->addError($attribute, Yii::t('site', 'HTML is invalid.'));
                    }
                }
            ],

            [
                [
                    'weight_order', 'slug',   'title', 'brief','button_url','button_label',
                    'status', 'brief', 'published_at','created_at', 'updated_at', 'created_by','backgroumd_image',
                    'updated_by', 'revision', 'changed', 'reject_note','campaign_id','donation_type_id','promoted_to_front','image'
                ], function ($attribute) {
                $this->$attribute = \yii\helpers\HtmlPurifier::process($this->$attribute);
            }],


            [['title','brief','image','donation_type_id'], 'required'],
            [
                [
                    'weight_order','created_by', 'updated_by', 'status', 'revision'
                ], 'integer'
            ],

            [['slug'], 'unique'],
            [
                [
                     'title', 'reject_note'
                ],
                'string', 'max' => 255
            ],

            [['brief'], 'string',],

            [
                [
                    'created_at', 'updated_at'
                ], 'safe'
            ],

            [['weight_order'], 'default', 'value' => 10],

  

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
            'slug' => Yii::t('site', 'Slug'),
            'status' => Yii::t('site', 'Status'),
            'published_at' => Yii::t('site', 'Release Date'),
            'created_at' => Yii::t('site', 'Created At'),
            'updated_at' => Yii::t('site', 'Updated At'),
            'created_by' => Yii::t('site', 'Created By'),
            'updated_by' => Yii::t('site', 'Updated By'),
            'revision' => Yii::t('site', 'Revision'),
            'view' => Yii::t('site', 'View'),
            'weight_order' => Yii::t('site', 'Weight Order'),

        ];
    }


    /**
     * {@inheritdoc}
     * @return PromotedCampaignQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PromotedCampaignQuery(get_called_class());
    }


    public function getDonationType(){
        return $this->hasOne(DonationTypes::className(), ['id' => 'donation_type_id']);
    }

    public function getCampaign(){
        return $this->hasOne(Campaign::className(), ['id' => 'campaign_id']);
    }

    public function getParents(){
        return $this->hasMany(DonationProgramParent::class, ['donation_program_id' => 'id']);
    }

}
