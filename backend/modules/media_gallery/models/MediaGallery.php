<?php

namespace backend\modules\media_gallery\models;

use backend\modules\dropdown_list\models\DropdownList;
use bedezign\yii2\audit\AuditTrailBehavior;
use yeesoft\behaviors\MultilingualBehavior;
use yeesoft\db\ActiveRecord;
use yeesoft\media\models\Media;
use yeesoft\models\User;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use common\components\ModulesModelComponent;
use common\components\RevisionTrait;
use common\helpers\Utility;
use yeesoft\media\models\MediaUpload;

/**
 * This is the model class for table "media_gallery".
 *
 * @property int $id
 * @property string $slug
 * @property int $status 0-pending,1-published
 * @property int $category_id
 * @property string $image
 * @property int $comment_status 0-closed,1-open
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
 * @property DropdownList $category
 * @property User $createdBy
 * @property User $updatedBy
 * @property MediaGalleryLang[] $mediaGalleryLangs
 */

class MediaGallery extends ActiveRecord
{

    use ModulesModelComponent;
    use RevisionTrait;

    const STATUS_PENDING = 0;
    const STATUS_PUBLISHED = 1;
    public $multiple_files;



    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'media_gallery';
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
                'tableName' => "{{%media_gallery_lang}}",
                'attributes' => [
                    'title', 'brief', 'header_image', 'header_image_title',
                    'header_image_object_fit', 'header_image_object_position'
                ]
            ],
        ];
    }

    public function getLangualAttributes()
    {
        return 
        [                    
            'title', 'brief', 'header_image', 'header_image_title',
            'header_image_object_fit', 'header_image_object_position'
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
            'category_id',
        ];
    }

    public function getAdditionalAttributes()
    {
        return ['category','allFiles'];
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            
   
            [
                [
                'title','slug','brief','image','header_image','header_image_title','multiple_files','category_id','published_at'
                ,'status','weight',
                'object_fit', 'object_position',
                'header_image_object_fit', 'header_image_object_position', 'promote_to_front'
                ], function ($attribute) 
                {
                    if (preg_match('/<[^b][^r][^>]*>/', $this->$attribute)) {
                        $this->addError($attribute, Yii::t('site', 'HTML is invalid.'));
                    }
                }
            ],
            
            [
                [
                    'title','slug','brief','image','header_image','header_image_title','multiple_files','category_id','published_at'
                    ,'status','weight',
                    'object_fit', 'object_position',
                    'header_image_object_fit', 'header_image_object_position', 'promote_to_front'
                ], function ($attribute) 
                {
                    $this->$attribute = \yii\helpers\HtmlPurifier::process($this->$attribute);
                }
            ],





            [['title', 'image', 'category_id'], 'required'],
            [
                [
                    'title', 'slug', 'brief', 'image', 'view', 'layout',
                    'header_image', 'header_image_title',
                    'reject_note', 'view', 'layout', 'multiple_files'
                ], 'string', 'max' => 255
            ],
            [
                [
                    'object_fit', 'object_position', 
                    'header_image_object_fit', 'header_image_object_position'
                ],'string','max'=>50
            ],
            [['slug'], 'unique'],
            [
                [
                    'weight', 'category_id', 'status',
                    'created_by', 'updated_by', 'comment_status', 
                    'revision', 'changed', 'promote_to_front'
                ], 'integer'
            ],
            [['created_at', 'updated_at'], 'safe'],            

            ['published_at', 'date', 'timestampAttribute' => 'published_at', 'format' => 'yyyy-MM-dd'],
            ['published_at', 'default', 'value' => time()],

            ['weight', 'default', 'value' => 10],

            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => DropdownList::className(), 'targetAttribute' => ['category_id' => 'id']],
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
            'published_at' => Yii::t('site', 'Published At'),
            'created_by' => Yii::t('site', 'Created By'),
            'updated_by' => Yii::t('site', 'Updated By'),
            'revision' => Yii::t('site', 'Revision'),
            'view' => Yii::t('site', 'View'),
            'layout' => Yii::t('site', 'Layout'),
            'image' => Yii::t('site', 'Cover Image'),
            'header_image' => Yii::t('site', 'Second Cover Image'),
            'category_id' => Yii::t('site','Category'),
            'title' => Yii::t('site','Title'),
            'brief' => Yii::t('site','Brief'),
            'created_at' => Yii::t('site', 'Created At'),
            'updated_at' => Yii::t('site', 'Updated At'),
            
        ];
    }

    /**
     * {@inheritdoc}
     * @return MediaGalleryQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MediaGalleryQuery(get_called_class());
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAllFiles()
    {
        return $this->hasMany(MediaUpload::className(), ['owner_id' => 'id'])->andWhere(['owner_class' => self::className()]);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFiles()
    {
        return $this->hasMany(MediaUpload::className(), ['owner_id' => 'id'])->andWhere(['owner_class' => self::className(), 'language' => Yii::$app->language]);
    }

    


    /**
     * getTypeList
     * @return array
     */
    public static function getCategoryList()
    {

        $Categories = ArrayHelper::map( 
                        DropdownList::find()->active()
                            ->andWhere(['category'=>DropdownList::MEDIA_CATEGORY])
                            ->all(), 'id','title');
        return $Categories;
    }

    public function getCategory()
    {
        return $this->hasOne(DropdownList::className(),['id'=>'category_id'])
            ->onCondition(["status"=>DropdownList::STATUS_PUBLISHED]);
    }


    /**
     * @return Media
     */
    public function getMediaRefObj($fieldName)
    {
        $imgRefObj = Media::findOne(['url' => $this->$fieldName]);

        return $imgRefObj;
    }


    public static function getYearList()
    {
        $years = MediaGallery::find()->active()->select(['year' => 'YEAR(FROM_UNIXTIME(published_at))'])->orderBy(['year' => SORT_DESC])->groupBy('year')->asArray()->all();
        return ArrayHelper::map($years,"year","year");
    }
    

}
