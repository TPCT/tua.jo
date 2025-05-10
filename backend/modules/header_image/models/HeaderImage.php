<?php

namespace backend\modules\header_image\models;

use bedezign\yii2\audit\AuditTrailBehavior;
use common\components\ModulesModelComponent;
use yeesoft\behaviors\MultilingualBehavior;
use yeesoft\db\ActiveRecord;
use yeesoft\models\User;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
/**
 * This is the model class for table "news".
 *
 * @property int $id
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property string $path
 * @property string $image
 * @property string $mobile_image
 */
class HeaderImage extends ActiveRecord
{
    public $headerImageList;

    use ModulesModelComponent;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'header_image';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            AuditTrailBehavior::class,
            TimestampBehavior::class,
            BlameableBehavior::class,
            'multilingual' => [
                'class' => MultilingualBehavior::class,
                'langClassName' => HeaderImageLang::class,
                'requireTranslations' => false,
                'langForeignKey' => 'parent_id',
                'tableName' => "{{%header_image_lang}}",
                'attributes' => [
                    'title',  'brief', 'button_text', 'button_url', 'image', 'mobile_image'
                ]
            ],
        ];
    }

    public function getLangualAttributes()
    {
        return ['title', 'brief', 'button_text', 'button_url', 'image'];
    }

    public function getIgnoreAttributes()
    {
        return [
                    'id','status', 'created_at', 'updated_at', 'revision', 'comment_status',
                    'created_by','updated_by','layout','revision',
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
                    'title', 'path', 'image','brief', 'mobile_image',
                    'button_text', 'button_url','view'
                ], function ($attribute) 
                {
                    if (preg_match('/<[^b][^r][^>]*>/', $this->$attribute)) {
                        $this->addError($attribute, Yii::t('site', 'HTML is invalid.'));
                    }
                }
            ],

            [
                [
                    'title', 'path', 'image','brief', 'mobile_image',
                    'button_text', 'button_url','view'
                ], 
                function ($attribute) 
                {
                    $this->$attribute = \yii\helpers\HtmlPurifier::process($this->$attribute);
                }
            ],

            [['created_by', 'updated_by'], 'integer'],
            [
                [
                    'title', 'path', 'image','brief', 'mobile_image',
                    'button_text', 'button_url','view',
                ], 'string', 'max' => 255
            ],
            [['created_at', 'updated_at','view'], 'safe'],

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


        ];
    }

    /**
     * {@inheritdoc}
     * @return HeaderImageQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new HeaderImageQuery(get_called_class());
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHeaderimageFeatures()
    {
        return $this->hasMany(HeaderImageFeatures::className(), ['header_image_id' => 'id']);

    }

    public function hasHeaderimageFeatures()
    {
        return $this->getHeaderimageFeatures()->exists();
    }

}
