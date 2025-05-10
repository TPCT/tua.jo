<?php

namespace backend\modules\webforms\models;

use backend\modules\dropdown_list\models\DropdownList;
use backend\modules\countries\models\Country;
use borales\extensions\phoneInput\PhoneInputValidator;
use common\helpers\Utility;
use kartik\detail\DetailView;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;
use common\components\TuaClient;

/**
 * This is the model class for table "ComplaintWebform".
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

class ComplaintWebform extends \yii\db\ActiveRecord
{
    public $reCaptcha;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'complaint_webform';
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
                    'name', 'mobile_number', 'email', 'message' ,'another_way','created_at','survey_type','by_phone','by_email','prefer_not_to_communicate'
                ], function ($attribute) 
                {
                    if (preg_match('/<[^b][^r][^>]*>/', $this->$attribute)) {
                        $this->addError($attribute, Yii::t('site', 'HTML is invalid.'));
                    }
                }
            ],
            
            [   
                [
                    'name', 'mobile_number', 'email', 'message','created_at','survey_type','by_phone','by_email','prefer_not_to_communicate'
                    ], function ($attribute) {
                    $this->$attribute = \yii\helpers\HtmlPurifier::process($this->$attribute);
                }
            ],

            [['reCaptcha','name' , 'message','survey_type'], 'required'],

            [['created_at','by_phone','by_email','prefer_not_to_communicate'], 'integer'],

            [['name', 'email','mobile_number','another_way'], 'string', 'max' => 255],

            [['name'],'match', 'pattern' => "/^[a-zA-Z\s \x{0600}-\x{06FF}]+$/u",],

            [['email'], 'email'],

            [['mobile_number'], 'string', 'max' => 20],
            [['mobile_number'], 'number'],
            [['mobile_number'], PhoneInputValidator::className()],

            [['reCaptcha'], \himiklab\yii2\recaptcha\ReCaptchaValidator::className(),],
            
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
            'name' => Yii::t('site', 'SENDER_NAME'),

            'survey_type' => Yii::t('site', 'COMPLAINT_SURVEY_TYPE'),
            'by_phone' => Yii::t('site', 'COMPLAINT_SURVEY_BY_PHONE'),
            'by_email' => Yii::t('site', 'COMPLAINT_SURVEY_BY_EMAIL'),
            'prefer_not_to_communicate' => Yii::t('site', 'COMPLAINT_SURVEY_PREFER_NOT_TO_COMMUINCATE'),

            'email' => Yii::t('site', 'COMPLAINT_EMAIL'),
            'mobile_number' => Yii::t('site', 'PHONE_NUMBER'),
            'message' => Yii::t('site', 'COMPLAINT_MESSAGE'),
            'another_way'=>Yii::t('site', 'ANOTHER_WAY'),

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
                    //'id',
                    [
                        'label' => Yii::t('site', 'Complaint Type'),
                        'value' => function($model) {
                            return TuaClient::CompliantType[(int) $this->survey_type] ?? Yii::t('site', 'Unknown');
                        },
                    ],
                    'name',
                    'email:email',
                    'mobile_number',
                    'message',
                    [
                        'label' => Yii::t('site', 'BY_PHONE'),
                        'value' => function($model) {
                            return  $this->by_phone == 1 ? 'prefer Phone' : '';
                        },
                    ],
         
                    [
                        'label' => Yii::t('site', 'BY_EMAIL'),
                        'value' => function($model) {
                            return  $this->by_email == 1 ? 'prefer Email' : '';
                        },
                    ],
         
                    [
                        'label' => Yii::t('site', 'PREFER_ANOTHER_METHOS'),
                        'value' => function($model) {
                            return  $this->prefer_not_to_communicate == 1 ? 'prefer Another Method' : '';
                        },
                    ],
         
                    'created_at:datetime',
                
                ],
            ]);


            $message = Yii::$app->mailer->compose()
                ->setTo($email)
                ->setFrom([Yii::$app->params['fromEmail'] => Yii::$app->params['fromName']])
                ->setSubject('Complaint From ' . $this->name . '<' . $this->email . '>')
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
