<?php

namespace frontend\modules\account\models\card;

use common\models\Countries;
use frontend\modules\account\models\client\Client;
use frontend\modules\account\models\secondary_user\SecondaryUser;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

class Card extends ActiveRecord
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
            [['parent_id', 'token', 'bin', 'type', 'last_four_digits', 'holder', 'expiry_month', 'expiry_year', 'recurring_payment_agreement'], 'required'],
            [['token', 'recurring_payment_agreement'], 'unique'],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Client::class, 'targetAttribute' => ['parent_id' => 'id']],
        ];
    }

    public static function tableName()
    {
        return '{{%cards}}';
    }

    public function getId()
    {
        return $this->id;
    }
}
