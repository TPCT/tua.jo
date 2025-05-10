<?php

namespace backend\modules\transaction\models;

use backend\modules\dropdown_list\models\DropdownList;
use backend\modules\donation_types\models\DonationTypes;
use backend\modules\campaigns\models\Campaign;
use frontend\modules\account\models\client\Client;
use backend\modules\countries\models\Country;
use borales\extensions\phoneInput\PhoneInputValidator;
use common\helpers\Utility;
use kartik\detail\DetailView;
use common\models\User;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "contact_us_webform".
 *
 * @property int $id
 * @property string $name
 * @property string $phone
 * @property string $email
 * @property int $purpose_id
 * @property string $comment
 * @property int $created_at
 * @property int $updated_at
 *
 * @property DropdownList $purpose
 */

class TransactionItem extends \yii\db\ActiveRecord
{

    const STATUS_PENDING = 0;
    const STATUS_PUBLISHED = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transaction_items';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' =>
            [
                'class'=> TimestampBehavior::className(),
                'updatedAtAttribute' =>false,
            ]
           
        ];
    }



    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[
                'transaction_id', 'donation_id', 'donor_id', 'donation_type', 'campaign_id',
                'amount', 'amount_usd', 'quantity', 'currency', 'order_id', 'transaction_type',
                'receipt_type', 'recipient_name', 'recipient_email', 'recipient_phone',
                'api_transaction_id', 'status'
            ], 'required'],

            [['created_at','transaction_id','amount', 'amount_usd', 'quantity', 'transaction_type', 'receipt_type', 'status', 'type'], 'integer'],
            [['donation_id', 'donor_id', 'donation_type', 'campaign_id', 'order_id', 'recipient_name', 'recipient_email', 'recipient_phone', 'api_transaction_id'], 'string', 'max' => 255],
            [['recipient_email'], 'email'],
            [['recipient_phone'], 'string', 'max' => 20],
        ];
    }

    public function __construct(array $config = [])
    {
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('site', 'ID'),
            'user_id' => Yii::t('site', 'Client ID'),
            'first_name' => Yii::t('site', 'First Name'),
            'last_name' => Yii::t('site', 'Last Name'),
            'phone' => Yii::t('site', 'Phone'),
            'email' => Yii::t('site', 'Email'),
            'payment_id' => Yii::t('site', 'Payment ID'),
            'amount' => Yii::t('site', 'Amount'),
            'type' => Yii::t('site', 'Type'),
            'status' => Yii::t('site', 'Status'),
            'country' => Yii::t('site', 'Country'),
            'city' => Yii::t('site', 'City'),
            'street' => Yii::t('site', 'Street'),
        ];
    }


    public function getClient()
    {
        return $this->hasOne(Client::className(), ['id' => 'client_id']);
    }
}
