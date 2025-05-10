<?php

namespace backend\modules\recurring_items\models;

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

class RecurringItems extends \yii\db\ActiveRecord
{

    const STATUS_PENDING = 0;
    const STATUS_PUBLISHED = 1;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'recurring_items';
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
                    'client_id', 'name', 'email', 'phone','registration_token', 'frequency','amount','next_due_at','donation_type_id','campaign_id','created_at','updated_at'
                ], function ($attribute) 
                {
                    if (preg_match('/<[^b][^r][^>]*>/', $this->$attribute)) {
                        $this->addError($attribute, Yii::t('site', 'HTML is invalid.'));
                    }
                }
            ],
            
            [   
                [
                    'client_id', 'name', 'email', 'phone','registration_token', 'frequency','amount','next_due_at','donation_type_id','campaign_id','created_at','updated_at'
                    ], function ($attribute) {
                    $this->$attribute = \yii\helpers\HtmlPurifier::process($this->$attribute);
                }
            ],

            [['name', 'email', 'phone', 'registration_token','frequency', 'amount', 'next_due_at', 'campaign_id', 'donation_type_id', 'donor_id', 'country', 'city', 'street', 'nationality', 'amount_usd', 'amount_jod', 'total_usd', 'total_jod', 'quantity'], 'required'],
            [['amount_usd', 'amount_jod', 'total_usd', 'total_jod'], 'number'],
            [['created_at','campaign_id', 'quantity','donation_type_id', 'type'], 'integer'],
            [['name', 'email','phone', 'registration_token', 'donor_id', 'country', 'city', 'street', 'nationality', 'recurring_payment_agreement'], 'string', 'max' => 255],
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
            'name' => Yii::t('site', 'name'),
            'email' => Yii::t('site', 'email'),
            'phone' => Yii::t('site', 'phone'),
            'amount' => Yii::t('site', 'amount'),
            'frequency' => Yii::t('site', 'frequency'),

        ];
    }

    public function getImage(){
        if ($this->campaign){
            return $this->campaign->image;
        }
        return $this->donationType->image;
    }

    public function getTitle(){
        if ($this->campaign){
            return $this->campaign->cms_title;
        }
        return $this->donationType->cms_title;
    }

    public function getDonationType()
    {
        return $this->hasOne(DonationTypes::className(), ['guid' => 'donation_type_id']);
    }

    public function getCampaign()
    {
        return $this->hasOne(Campaign::className(), ['guid' => 'campaign_id']);
    }

    public function getClient()
    {
        return $this->hasOne(Client::className(), ['id' => 'client_id']);
    }
}
