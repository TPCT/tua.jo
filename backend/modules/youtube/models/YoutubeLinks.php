<?php

namespace backend\modules\youtube\models;

use backend\modules\dropdown_list\models\DropdownList;
use bedezign\yii2\audit\AuditTrailBehavior;
use common\models\User;
use yeesoft\behaviors\MultilingualBehavior;
use yeesoft\db\ActiveRecord;
use yeesoft\media\models\Album;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use common\components\ModulesModelComponent;
use common\components\RevisionTrait;

/**
 * This is the model class for table "youtube_links".
 *
 * @property int $id
 * @property string $slug
 * @property int $album_id
 * @property int $status
 * @property int $type 1-media  2-youtube
 * @property string $cover_image
 * @property int $published_at
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int $revision
 * @property int $changed
 * @property string $reject_note
 *
 * @property DropdownList $album
 * @property User $createdBy
 * @property User $updatedBy
 * @property YoutubeLinksLang[] $youtubeLinksLangs
 */
class YoutubeLinks extends ActiveRecord
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
        return 'youtube_links';
    }


    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'sluggable' => [
                'class' => SluggableBehavior::className(),
                'attribute' => 'title',
            ],
            'AuditTrail' => [
                'class' => AuditTrailBehavior::className(),
            ],
            TimestampBehavior::className(),
            BlameableBehavior::className(),
            'multilingual' => [
                'class' => MultilingualBehavior::className(),
                'langForeignKey' => 'parent_id',
                'langClassName' => YoutubeLinksLang::className(),
                'tableName' => "{{%youtube_links_lang}}",
                'attributes' => [
                    'title', 'brief', 'media_path', 'promote_to_front', 
                    'header_image', 'header_image_title',
                ]
            ],

        ];
    }

    public function getLangualAttributes()
    {
        return 
        [                    
            'title', 'brief', 'media_path',  'promote_to_front', 
            'header_image', 'header_image_title',
        ];
    }

    public function getIgnoreAttributes()
    {
        return 
        [
            'id','status', 'created_at', 'updated_at', 'revision', 'comment_status',
            'published_at','created_by','updated_by','view','layout','revision',
            'reject_note','changed'

            //relational will be ignore and putl relational at additional
            , 'album_id'
        ];
    }

    public function getAdditionalAttributes()
    {
        return [ 'album'];
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return 
        [

            [
                [
                    'title','slug','media_path','cover_image','published_at','album_id',
                    'promote_to_front', 'status', 'object_fit', 'object_position','video_url'
                ], function ($attribute) 
                {
                    if (preg_match('/<[^b][^r][^>]*>/', $this->$attribute)) {
                        $this->addError($attribute, Yii::t('site', 'HTML is invalid.'));
                    }
                }
            ],
            
            [
                [
                    'title','slug','media_path','cover_image','published_at','album_id',
                    'promote_to_front', 'status', 'object_fit', 'object_position','video_url'
                    ], function ($attribute) {
                    $this->$attribute = \yii\helpers\HtmlPurifier::process($this->$attribute);
                }
            ],


            [['title', 'album_id','video_url' ], 'required'],
            [
                [
                    'album_id', 'status', 'promote_to_front',                 
                    'created_at', 'updated_at', 'created_by',
                    'updated_by', 'revision', 'changed'
                ], 'integer'
            ],
            [
                [
                    'title', 'cover_image', 'media_path',
                    'slug', 'cover_image',
                    'reject_note'
                ], 'string', 'max' => 255
            ],
            
            [['object_fit', 'object_position',],'string','max'=>50],

            [['brief'], 'string'],
            [['slug'], 'unique'],

            ['published_at', 'date', 'timestampAttribute' => 'published_at', 'format' => 'yyyy-MM-dd'],
            ['published_at', 'default', 'value' => time()],
        
            [['album_id'], 'exist', 'skipOnError' => true, 'targetClass' => DropdownList::className(), 'targetAttribute' => ['album_id' => 'id']],
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
            'created_at' => Yii::t('site', 'Created At'),
            'updated_at' => Yii::t('site', 'Updated At'),
            'created_by' => Yii::t('site', 'Created By'),
            'updated_by' => Yii::t('site', 'Updated By'),
            'album_id' => Yii::t('site', 'Album'),

        ];
    }


    /**
     * {@inheritdoc}
     * @return YoutubeLinksQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new YoutubeLinksQuery(get_called_class());
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlbum()
    {
        return $this->hasOne(DropdownList::className(), ['id' => 'album_id']);
    }

    public static function getAlbumList()
    {
        $items = DropdownList::find()->activeWithCategory(DropdownList::VIDEO_ALBUM)->all();

        return ArrayHelper::map($items, 'id', 'title');

    }   
    


    public static function getYearList()
    {
        $years = self::find()->active()->select(['year' => 'YEAR(FROM_UNIXTIME(published_at))'])->orderBy(['year' => SORT_DESC])->groupBy('year')->asArray()->all();
        return ArrayHelper::map($years,"year","year");
    }


}
