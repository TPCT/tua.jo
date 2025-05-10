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

class JoinUsWebform extends \yii\db\ActiveRecord
{
    public $reCaptcha;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'join_us_webform';
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
                    'name', 'mobile_number', 'email','qualification' ,'scientific_expertise','experience_year' ,'created_at'
                ], function ($attribute) 
                {
                    if (preg_match('/<[^b][^r][^>]*>/', $this->$attribute)) {
                        $this->addError($attribute, Yii::t('site', 'HTML is invalid.'));
                    }
                }
            ],
            
            [   
                [
                    'name', 'mobile_number', 'email','qualification' ,'scientific_expertise','experience_year' ,'created_at'
                    ], function ($attribute) {
                    $this->$attribute = \yii\helpers\HtmlPurifier::process($this->$attribute);
                }
            ],

            [['reCaptcha','name', 'email', 'mobile_number','qualification','scientific_expertise','experience_year','cv'], 'required'],

            [['created_at'], 'integer'],
            [['name', 'email', 'mobile_number','qualification','scientific_expertise','experience_year'], 'string', 'max' => 255],

            [['scientific_expertise', 'name'],'match', 'pattern' => "/^[a-zA-Z\s \x{0600}-\x{06FF}]+$/u",],

            [['email'], 'email'],
            [['mobile_number'], 'string', 'max' => 20],
            [['mobile_number','experience_year'], 'number'],
            [['mobile_number'], PhoneInputValidator::className()],

            [['cv'], 'file', 'maxFiles' => 1, 'maxSize' => 1024 * 1024 * 5, 'skipOnEmpty' => false, 'extensions' => 'jpg, png, pdf, doc, docx'],


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
            'name' => Yii::t('site', 'NAME'),
            'email' => Yii::t('site', 'JOIN_US_EMAIL'),
            'mobile_number' => Yii::t('site', 'MOBILE_NUMBER'),
            'qualification' => Yii::t('site', 'QUALIFICATION'),
            'scientific_expertise' => Yii::t('site', 'SCIENTIFIC_EXPERTISE'),
            'experience_year' => Yii::t('site', 'EXPERIENCE_YEAR'),

        ];
    }

    public function getFileInstance()
    {
        $this->cv = UploadedFile::getInstance(new self(), "cv");
    }

    public function uploadFiles()
    {
        $routes = [
            'baseUrl' => '', // Base absolute path to web directory
            'basePath' => '@frontend/web', // Base web directory url
            'uploadPath' => 'uploads/careers', // Path for uploaded files in web directory
        ];
        try {
            if ($this->cv) {
                $media1 = Utility::saveUploadedFile(UploadedFile::getInstance(new self(), "cv"), $routes);
                $this->cv = $media1->url;
            }
        } catch (\Exception $e) {
            return false;
        }
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
                    'qualification',
                    'scientific_expertise',
                    'experience_year',
                    'cv',
        
                    'created_at:datetime',
                
                ],
            ]);


            $message = Yii::$app->mailer->compose()
                ->setTo($email)
                ->setFrom([Yii::$app->params['fromEmail'] => Yii::$app->name])
                ->setSubject('Career JOIN Form ' . $this->name . '<' . $this->email . '>')
                ->setHtmlBody($output)
                ->setTextBody('--');

                if ($this->cv) {
                    $message->attach(Yii::getAlias('@frontend') . '/web' . $this->cv);
                }
            
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
