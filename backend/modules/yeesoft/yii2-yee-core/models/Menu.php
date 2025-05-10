<?php

namespace yeesoft\models;

use backend\modules\dropdown_list\models\DropdownList;
use bedezign\yii2\audit\AuditTrailBehavior;
use kartik\helpers\Html;
use omgdef\multilingual\MultilingualQuery;
use yeesoft\behaviors\MultilingualBehavior;
use yeesoft\db\ActiveRecord;
use yeesoft\helpers\FA;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use common\components\ModulesModelComponent;
use common\components\RevisionTrait;
use common\helpers\Utility;

/**
 * This is the model class for table "menu".
 *
 * @property string $id
 * @property int $weight
 * @property string $category_slug
 * @property int $created_at
 * @property int $updated_at
 * @property int $created_by
 * @property int $updated_by
 * @property int $revision
 * @property int $changed
 * @property string $reject_note
 *
 * @property User $updatedBy
 * @property User $createdBy
 * @property DropdownList $category
 * @property MenuLang[] $menuLangs
 * @property MenuLink[] $menuLinks
 */
class Menu extends ActiveRecord implements OwnerAccess
{

    use RevisionTrait;
    use ModulesModelComponent;

    const STATUS_PENDING = 0;
    const STATUS_PUBLISHED = 1;

