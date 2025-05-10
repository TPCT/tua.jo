<?php

namespace backend\modules\annual_report\models;

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
 * This is the model class for table "annual_report".
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
 * @property AnnualReportLang[] $annual_reportLangs
 */

class AnnualReport extends ActiveRecord
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
        return 'annual_report';
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
                'langClassName' => AnnualReportLang::className(),
                'tableName' => "{{%annual_report_lang}}",
                'attributes' => [
                    'title', 'brief', 'content', 'image', 'file'
                    ,'header_image','header_mobile_image','header_image_title','header_image_brief'
                ]
            ],
        ];
    }

    public function getLangualAttributes()
    {
        return 
        [                    
            'title', 'brief', 'content','header_image','header_mobile_image','header_image_title','header_image_brief'
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
//            'category_slug'
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
                    'title','slug' ,'published_at','status','weight',
                    'object_fit', 'object_position','header_image','header_mobile_image','header_image_title'
                    ,'header_image_brief','promoted_to_our_impact'
                ], function ($attribute) 
                {
                    if (preg_match('/<[^b][^r][^>]*>/', $this->$attribute)) {
                        $this->addError($attribute, Yii::t('site', 'HTML is invalid.'));
                    }
                }
            ],
            
            [
                [
                    'title','slug' ,'published_at','status','weight',
                    'object_fit', 'object_position','header_image','header_mobile_image','header_image_title'
                    ,'header_image_brief','promoted_to_our_impact'
                ], 
                function ($attribute) {
                    $this->$attribute = \yii\helpers\HtmlPurifier::process($this->$attribute);
                }
            ],

      
            [['title', 'image', 'file'], 'required'],
            [['slug'], 'unique'],

            [['weight', 'status', 'revision', 'changed', 'created_by', 'updated_by','promoted_to_our_impact'], 'integer'],
            [   
                [
                    'slug',
                    'title', 'image', 'file','category_id'
                ], 'string', 'max' => 255
            ],
            [   
                [
                    'header_image_brief',
                    'header_image_title', 'header_mobile_image', 'header_image'
                ], 'string', 'max' => 500
            ],
            [['object_fit', 'object_position',],'string','max'=>50],
            [['brief'],'string'],
            [['created_at', 'updated_at', 'reject_note', 'changed', 'revision'], 'safe'],
            
            ['published_at', 'date', 'timestampAttribute' => 'published_at', 'format' => 'yyyy-MM-dd'],
            ['published_at', 'default', 'value' => time()],

            ['weight', 'default', 'value' => 10],
            
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
     * @return AnnualReportQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new AnnualReportQuery(get_called_class());
    }

    public static function getAnnualReportList()
    {
        $productBmsCategories = ArrayHelper::map( 
            DropdownList::find()->activeWithCategory(DropdownList::ANNUAL_REPORT)
                                ->joinwith("translations")
                                ->all(), 'id','title');
            return $productBmsCategories;
    }


}
