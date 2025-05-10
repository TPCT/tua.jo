<?php

namespace backend\modules\faq\models;

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

/**
 * This is the model class for table "faq".
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
class Faq extends ActiveRecord
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
        return 'faq';
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
                'langClassName' => FaqLang::className(),
                'tableName' => "{{%faq_lang}}",
                'attributes' => [
                    'title', 'brief', 'content'
                ]
            ],
        ];
    }

    public function getLangualAttributes()
    {
        return 
        [                    
             'title', 'content','brief',
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
                   'weight_order', 'slug',   'title', 'brief',
                    'status', 'brief', 'published_at','created_at', 'updated_at', 'created_by',
                    'updated_by', 'revision', 'changed', 'reject_note','promote_to_zakat'
                ], function ($attribute)
                {
                    if (preg_match('/<[^b][^r][^>]*>/', $this->$attribute)) {
                        $this->addError($attribute, Yii::t('site', 'HTML is invalid.'));
                    }
                }
            ],

            [
                [
                    'weight_order', 'slug',   'title', 'brief',
                    'status', 'brief', 'published_at','created_at', 'updated_at', 'created_by',
                    'updated_by', 'revision', 'changed', 'reject_note','promote_to_zakat'
                ], function ($attribute) {
                $this->$attribute = \yii\helpers\HtmlPurifier::process($this->$attribute);
            }],


            [['title','content'], 'required'],
            [
                [
                   'category_id', 'weight_order','created_by', 'updated_by', 'status', 'revision','promote_to_zakat'
                ], 'integer'
            ],

            [['slug'], 'unique'],
            [
                [
                     'title', 'reject_note'
                ],
                'string', 'max' => 255
            ],

            [['brief', 'content'], 'string',],

            [
                [
                    'created_at', 'updated_at'
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
     * @return FaqQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new FaqQuery(get_called_class());
    }

    public function getCategory()
    {
        return $this->hasOne(DropdownList::class,['id' => 'category_id'])
                    ->joinWith("translations")
                    ->onCondition([
                                    DropdownList::tableName().'.status' => DropdownList::STATUS_PUBLISHED, 
                                    'category' => DropdownList::FAQ_CATEGORY,
                                ]);
    }

    public function getCategoryList()
    {
        $items = DropdownList::find()->active()->andWhere(['category' => DropdownList::FAQ_CATEGORY])->all();
        return ArrayHelper::map($items, "id","title");
    }




}
