<?php

namespace backend\modules\webforms\models;

use backend\modules\donation_types\models\DonationTypes;
use backend\modules\dropdown_list\models\DropdownList;
use backend\modules\countries\models\Country;
use backend\modules\sponsorship_families\models\SponsorshipFamilies;
use borales\extensions\phoneInput\PhoneInputValidator;
use common\helpers\Utility;
use frontend\modules\account\models\client\Client;
use kartik\detail\DetailView;
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

class RequestVisitWebform extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sponsorship_request_visits';
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
                    'client_id', 'sponsorship_family_id', 'name', 'email', 'phone', 'date','message','created_at', 'updated_at'
                ], function ($attribute) 
                {
                    if (preg_match('/<[^b][^r][^>]*>/', $this->$attribute)) {
                        $this->addError($attribute, Yii::t('site', 'HTML is invalid.'));
                    }
                }
            ],
            
            [   
                [
                    'client_id', 'sponsorship_family_id', 'name', 'email', 'phone', 'date','message','created_at', 'updated_at'
                    ], function ($attribute) {
                    $this->$attribute = \yii\helpers\HtmlPurifier::process($this->$attribute);
                }
            ],

            [['name', 'email', 'phone', 'message','client_id', 'sponsorship_family_id', 'date'], 'required'],

            [['created_at', 'updated_at'], 'integer'],
            [['name', 'email','phone', 'message'], 'string', 'max' => 255],

            [['name'],'match', 'pattern' => "/^[a-zA-Z\s \x{0600}-\x{06FF}]+$/u",],

            [['email'], 'email'],
            [['phone'], 'string', 'max' => 20],
            [['phone'], 'number'],
            [['phone'], PhoneInputValidator::className()],
            [['client_id'], 'exist', 'skipOnError' => true, 'targetClass' => Client::className(), 'targetAttribute' => ['client_id' => 'id']],
            [['sponsorship_family_id'], 'exist', 'skipOnError' => true, 'targetClass' => SponsorshipFamilies::className(), 'targetAttribute' => ['sponsorship_family_id' => 'id']],
        ];
    }

    public function __construct(array $config = [])
    {
        parent::__construct($config);
    }

    public function getClient(){
        return $this->hasOne(Client::className(), ['id' => 'client_id']);
    }

    public function getFamily(){
        return $this->hasOne(SponsorshipFamilies::className(), ['id' => 'sponsorship_family_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('site', 'ID'),
            'name' => Yii::t('site', 'SENDER_NAME'),
            'email' => Yii::t('site', 'CONTACT_US_EMAIL'),
            'phone' => Yii::t('site', 'PHONE_NUMBER'),
            'message' => Yii::t('site', 'MESSAGE'),
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param string $email the target email address
     * @return boolean whether the email was sent
     */
    public function sendEmail($email)
    {

        
        try 
        {
            $output = DetailView::widget([
                'model' => $this,
                'formatter' => [

                    'class' => '\yii\i18n\Formatter',
        
                    'dateFormat' => 'MM/dd/yyyy',
        
                    'datetimeFormat' => 'MM/dd/yyyy HH:mm:ss',
        
                ],
                'attributes' => [
                    [
                        'attribute' => 'client_id',
                        'label' => Yii::t('site', 'Account Name'),
                        'value' => function ($model) {
                            return $model->client->first_name . " " . $model->client->last_name;
                        }
                    ],
                    [
                        'attribute' => 'sponsorship_family_id',
                        'label' => Yii::t('site', 'Family Name'),
                        'value' => function ($model) {
                            return $model->family->title;
                        }
                    ],
                    'name',
                    'email:email',
                    'phone',
                    'message',
                    'created_at:datetime',
                ],
            ]);


            $message = Yii::$app->mailer->compose()
                ->setTo($email)
                ->setFrom([Yii::$app->params['fromEmail'] => Yii::$app->params['fromName']])
                ->setSubject('Request Visit From ' . $this->name . '<' . $this->email . '>')
                ->setHtmlBody($output)
                ->setTextBody('--');
            
            $status = $message->send();

            return $status;
        } 
        catch (\Exception $e) 
        {
            var_dump($e); exit;
            return false;
        }

    }

}