    public static $itemAdditionalClass = [];
    public static $linkClass = [];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            AuditTrailBehavior::className(),
            BlameableBehavior::className(),
            TimestampBehavior::className(),
            'sluggable' => [
                'class' => SluggableBehavior::className(),
                'slugAttribute' => 'id',
                'attribute' => 'title',
            ],
            'multilingual' => [
                'class' => MultilingualBehavior::className(),
                'langForeignKey' => 'menu_id',
                'tableName' => "{{%menu_lang}}",
                'attributes' => [
                    'title'
                ]
            ],
        ];
    }

    public function getLangualAttributes()
    {
        return ['title'];
    }

    public function getIgnoreAttributes()
    {
        return [
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
    public function rules()
    {
        return [
            [['title', 'weight', 'id', 'category_slug', 'status'], function ($attribute) {
                $this->$attribute = \yii\helpers\HtmlPurifier::process($this->$attribute);
            }],

            [
                ['title', 'weight', 'id', 'category_slug', 'status'],
                function ($attribute) 
                {
                    if (preg_match('/<[^b][^r][^>]*>/', $this->$attribute)) {
                        $this->addError($attribute, Yii::t('site', 'HTML is invalid.'));
                    }
                }
            ],
            [['title','category_slug'], 'required'],
            [['id'], 'unique'],
            [['status','weight', 'created_by', 'updated_by', 'created_at', 'updated_at','revision', 'changed'], 'integer'],
            [['id'], 'string', 'max' => 64],
            [['title','category_slug', 'active_header_url', 'reject_note'], 'string', 'max' => 255],

            [['id'], 'match', 'pattern' => '/^[a-z0-9_-]+$/', 'message' => Yii::t('yee', 'Menu ID can only contain lowercase alphanumeric characters, underscores and dashes.')],
            [['category_slug'], 'exist', 'skipOnError' => true, 'targetClass' => DropdownList::className(), 'targetAttribute' => ['category' => 'slug']],
            [['created_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['created_by' => 'id']],
            [['updated_by'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['updated_by' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('yee', 'ID'),
            'title' => Yii::t('yee', 'Title'),
            'created_by' => Yii::t('yee', 'Created By'),
            'updated_by' => Yii::t('yee', 'Updated By'),
            'created_at' => Yii::t('yee', 'Created'),
            'updated_at' => Yii::t('yee', 'Updated'),
            'category_slug' => Yii::t('yee', 'Category'),
        ];
    }

    
    /**
     * getTypeList
     * @return array
     */
    public static function getCategoryList()
    {
        $categories = ArrayHelper::map( 
                        DropdownList::find()
                            ->where(['status'=>DropdownList::STATUS_PUBLISHED])
                            ->andWhere(['category'=>DropdownList::MENU_CATEGORY])
                            ->all(), 'slug','title');
        return $categories;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(DropdownList::className(), ['slug' => 'category_slug']);
    }

    /**
     * @return \omgdef\multilingual\MultilingualQuery
     */
    public function getLinks()
    {
        return $this->hasMany(MenuLink::className(), ['menu_id' => 'id'])->joinWith('translations')->where(['alwaysVisible' => 0]);
    }

    /**
     * get list of menus
     * @return array
     */
    public static function getMenus()
    {
        return ArrayHelper::map(self::find()->joinWith('translations')->orderBy(['weight' => SORT_DESC])->all(), 'id', 'title');
    }

    /**
     * get list of menus
     * @return array
     */
    public static function getMenuItems($menu_id)
    {
        $menus = self::findOne($menu_id);

        if (!$menus) return [];

        $links = $menus->getLinks()
            ->orderBy(['parent_id' => 'ASC', 'order' => 'ASC'])
            ->all();
        if (!$links) return [];

        return self::generateNavigationItems($links);
    }

    private static function generateNavigationItems($links)
    {
        $items = [];
        $linksByParent = [];

        foreach ($links as $link) {
            $linksByParent[$link->parent_id][] = $link;
        }

        foreach ($linksByParent[''] as $link) {
            $items[] = self::generateItem($link, $linksByParent);
        }

//        var_dump($items);

        return $items;
    }

    private static function generateItem($link, $menuLinks)
    {
        $item = [];
        $icon = (!empty($link->admin_icon)) ? FA::icon($link->admin_icon) . ' ' : '';
        $img = (!empty($link->image)) ? Html::img(\common\helpers\Utility::getThumb($link->image)->getThumbUrl('UsefullLinksImg'), ['class' => 'usefull-links-img']) . ' ' : '';

        $subItems = self::generateSubItems($link->id, $menuLinks);

//        $item['label'] = $icon . $img . $link->label;
        $item['label'] = $link->label;
        $item['brief'] = $link->brief;
        $item['image'] = $link->image;
        $item['position'] = $link->position;

        if (isset($link->alwaysVisible) && $link->alwaysVisible) {
            $item['visible'] = true;
        }

        if ($link->link) {
            $url = parse_url($link->link);
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
            $item['url'] = (isset($url['scheme'])) ? $link->link : array_merge([@$url['path']], $query);
        }

        if (is_array($subItems)) {
            $item['items'] = $subItems;
        }

        //Added By Abujoudeh
        $item['linkOptions'] = [];
        if ($link->parent_id == '') {
            $item['options'] = self::$itemAdditionalClass;
            $item['linkOptions'] = self::$linkClass;
        }
        if ($link->additional_attributes) {
            $addOptions = [];
            foreach (explode(',', $link->additional_attributes) as $optionItem) {
                $attrs = explode('|', $optionItem);
                if (is_array($attrs) && count($attrs) == 2) {
                    $item['linkOptions'][$attrs[0]] = $attrs[1];

                    //Add rel="noopener noreferrer" to every link tag with source not in your domain
                    if ($attrs[0] == 'target' && $attrs[1] == '_blank') {
                        $item['linkOptions']['rel'] = 'noopener noreferrer';
                    }
                }
            }

        }
        // Bzour
        if (isset($item['url'])) {
//            $request_url = explode('/', $_SERVER['REQUEST_URI']);
//            $menu_url_arr = explode('/', $item['url'][0]);
//            // $str = basename($item['url'][0]);
//            // Inner Engines
//            if(isset($request_url[2])){
//                @$item['active'] = ($menu_url_arr[1] == $request_url[2]);
//            }
//            // Inner Pages
//            if(isset($menu_url_arr[2]) && isset($request_url[2])) {
//                if($menu_url_arr[2] == $request_url[2])
//                $item['active'] = ($menu_url_arr[2] == $request_url[2]);
//            }
        }

        // \yii\helpers\VarDumper::dump($menuItems ,  $dept = 10,  $highlight = true);
        // die();
//        $item['active'] = (Yii::$app->requestedRoute == @$item['url']);

        //Added By Abujoudeh
//        if($link->parent_id == '')
//            $item['options'] = ['class' => 'bg hover-bg'];
        $item['active'] = self::isItemActive($item);
        return $item;
    }

    private static function isItemActive($item)
    {

        if (isset($item['url']) && is_array($item['url']) && isset($item['url'][0])) {

            $route = $item['url'][0];

            if ($route[0] !== '/' && Yii::$app->controller) {
                $route = Yii::$app->controller->module->getUniqueId() . '/' . $route;
            }


            // Extract the controller ID from both the current route and the item's route
//            $currentController = Yii::$app->controller->id; // e.g., 'speeches'
//            $itemRouteParts = explode('/', ltrim($route, '/'));
//            $itemController = isset($itemRouteParts[0]) ? $itemRouteParts[0] : null;
//
//            // If the controller matches, mark the item as active (even for inner pages like 'speeches/view')
//            if ($itemController === $currentController) {
//                return true;
//            }

            if (ltrim($route, '/') == Yii::$app->controller->getRoute()) {
                return true;
            }
            return false;
        }

        return false;
    }

    private static function generateSubItems($parent_id, $menuLinks)
    {
        if (isset($menuLinks[$parent_id])) {
            $items = [];

            foreach ($menuLinks[$parent_id] as $link) {
                $items[] = self::generateItem($link, $menuLinks);
            }

            return $items;
        }

        return NULL;
    }

    /**
     * @inheritdoc
     * @return MultilingualQuery the active query used by this AR class.
     */
    // public static function find()
    // {
    //     return new MultilingualQuery(get_called_class());
    // }

    /**
     * {@inheritdoc}
     * @return BmsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MenuQuery(get_called_class());
    }


}
