<?php

namespace backend\modules\webforms\models;

use backend\modules\dropdown_list\models\DropdownList;
use backend\modules\countries\models\Country;
use borales\extensions\phoneInput\PhoneInputValidator;
use backend\modules\vacancy\models\Vacancy;
use common\helpers\Utility;
use kartik\detail\DetailView;
use Yii;
use yii\web\UploadedFile;

use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "apply_now".
 *
 * @property int $id
 * @property string $name
 * @property string $phone
 * @property string $email
 * @property int $purpose_id
 * @property string $comment
 * @property int $created_at
 *
 * @property DropdownList $purpose
 */

class SeaAllegationWebform extends \yii\db\ActiveRecord
{
    public $reCaptcha;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sea_allegation_webform';
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
                    'name', 'mobile_number', 'email','contact_method_id' ,'inciden_date','location',
                    'description','survivor_name','survivor_position','alleged_name','alleged_position','witness_name','additional_information'
                    ,'created_at'
                ], function ($attribute) 
                {
                    if (preg_match('/<[^b][^r][^>]*>/', $this->$attribute)) {
                        $this->addError($attribute, Yii::t('site', 'HTML is invalid.'));
                    }
                }
            ],
            
            [   
                [
                    'name', 'mobile_number', 'email','contact_method_id' ,'inciden_date','location',
                    'description','survivor_name','survivor_position','alleged_name','alleged_position','witness_name','additional_information'
                    ,'created_at'
                    ], function ($attribute) {
                    $this->$attribute = \yii\helpers\HtmlPurifier::process($this->$attribute);
                }
            ],

            [['reCaptcha','name', 'email','mobile_number','contact_method_id'], 'required'],

            [['additional_information','description'],'string'],
            [['created_at','contact_method_id'], 'integer'],


            [[ 'name'],'match', 'pattern' => "/^[a-zA-Z\s \x{0600}-\x{06FF}]+$/u",],

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
            'name' => Yii::t('site', 'SEA_ALLEGATION_NAME'),
            'email' => Yii::t('site', 'SEA_ALLEGATION_EMAIL_LABEL'),
            'mobile_number' => Yii::t('site', 'MOBILE_NUMBER'),
            'contact_method_id' => Yii::t('site', 'CONTACT_METHOD_ID'),
            'inciden_date' => Yii::t('site', 'INCIDEN_DATE'),
            'location' => Yii::t('site', 'LOCATION'),
            'description' => Yii::t('site', 'DESCRIPTION'),
            'survivor_name' => Yii::t('site', 'SURVIVOR_NAME'),
            'survivor_position' => Yii::t('site', 'SURVIVOR_POSITION'),
            'alleged_name' => Yii::t('site', 'ALLEGED_NAME'),
            'alleged_position' => Yii::t('site', 'ALLEGED_POSITION'),
            'witness_name' => Yii::t('site', 'WITNESS_NAME'),
            'additional_information' => Yii::t('site', 'SEA_ALLEGATION_ADDITIONAL_INFORMATION'),


        ];
    }
    public function getSeaAllegation()
    {
        return $this->hasOne(DropdownList::className(), ['id' => 'contact_method_id']);
    }

    public static function getSeaAllegationList()
    {
        $items = DropdownList::find()->active()->andWhere(["category" => DropdownList::PROTECTION_CONTACT_WEBFORM])->all();
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
                    'name',
                    'mobile_number',
                    'email:email',

                    'inciden_date',
                    'location',
                    'description',
                    'survivor_name',
                    'survivor_position',
                    'alleged_name',
                    'alleged_position',
                    'witness_name',
                    'additional_information',
        
                    'created_at:datetime',
                
                ],
            ]);


            $message = Yii::$app->mailer->compose()
                ->setTo($email)
                ->setFrom([Yii::$app->params['fromEmail'] => Yii::$app->name])
                ->setSubject('Sea Allegation Form ' . $this->name . '<' . $this->email . '>')
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
