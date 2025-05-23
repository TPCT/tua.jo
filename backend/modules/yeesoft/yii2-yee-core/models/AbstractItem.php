<?php

namespace yeesoft\models;

use yeesoft\helpers\AuthHelper;
use Yii;
use yii\behaviors\TimestampBehavior;
use yeesoft\db\ActiveRecord;
use yii\helpers\Inflector;
use yii\rbac\DbManager;

/**
 * @property integer $type
 * @property string $name
 * @property string $description
 * @property string $group_code
 * @property string $rule_name
 * @property string $data
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property AuthItemGroup $group
 */
abstract class AbstractItem extends ActiveRecord
{

    const TYPE_ROLE = 1;
    const TYPE_PERMISSION = 2;
    const TYPE_ROUTE = 3;

    /**
     * Reassigned in child classes to type role, permission or route
     */
    const ITEM_TYPE = 0;

    /**
     * Useful helper for migrations and other stuff
     * If description is null than it will be transformed like "editUserEmail" => "Edit user email"
     *
     * @param string $name
     * @param null|string $description
     * @param null|string $groupCode
     * @param null|string $ruleName
     * @param null|string $data
     *
     * @return static
     */
    public static function create($name, $description = null, $groupCode = null, $ruleName = null, $data = null)
    {
        $item = new static;

        $item->type = static::ITEM_TYPE;
        $item->name = $name;
        $item->description = ($description === null AND static::ITEM_TYPE != static::TYPE_ROUTE) ? Inflector::titleize($name) : $description;
        $item->rule_name = $ruleName;
        $item->group_code = $groupCode;
        $item->data = $data;

        $item->save();

        return $item;
    }

    /**
     * Helper for adding children to role or permission
     *
     * @param string $parentName
     * @param array|string $childrenNames
     * @param bool $throwException
     *
     * @throws \Exception
     */
    public static function addChildren($parentName, $childrenNames, $throwException = false)
    {
        $parent = (object) ['name' => $parentName];

        $childrenNames = (array) $childrenNames;

        $dbManager = new DbManager();

        foreach ($childrenNames as $childName) {
            $child = (object) ['name' => $childName];

            try {
                $dbManager->addChild($parent, $child);
            } catch (\Exception $e) {
                if ($throwException) {
                    throw $e;
                }
            }
        }

        AuthHelper::invalidatePermissions();
    }

    /**
     * @param string $parentName
     * @param array|string $childrenNames
     */
    public static function removeChildren($parentName, $childrenNames)
    {
        $childrenNames = (array) $childrenNames;

        foreach ($childrenNames as $childName) {
            Yii::$app->db->createCommand()
                    ->delete(Yii::$app->yee->auth_item_child_table, ['parent' => $parentName, 'child' => $childName])
                    ->execute();
        }

        AuthHelper::invalidatePermissions();
    }

    /**
     * @param mixed $condition
     *
     * @return bool
     */
    public static function deleteIfExists($condition)
    {
        $model = static::findOne($condition);

        if ($model) {
            $model->delete();

            return true;
        }

        return false;
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return Yii::$app->yee->auth_item_table;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [
                [
                'description','name'
                ], function ($attribute) 
                {
                    if (preg_match('/<[^b][^r][^>]*>/', $this->$attribute)) {
                        $this->addError($attribute, Yii::t('site', 'HTML is invalid.'));
                    }
                }
            ],
            
            [[
                'description','name'], function ($attribute) {
                $this->$attribute = \yii\helpers\HtmlPurifier::process($this->$attribute);
            }],



            [['name', 'rule_name', 'description', 'group_code','module','action'], 'trim'],
            ['description', 'required', 'on' => 'webInputPermission'],
            ['action', 'required', 'on' => 'webInputRoute'],
            [['description', 'module', 'action'], 'string', 'max' => 255],
            ['name', 'required'],
            ['name', 'validateUniqueName'],
            [['name', 'rule_name', 'group_code'], 'string', 'max' => 64],
            [['rule_name', 'description', 'group_code', 'data'], 'default', 'value' => null],
            ['type', 'integer'],
            ['type', 'in', 'range' => [static::TYPE_ROLE, static::TYPE_PERMISSION, static::TYPE_ROUTE]],
        ];
    }

    /**
     * Default unique validator search only within specific class (Role, Route or Permission) because of the overwritten find() method
     */
    public function validateUniqueName($attribute)
    {
        if (Role::find()->where(['name' => $this->name])->exists()) {
            $this->addError('name', Yii::t('yii', '{attribute} "{value}" has already been taken.', [
                        'attribute' => $this->getAttributeLabel($attribute),
                        'value' => $this->$attribute,
            ]));
        }
    }

    /**
     * @inheritdoc
     * @return ActiveQuery the newly created [[ActiveQuery]] instance.
     */
    public static function find()
    {
        return parent::find()->andWhere([Yii::$app->yee->auth_item_table . '.type' => static::ITEM_TYPE]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => Yii::t('yee', 'Code'),
            'description' => Yii::t('yee', 'Role'),
            'rule_name' => Yii::t('yee', 'Rule'),
            'group_code' => Yii::t('yee', 'Group'),
            'data' => Yii::t('yee', 'Data'),
            'type' => Yii::t('yee', 'Type'),
            'created_at' => Yii::t('yee', 'Created'),
            'updated_at' => Yii::t('yee', 'Updated'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGroup()
    {
        return $this->hasOne(AuthItemGroup::className(), ['code' => 'group_code']);
    }

    /**
     * Ensure type of item
     *
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        $this->type = static::ITEM_TYPE;

        return parent::beforeSave($insert);
    }

    /**
     * Invalidate permissions if some item is deleted
     */
    public function afterDelete()
    {
        parent::afterDelete();

        AuthHelper::invalidatePermissions();
    }

}
