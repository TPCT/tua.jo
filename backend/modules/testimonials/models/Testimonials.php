<?php

namespace backend\modules\testimonials\models;

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

/**
 * This is the model class for table "testimonials".
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
 * @property TestimonialsLang[] $newsLangs
 */

class Testimonials extends ActiveRecord
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
        return 'testimonial';
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
                'langClassName' => TestimonialsLang::className(),
                'tableName' => "{{%testimonial_lang}}",
                'attributes' => [
                    'title', 'brief'
                ]
            ],
        ];
    }

    public function getLangualAttributes()
    {
        return 
        [                    
            'title', 'brief'
        ];
    }

    public function getIgnoreAttributes()
    {
        return 
        [
            'id','status', 'created_at', 'updated_at', 'revision', 'comment_status',
            'published_at','created_by','updated_by','revision',
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
                    'title','slug' ,'published_at','status','weight','image',
                    'object_fit', 'object_position','video_url'
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
                    'object_fit', 'object_position','video_url'
                ], 
                function ($attribute) {
                    $this->$attribute = \yii\helpers\HtmlPurifier::process($this->$attribute);
                }
            ],

      
            [['title'], 'required'],
            [['slug'], 'unique'],

            [['weight', 'status', 'revision','changed', 'created_by', 'updated_by'], 'integer'],
            [   
                [
            
                    'slug',
                    'title', 'image','video_url'
                ], 'string', 'max' => 255
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
            'view' => Yii::t('site', 'View'),
            'layout' => Yii::t('site', 'Layout'),
            'title' => Yii::t('site', 'Title'),
            'brief' => Yii::t('site', 'Brief'),

        ];
    }

    /**
     * {@inheritdoc}
     * @return TestimonialsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new TestimonialsQuery(get_called_class());
    }


    public function getTestimonialsLang()
    {
        return $this->hasMany(TestimonialsLang::class, ['parent_id' => 'id']);
    }



    


}
