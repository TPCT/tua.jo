<?php

namespace frontend\modules\account\models\secondary_user;

use common\models\Countries;
use frontend\modules\account\models\client\Client;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

class SecondaryUser extends ActiveRecord
{
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public function rules()
    {
        return [
            [['email', 'name', 'parent_id', 'guid'], 'required'],
            [['email'], 'email'],
            [['guid'], 'unique'],
            [['name'], 'string', 'max' => 255],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Client::class, 'targetAttribute' => ['parent_id' => 'id']],
        ];
    }

    public static function tableName()
    {
        return '{{%secondary_users}}';
    }

    public function getParent(){
        return $this->hasOne(Client::class, ['id' => 'parent_id']);
    }
}
