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

class ContactUsWebform extends \yii\db\ActiveRecord
{
    public $reCaptcha;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contact_us_webform';
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
                     'email', 'mobile_number', 'message','purpose_id','created_at'
                ], function ($attribute) 
                {
                    if (preg_match('/<[^b][^r][^>]*>/', $this->$attribute)) {
                        $this->addError($attribute, Yii::t('site', 'HTML is invalid.'));
                    }
                }
            ],
            
            [   
                [
                     'email', 'mobile_number', 'message','purpose_id','created_at'
                    ], function ($attribute) {
                    $this->$attribute = \yii\helpers\HtmlPurifier::process($this->$attribute);
                }
            ],

            [['reCaptcha', 'message','purpose_id'], 'required'],

            [['created_at'], 'integer'],
            // [['name', 'email','mobile_number', 'message'], 'string', 'max' => 255],

            // [['name'],'match', 'pattern' => "/^[a-zA-Z\s \x{0600}-\x{06FF}]+$/u",],

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
            'email' => Yii::t('site', 'CONTACT_US_EMAIL'),
            'mobile_number' => Yii::t('site', 'PHONE_NUMBER'),
            'message' => Yii::t('site', 'MESSAGE'),
            'purpose_id' => Yii::t('site', 'PURPOSE_OF_CONTACT'),

        ];
    }


    public function getContactPurpose()
    {
        return $this->hasOne(DropdownList::className(), ['id' => 'purpose_id']);
    }

    public static function getContactPurposeList()
    {
        $items = DropdownList::find()->active()->andWhere(["category" => DropdownList::PURPOSE_OF_CONTACT])->all();
        return ArrayHelper::map($items, "id", "title");
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
                    'email:email',
                    'mobile_number',
                    'message',
                    'contactPurpose',

        
                    'created_at:datetime',
                
                ],
            ]);


            $message = Yii::$app->mailer->compose()
                ->setTo($email)
                ->setFrom([Yii::$app->params['fromEmail'] => Yii::$app->params['fromName']])
                ->setSubject('Contact Us From ' . $this->email . '<' . $this->email . '>')
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
