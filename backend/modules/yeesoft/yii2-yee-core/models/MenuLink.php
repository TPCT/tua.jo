<?php

namespace yeesoft\models;

use bedezign\yii2\audit\AuditTrailBehavior;
use omgdef\multilingual\MultilingualQuery;
use yeesoft\behaviors\MultilingualBehavior;
use yeesoft\db\ActiveRecord;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "menu_link".
 *
 * @property string $id
 * @property string $menu_id
 * @property string $link
 * @property string $label
 * @property string $parent_id
 * @property integer $alwaysVisible
 * @property string $image
 * @property string $admin_icon
 * @property string $brief
 * @property integer $order
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $updated_by
 *
 * @property Menu $menu
 */
class MenuLink extends ActiveRecord implements OwnerAccess
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%menu_link}}';
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
                'attribute' => 'label',
            ],
            'multilingual' => [
                'class' => MultilingualBehavior::className(),
                'langForeignKey' => 'link_id',
                'tableName' => "{{%menu_link_lang}}",
                'attributes' => [
                    'label', 'brief'
                ]
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['label', 'brief', 'id', 'link', 'image','menu_id','admin_icon','position','additional_attributes','alwaysVisible'], function ($attribute) {
                $this->$attribute = \yii\helpers\HtmlPurifier::process($this->$attribute);
            }],

            [
                ['label', 'brief', 'id', 'link', 'image','menu_id','admin_icon','position','additional_attributes','alwaysVisible'],
                function ($attribute) 
                {
                    if (preg_match('/<[^b][^r][^>]*>/', $this->$attribute)) {
                        $this->addError($attribute, Yii::t('site', 'HTML is invalid.'));
                    }
                }
            ],




            [['menu_id', 'label'], 'required'],
            ['id', 'unique'],
            [['order', 'alwaysVisible', 'created_by', 'updated_by', 'created_at', 'updated_at', 'position','is_prime','is_break'], 'integer'],
            [['id', 'menu_id', 'parent_id'], 'string', 'max' => 64],
            [['link', 'label', 'additional_attributes', 'brief','menu_color'], 'string', 'max' => 255],
            [['image', 'admin_icon'], 'string', 'max' => 128],
            [['id'], 'match', 'pattern' => '/^[a-z0-9_-]+$/', 'message' => Yii::t('yee', 'Link ID can only contain lowercase alphanumeric characters, underscores and dashes.')],
            ['order', 'default', 'value' => 999],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('yee', 'ID'),
            'menu_id' => Yii::t('yee', 'Menu'),
            'link' => Yii::t('yee', 'Link'),
            'label' => Yii::t('yee', 'Label'),
            'brief' => Yii::t('yee', 'Brief'),
            'parent_id' => Yii::t('yee', 'Parent Link'),
            'alwaysVisible' => Yii::t('yee', 'In Active'),
            'admin_icon' => Yii::t('yee', 'Admin Icon'),
            'image' => Yii::t('yee', 'Image'),
            'order' => Yii::t('yee', 'Order'),
            'created_by' => Yii::t('yee', 'Created By'),
            'updated_by' => Yii::t('yee', 'Updated By'),
            'created_at' => Yii::t('yee', 'Created'),
            'updated_at' => Yii::t('yee', 'Updated'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenu()
    {
        return $this->hasOne(Menu::className(), ['id' => 'menu_id'])->joinWith('translations');
    }

    /**
     * Get list of link siblings
     * @return array
     */
    public function getSiblings()
    {
        $siblings = MenuLink::find()->joinWith('translations')
                ->andFilterWhere(['like', 'menu_id', $this->menu_id])
                ->andFilterWhere(['!=', 'menu_link.id', $this->id])
                ->all();

        $list = ArrayHelper::map(
                        $siblings, 'id', function ($array, $default) {
                    return $array->label . ' [' . $array->id . ']';
                });

        return ArrayHelper::merge([NULL => Yii::t('yee', 'No Parent')], $list);
    }

    /**
     * @inheritdoc
     * @return MultilingualQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new MultilingualQuery(get_called_class());
    }

    /**
     *
     * @inheritdoc
     */
    public static function getFullAccessPermission()
    {
        return 'fullMenuLinkAccess';
    }

    /**
     *
     * @inheritdoc
     */
    public static function getOwnerField()
    {
        return 'created_by';
    }


    public function getChilds()
    {
        return $this->hasMany(MenuLink::className(), ['parent_id' => 'id'])
                    ->joinWith("translations")
                    ->andOnCondition(["alwaysVisible"=>0])
                    ->orderBy(['order' => 'ASC']);
    }

}
