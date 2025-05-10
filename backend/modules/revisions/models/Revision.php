<?php

namespace backend\modules\revisions\models;

use bedezign\yii2\audit\AuditTrailBehavior;
use common\models\User;
use Yii;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "revision".
 *
 * @property int $id
 * @property string $model
 * @property string $module_key
 * @property int $created_by
 * @property int $updated_by
 * @property int $created_at
 * @property int $updated_at
 *
 * @property User $createdBy
 * @property User $updatedBy
 */
class Revision extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'revision';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return 
        [
            AuditTrailBehavior::className(),
            TimestampBehavior::className(),
            BlameableBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [


            [
                [
                'model'
                ], function ($attribute) 
                {
                    if (preg_match('/<[^b][^r][^>]*>/', $this->$attribute)) {
                        $this->addError($attribute, Yii::t('site', 'HTML is invalid.'));
                    }
                }
            ],
            
            [[
                'model'], function ($attribute) {
                $this->$attribute = \yii\helpers\HtmlPurifier::process($this->$attribute);
            }],




            [['created_by', 'updated_by', 'created_at', 'updated_at'], 'integer'],
            [['model'], 'string', 'max' => 255],
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
            'id' => 'ID',
            'model' => 'Model',
            // 'module_key' => "Module Key",
            'created_by' => 'Created By',
            'updated_by' => 'Updated By',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
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



    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
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

    public function getAllActiveModlesandModuleKey()
    {
        $config = require(Yii::$aliases['@backend'] . '/config/main.php');
        $items =[];
        foreach($config["modules"] as $key => $item)
        {
            $moduleKey = $key;
            $module = new $item["class"]($moduleKey);
            $defaultController = $module->controllerNamespace."\DefaultController";
            if(class_exists($defaultController))
            {
                $defaultController = new $defaultController("default",$moduleKey);
                if(property_exists($defaultController,'modelClass'))
                {
                    $model = $defaultController->modelClass;
                    $items[$model] = $moduleKey;       
                }
            }

        }
        return $items;

    }

    public function getExistedRevision()
    {
        $revisions = Revision::find()->all();
        $revisions = ArrayHelper::map($revisions,"model","model");
        $config = require(Yii::$aliases['@backend'] . '/config/main.php');
        $items =[];
        foreach($config["modules"] as $key => $item)
        {
            $moduleKey = $key;
            $module = new $item["class"]($moduleKey);
            $defaultController = $module->controllerNamespace."\DefaultController";
            if(class_exists($defaultController))
            {
                $defaultController = new $defaultController("default",$moduleKey);
                if(property_exists($defaultController,'modelClass'))
                {
                    $model = $defaultController->modelClass;
                    if(in_array($model,$revisions) )
                    {
                        $items[$model] = $moduleKey;                        
                    }
       
                }
            }

        }
        return $items;

    }

}
