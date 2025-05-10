<?php

namespace backend\modules\redirect_url\models;

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

/**
 * This is the model class for table "redirect_url".
 *
 * @property int $id
 * @property string $url_from
 * @property string $url_to
 * @property int $status_code_from
 * @property int $status_code_to
 * @property int|null $status 0-pending 1-published
 * @property int|null $published_at
 * @property int|null $created_at
 * @property int|null $updated_at
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property int|null $revision
 * @property int|null $changed
 * @property string|null $reject_note
 *
 * @property User $createdBy
 * @property User $updatedBy
 */

class RedirectUrl extends ActiveRecord
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
        return 'redirect_url';
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

            // 'sluggable' => [
            //     'class' => SluggableBehavior::className(),
            //     'attribute' => 'title',
            //     'ensureUnique' => true,
            // ],

            // 'multilingual' => [
            //     'class' => MultilingualBehavior::className(),
            //     'langForeignKey' => 'parent_id',
            //     'langClassName' => RedirectUrlLang::className(),
            //     'tableName' => "{{%redirect_url_lang}}",
            //     'attributes' => [
            //         'title',
            //     ]
            // ],
        ];
    }

    public function getLangualAttributes()
    {
        return[];
    }

    public function getIgnoreAttributes()
    {
        return
        [
            'id','status', 'created_at', 'updated_at', 'revision', 'comment_status',
            'published_at','created_by','updated_by','view','layout',
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
            [[
                'url_from', 'url_to', 'status_code_from','status_code_to', 'reject_note',
                'created_at', 'updated_at', 'created_by', 'updated_by',], function ($attribute) {
                $this->$attribute = \yii\helpers\HtmlPurifier::process($this->$attribute);
            }],
            [['url_from', 'url_to', 'status_code_from','status_code_to'], 'required'],
            [['url_from'], 'unique'],
            [['status_code_from','status_code_to', 'status', 'revision', 'changed', 'created_by', 'updated_by'], 'integer'],
            [
                [
                    'reject_note',
                    'url_from', 'url_to',
                ], 'string', 'max' => 255
            ],
            [['created_at', 'updated_at', 'reject_note', 'changed', 'revision'], 'safe'],

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
            'status' => Yii::t('site', 'Status'),
            'published_at' => Yii::t('site', 'Published At'),
            'created_at' => Yii::t('site', 'Created At'),
            'updated_at' => Yii::t('site', 'Updated At'),
            'created_by' => Yii::t('site', 'Created By'),
            'updated_by' => Yii::t('site', 'Updated By'),
            'title' => Yii::t('site', 'Title'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return RedirectUrlQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new RedirectUrlQuery(get_called_class());
    }


}
