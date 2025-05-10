<?php

namespace backend\modules\bms\models;

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
use backend\modules\bms\models\BmsFeature;
use backend\modules\donation_types\models\DonationTypes;
use backend\modules\campaigns\models\Campaign;
/**
 * This is the model class for table "bms".
 *
 * @property int $id
 * @property string $slug
 * @property int $status 0-pending,1-published
 * @property string $category_slug
 * @property string $icon
 * @property string $url
 * @property string $url_1
 * @property string $url_2
 * @property int $module_id
 * @property string $module_class
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
 * @property string $grid_size
 *
 * @property DropdownList $category
 * @property User $createdBy
 * @property User $updatedBy
 * @property BmsLang[] $bmsLangs
 */

class Bms extends ActiveRecord
{
    use RevisionTrait;
    use ModulesModelComponent;

    public $bmsFeatureList;


    const STATUS_PENDING = 0;
    const STATUS_PUBLISHED = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bms';
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
                'langClassName' => BmsLang::className(),
                'tableName' => "{{%bms_lang}}",
                'attributes' => [
                    'title', 'second_title', 'brief','content',
                    'image', 'mobile_image',
                    'button_text','button_2_text',
                    'button_image_1', 'button_image_2', 
                    'object_fit', 'object_position',
                    
                ]
            ],
        ];
    }

    public function getLangualAttributes()
    {
        return 
        [                    
            'title', 'second_title', 'brief',
            'image', 'mobile_image','content',
            'button_text','button_2_text',
            'button_image_1', 'button_image_2',
            'object_fit', 'object_position',
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
            'category_slug'
        ];
    }

    public function getAdditionalAttributes()
    {
        return ['category'];
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [
                [
                    'object_fit', 'object_position',
                'title','slug','second_title','url','image','mobile_image','button_text','url_1','button_image_1'
                ,'button_image_2','url_2','button_2_text','published_at','category_slug','status','weight','video','icon'
                ,'donation_type_id','campaign_id','our_partner_id'
                ], function ($attribute) 
                {
                    if (preg_match('/<[^b][^r][^>]*>/', $this->$attribute)) {
                        $this->addError($attribute, Yii::t('site', 'HTML is invalid.'));
                    }
                }
            ],
            
            [[
                'object_fit', 'object_position',
                'title','slug','second_title','url','image','mobile_image','button_text','url_1','button_image_1'
                ,'button_image_2','url_2','button_2_text','published_at','donation_type_id','campaign_id','our_partner_id'
                ,'category_slug','status','weight','video','icon'], function ($attribute) {
                $this->$attribute = \yii\helpers\HtmlPurifier::process($this->$attribute);
            }],

      
            [['title', 'category_slug','weight'], 'required'],
            [['slug'], 'unique'],
            [['color'],'string','max'=>30],

            [['weight', 'status', 'module_id', 'revision', 'changed', 'created_by', 'updated_by','our_partner_id'], 'integer'],
            [   
                [
                    'slug', 'category_slug', 'url', 'url_1', 'url_2', 'video',
                    'module_class', 'reject_note', 'view', 'layout',
                    'title',  'image', 'mobile_image',
                    'button_text','button_2_text','button_image_1', 'button_image_2',
                ], 'string', 'max' => 255
            ],
            [['second_title'], 'string', 'max' => 500 ],
            [['grid_size','object_fit', 'object_position',],'string','max'=>50],
            [['icon'],'string','max'=>25],
            [['brief','content'],'string'],
            [['created_at', 'updated_at', 'reject_note', 'changed', 'revision','bmsFeatureList'], 'safe'],
            
            ['published_at', 'date', 'timestampAttribute' => 'published_at', 'format' => 'yyyy-MM-dd'],
            ['published_at', 'default', 'value' => time()],

            ['weight', 'default', 'value' => 10],
            
            [['category_slug'], 'exist', 'skipOnError' => true, 'targetClass' => DropdownList::className(), 'targetAttribute' => ['category_slug' => 'slug']],
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
            'created_at' => Yii::t('site', 'Created At'),
            'updated_at' => Yii::t('site', 'Updated At'),
            'created_by' => Yii::t('site', 'Created By'),
            'updated_by' => Yii::t('site', 'Updated By'),
            'view' => Yii::t('site', 'View'),
            'layout' => Yii::t('site', 'Layout'),
            'image' => Yii::t('site', 'Image'),
            'second_title' => Yii::t('site', 'Second Title'),
            'url' => Yii::t('site', 'URL'),
            'url_1' => Yii::t('site', 'Button 1 URL'),
            'url_2' => Yii::t('site', 'Button 2 URL'),
            'button_text' => Yii::t('site', 'Button 1 Label'),
            'button_2_text' => Yii::t('site', 'Button 2 Label'),
            'category_slug' => Yii::t('site', 'Category'),
            'grid_size' => Yii::t('site', 'Grid Size'),
            'product_class' => Yii::t('site', 'Product Class'),
            'title' => Yii::t('site', 'Title'),
            'brief' => Yii::t('site', 'Brief'),
            'button_image_1' => Yii::t('site', 'Button Image 1'),
            'button_image_2' => Yii::t('site', 'Button Image 2'),
            'mobile_image' => Yii::t("site","Mobile Image"),

        ];
    }

    /**
     * {@inheritdoc}
     * @return BmsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new BmsQuery(get_called_class());
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBmsFeatures()
    {
        return $this->hasMany(BmsFeature::className(), ['bms_id' => 'id']);
    }

    public function getDonationType(){
        return $this->hasOne(DonationTypes::className(), ['id' => 'donation_type_id']);
    }

    public function getCampaign(){
        return $this->hasOne(Campaign::className(), ['id' => 'campaign_id']);
    }


    /**
     * getTypeList
     * @return array
     */
    public static function getCategoryList()
    {
        $bmsCategories = ArrayHelper::map( 
                        DropdownList::find()
                            ->where(['status'=>DropdownList::STATUS_PUBLISHED])
                            ->andWhere(['category'=>DropdownList::BMS_CATEGORY])
                            ->orderBy(['title' => SORT_ASC])
                            ->joinwith("translations")
                            ->all(), 'slug','title');
        return $bmsCategories;
    }
    public static function getOurPartnerList()
    {
        $bmsCategories = ArrayHelper::map( 
                        DropdownList::find()
                            ->where(['status'=>DropdownList::STATUS_PUBLISHED])
                            ->andWhere(['category'=>DropdownList::OUR_PARTNER])
                            ->orderBy(['title' => SORT_ASC])
                            ->joinwith("translations")
                            ->all(), 'id','title');
        return $bmsCategories;
    }
    public function getOurPartnerFrontList()
    {
        $items = DropdownList::find()->active()->andWhere(['category' => DropdownList::OUR_PARTNER])->all();
        return ArrayHelper::map($items, "slug","title");
    }


    public function getOurPartner()
    {
        return $this->hasOne(DropdownList::className(), ['id' => 'our_partner_id']);
    }

    public function getCategory()
    {
        return $this->hasOne(DropdownList::className(), ['slug' => 'category_slug']);
    }

    /**
     * getPageBmsList
     * @return array
     */
    public static function getPageBmsList()
    {
        $productBmsCategories = ArrayHelper::map( 
                        DropdownList::find()->activeWithCategory(DropdownList::PAGE_BMS_CATEGORY)
                                            ->joinwith("translations")
                                            ->all(), 'slug','title');
        return $productBmsCategories;
    }


    public function getUrl()
    {

        $url = parse_url($this->url);
//            var_dump($url);
        //Fix Menu URL, if params exist
        $query = [];
        if (isset($url['query'])) {
            parse_str($url['query'], $query);
        }
        if (isset($url['fragment'])) {
//                $url['path'] = $url['path'] .  '#' . $url['fragment'];
            $query['#'] = $url['fragment'];
        }
//            Fix External Links
//            $item['url'] = (parse_url($link->link, PHP_URL_FRAGMENT)) ? $link->link : array_merge([@$url['path']], $query);
        return (isset($url['scheme'])) ? $this->url : array_merge([@$url['path']], $query);

    }


    public function getUrl_2()
    {
        $url_2 = parse_url($this->url_2);
        if (isset($url_2['fragment'])) {
            $this->url_2 = Yii::$app->request->url_2 . $this->url_2;
        }

        $this->url_2 = Url::to([$this->url_2]);
        if (isset($_GET['language'])) {
            $this->url_2 = preg_replace('/&?language=[^&]*/', '', $this->url_2);
            $this->url_2 = rtrim($this->url_2, '?');
        }

        if (substr($this->url_2, 0, 6) == "/site/") {
            $this->url_2 = '/' . Yii::$app->language . str_ireplace('site/', '', $this->url_2);
        }

        return $this->url_2;
    }


    
}
