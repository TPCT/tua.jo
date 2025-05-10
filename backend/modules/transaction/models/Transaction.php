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

class Transaction extends \yii\db\ActiveRecord
{

    const STATUS_PENDING = 0;
    const STATUS_PUBLISHED = 1;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'transactions';
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

            [
                [
                    'client_id', 'first_name', 'last_name', 'email', 'phone','payment_id', 'checkout_id','amount','type','status','error_message','created_at','updated_at'
                ], function ($attribute) 
                {
                    if (preg_match('/<[^b][^r][^>]*>/', $this->$attribute)) {
                        $this->addError($attribute, Yii::t('site', 'HTML is invalid.'));
                    }
                }
            ],
            
            [   
                [
                    'client_id', 'first_name', 'last_name', 'email', 'phone','payment_id', 'checkout_id','amount','type','status','error_message','created_at','updated_at'
                    ], function ($attribute) {
                    $this->$attribute = \yii\helpers\HtmlPurifier::process($this->$attribute);
                }
            ],

            [['first_name', 'last_name', 'country', 'city', 'street', 'email', 'phone', 'payment_id', 'amount', 'type', 'status', 'donor_id'], 'required'],

            [['amount'], 'number'],
            [['created_at','client_id'], 'integer'],
            [['first_name', 'last_name', 'country', 'city', 'street', 'nationality', 'email','phone', 'payment_id', 'checkout_id', 'donor_id', 'merchant_transaction_id'], 'string', 'max' => 255],
            [['error_message'], 'string'],
            [['email'], 'email'],
            [['phone'], 'string', 'max' => 20],
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

    public function getItems(){
        return $this->hasMany(TransactionItem::className(), ['transaction_id' => 'id']);
    }


    public function getClient()
    {
        return $this->hasOne(Client::className(), ['id' => 'client_id']);
    }
}
