<?php

namespace api\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "api_log".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $ip_address
 * @property string $end_point
 * @property string $parameters
 * @property string $auth_key
 * @property string $created
 */
class ApiLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'api_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'integer'],
            [['parameters'], 'string'],
            [['created'], 'safe'],
            [['ip_address', 'end_point', 'auth_key'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'ip_address' => Yii::t('app', 'Ip Address'),
            'end_point' => Yii::t('app', 'End Point'),
            'parameters' => Yii::t('app', 'Parameters'),
            'created' => Yii::t('app', 'Created'),
        ];
    }
}
