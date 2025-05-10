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

class DonationProgramParent extends ActiveRecord
{
    use RevisionTrait;
    use ModulesModelComponent;

    public $ItemsList = [];

    const STATUS_PENDING = 0;
    const STATUS_PUBLISHED = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'donation_program_parents';
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
                    'title_en', 'title_ar'
                ], function ($attribute)
                {
                    if (preg_match('/<[^b][^r][^>]*>/', $this->$attribute)) {
                        $this->addError($attribute, Yii::t('site', 'HTML is invalid.'));
                    }
                }
            ],
            
            [
                [
                    'title_en', 'title_ar'
                ],
                function ($attribute) {
                    $this->$attribute = \yii\helpers\HtmlPurifier::process($this->$attribute);
                }
            ],

      
            [['donation_program_id'], 'required'],

            [['donation_program_id'], 'integer'],
            [   
                [
                    'title_en', 'title_ar'
                ], 'string', 'max' => 255
            ],

            [['created_at', 'updated_at'], 'safe'],
            
            ['published_at', 'date', 'timestampAttribute' => 'published_at', 'format' => 'yyyy-MM-dd'],
            ['published_at', 'default', 'value' => time()],

            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']]
        ];
    }

    public function getItems(){
        return $this->hasMany(DonationProgramItem::className(), ['parent_id' => 'id']);
    }

    public function getTitle(){
        return $this->{"title_" . Yii::$app->language};
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('site', 'ID'),
            'status' => Yii::t('site', 'Status'),
            'published_at' => Yii::t('site', 'Published At'),
            'created_at' => Yii::t('site', 'Created At'),
            'updated_at' => Yii::t('site', 'Updated At'),
            'created_by' => Yii::t('site', 'Created By'),
            'updated_by' => Yii::t('site', 'Updated By'),
            'title_en' => Yii::t('site', 'Title EN'),
            'title_ar' => Yii::t('site', 'Title AR'),
            'image' => Yii::t('site', 'Brief'),
            'value' => Yii::t('site', 'Value'),
        ];
    }
}
