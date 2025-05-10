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

class DonationProgramPromotion extends ActiveRecord
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
        return 'donation_programs_promotions';
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
                    'donation_type_id'
                ], function ($attribute)
                {
                    if (preg_match('/<[^b][^r][^>]*>/', $this->$attribute)) {
                        $this->addError($attribute, Yii::t('site', 'HTML is invalid.'));
                    }
                }
            ],
            
            [
                [
                    'donation_type_id'
                ],
                function ($attribute) {
                    $this->$attribute = \yii\helpers\HtmlPurifier::process($this->$attribute);
                }
            ],

            [['parent_id'], 'required'],
            [['donation_program_id', 'parent_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            
            ['published_at', 'date', 'timestampAttribute' => 'published_at', 'format' => 'yyyy-MM-dd'],
            ['published_at', 'default', 'value' => time()],

            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']]
        ];
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
            'donation_program_id' => Yii::t('site', 'Donation Program'),
        ];
    }

    public function getParent(){
        return $this->hasOne(DonationProgram::className(), ['id' => 'parent_id']);
    }

    public function getProgram(){
        return $this->hasOne(DonationProgram::className(), ['id' => 'donation_program_id']);
    }
}
