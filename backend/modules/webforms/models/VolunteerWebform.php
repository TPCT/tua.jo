<?php

namespace backend\modules\webforms\models;

use backend\modules\dropdown_list\models\DropdownList;
use backend\modules\countries\models\Country;

use borales\extensions\phoneInput\PhoneInputValidator;
use backend\modules\volunteers\models\Volunteers;

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

class VolunteerWebform extends \yii\db\ActiveRecord
{
    public $reCaptcha;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'volunteer_webform';
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
                    'name', 'volunteer_date','mobile_number' ,'gender','nationality_id',
                    'country_id','occupation_id','university_name','email','volunteer_id','participated_volunteer_type'
                    ,'specify','hear_about_volunteer_id'
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
                    'name', 'volunteer_date','mobile_number' ,'gender','nationality_id',
                    'country_id','occupation_id','university_name','email','volunteer_id','participated_volunteer_type'
                    ,'specify','hear_about_volunteer_id'
                    ,'created_at'
                    ], function ($attribute) {
                    $this->$attribute = \yii\helpers\HtmlPurifier::process($this->$attribute);
                }
            ],

            [['reCaptcha',
                'name', 'volunteer_date','mobile_number' ,'gender','nationality_id',
                'country_id','occupation_id','email','volunteer_id','participated_volunteer_type'
                ,'hear_about_volunteer_id'
            ], 'required'],

            [['name','specify','email','university_name'],'string'],
            [['created_at','nationality_id','country_id','occupation_id','volunteer_id','hear_about_volunteer_id'], 'integer'],


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
            'name' => Yii::t('site', 'VOLUNTEER_NAME_LABEL'),
            'volunteer_date' => Yii::t('site', 'VOLUNTEER_DATE'),
            'mobile_number' => Yii::t('site', 'VOLUNTEER_MOBILE_NUMBER'),
            'gender' => Yii::t('site', 'VOLUNTEER_GENDER'),
            'nationality_id' => Yii::t('site', 'VOLUNTEER_NATIONALITY_ID'),
            'country_id' => Yii::t('site', 'VOLUNTEER_COUNTRY_NAME'),
            'occupation_id' => Yii::t('site', 'VOLUNTEER_OCCUPATION_TYPE'),
            'university_name' => Yii::t('site', 'VOLUNTEER_UNIVERSITY'),
            'email' => Yii::t('site', 'VOLUNTEER_EMAIL_LABEL'),
            'volunteer_id' => Yii::t('site', 'VOLUNTEER_VACANCY_NAME'),
            'participated_volunteer_type' => Yii::t('site', 'VOLUNTEER_PARTICIPATED_TYPE'),
            'specify' => Yii::t('site', 'VOLUNTEER_SPECIFY'),
            'hear_about_volunteer_id' => Yii::t('site', 'HEAR_ABOUT_VOLUNTEER'),
   


        ];
    }
    
    public function getNationalities()
    {
        return $this->hasOne(Country::className(), ['id' => 'nationality_id']);
    }
    public function getCountries()
    {
        return $this->hasOne(Country::className(), ['id' => 'country_id']);
    }



    public function getVolunteers()
    {
        return $this->hasOne(Volunteers::className(), ['id' => 'volunteer_id']);
    }

    public static function getVolunteersList()
    {
        $items = Volunteers::find()->active()->all();
        return ArrayHelper::map($items, "id", "title");
    }



    public function getOccupationType()
    {
        return $this->hasOne(DropdownList::className(), ['id' => 'occupation_id']);
    }

    public static function getOccupationTypeList()
    {
        $items = DropdownList::find()->active()->andWhere(["category" => DropdownList::VOLUNTEER_OCCUPATION_TYPE])->all();
        return ArrayHelper::map($items, "id", "title");
    }
  

    public function getHearAboutVolunteerType()
    {
        return $this->hasOne(DropdownList::className(), ['id' => 'hear_about_volunteer_id']);
    }

    public static function getHearAboutVolunteerTypeList()
    {
        $items = DropdownList::find()->active()->andWhere(["category" => DropdownList::HEAR_ABOUT_VOLUNTEER])->all();
        return ArrayHelper::map($items, "id", "title");
    }
  
    public static function getGenderList()
    {
        return [
            'male' => Yii::t('site', 'MALE'),
            'female' => Yii::t('site', 'FEMALE')
        ];
    }
  
    public static function getHaveParticipatedList()
    {
        return [
            'yes' => Yii::t('site', 'YEA'),
            'no' => Yii::t('site', 'NO')
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
                    'name',
                    'volunteer_date',
                    'mobile_number',
                    'gender',
                    'university_name',
                    'email',
                    'specify',
                    'participated_volunteer_type',

                    'nationalities',
        
                    'volunteers',
                    'occupationType',
                    'hearAboutVolunteerType',
        
                    'created_at:datetime',
                
                ],
            ]);


            $message = Yii::$app->mailer->compose()
                ->setTo($email)
                ->setFrom([Yii::$app->params['fromEmail'] => Yii::$app->name])
                ->setSubject('Volunteer Form ' . $this->name . '<' . $this->email . '>')
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
