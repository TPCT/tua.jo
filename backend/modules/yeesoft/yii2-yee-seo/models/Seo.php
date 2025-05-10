<?php

namespace yeesoft\seo\models;

use bedezign\yii2\audit\AuditTrailBehavior;
use common\components\ModulesModelComponent;
use common\components\RevisionTrait;
use yeesoft\behaviors\MultilingualBehavior;
use yeesoft\models\OwnerAccess;
use yeesoft\models\User;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yeesoft\db\ActiveRecord;

/**
 * This is the model class for table "seo".
 *
 * @property integer $id
 * @property string $url
 * @property integer $index
 * @property integer $follow
 * @property integer $created_by
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $updated_by
 *
 * @property User $createdBy
 * @property User $updatedBy
 */
class Seo extends ActiveRecord implements OwnerAccess
{

    use ModulesModelComponent;
    use RevisionTrait;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%seo}}';
    }

    public function init()
    {
        parent::init();

        if ($this->isNewRecord && $this->className() == 'yeesoft\seo\models\Seo') {
            $this->index = 1;
            $this->follow = 1;
        }
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [


            [
                [
                'url','title','author','keywords','description','index','follow'
                ], function ($attribute) 
                {
                    if (preg_match('/<[^b][^r][^>]*>/', $this->$attribute)) {
                        $this->addError($attribute, Yii::t('site', 'HTML is invalid.'));
                    }
                }
            ],
            
            [[
                'url','title','author','keywords','description','index','follow'], function ($attribute) {
                $this->$attribute = \yii\helpers\HtmlPurifier::process($this->$attribute);
            }],

            [['url'], 'required'],
            [['index', 'follow', 'created_by', 'created_at', 'updated_at', 'updated_by'], 'integer'],
            [['url', 'title','author'], 'string', 'max' => 255],
            [['keywords', 'description'], 'string', 'max' => 1000],
            [['url'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            AuditTrailBehavior::class,
            TimestampBehavior::className(),
            BlameableBehavior::className(),
            'multilingual' => [
                'class' => MultilingualBehavior::class,
                'langClassName' => SeoLang::class,
                'langForeignKey' => 'parent_id',
                'requireTranslations' => false,
                'tableName' => "{{%seo_lang}}",
                'attributes' => [
                    'title', 'description','author', 'keywords',
                ]
            ],
        ];
    }

    public function getLangualAttributes()
    {
        return 
        [                    
            'title', 'description','author', 'keywords',
        ];
    }

    public function getIgnoreAttributes()
    {
        return 
        [
            'id','status', 'created_at', 'updated_at', 'revision', 'comment_status',
            'published_at','created_by','updated_by','view','layout','revision',
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
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('yee', 'ID'),
            'url' => Yii::t('yee', 'Url'),
            'title' => Yii::t('yee', 'Title'),
            'author' => Yii::t('yee', 'Author'),
            'keywords' => Yii::t('yee/seo', 'Keywords'),
            'description' => Yii::t('yee', 'Description'),
            'index' => Yii::t('yee/seo', 'Index'),
            'follow' => Yii::t('yee/seo', 'Follow'),
            'created_by' => Yii::t('yee', 'Created By'),
            'created_at' => Yii::t('yee', 'Created'),
            'updated_at' => Yii::t('yee', 'Updated'),
            'updated_by' => Yii::t('yee', 'Updated By'),
        ];
    }

    /**
     * {@inheritdoc}
     * @return NewsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SeoQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'created_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUpdatedBy()
    {
        return $this->hasOne(User::className(), ['id' => 'updated_by']);
    }

    /**
     *
     * @inheritdoc
     */
    public static function getFullAccessPermission()
    {
        return 'fullSeoAccess';
    }

    /**
     *
     * @inheritdoc
     */
    public static function getOwnerField()
    {
        return 'created_by';
    }

    public function getCreatedDate()
    {
        return Yii::$app->formatter->asDate(($this->isNewRecord) ? time() : $this->created_at);
    }

    public function getUpdatedDate()
    {
        return Yii::$app->formatter->asDate(($this->isNewRecord) ? time() : $this->updated_at);
    }

    public function getCreatedTime()
    {
        return Yii::$app->formatter->asTime(($this->isNewRecord) ? time() : $this->created_at);
    }

    public function getUpdatedTime()
    {
        return Yii::$app->formatter->asTime(($this->isNewRecord) ? time() : $this->updated_at);
    }

    public function getCreatedDatetime()
    {
        return "{$this->createdDate} {$this->createdTime}";
    }

    public function getUpdatedDatetime()
    {
        return "{$this->updatedDate} {$this->updatedTime}";
    }
}