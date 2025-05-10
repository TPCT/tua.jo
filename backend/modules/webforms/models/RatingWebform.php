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

class RatingWebform extends \yii\db\ActiveRecord
{
    public $reCaptcha;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rating_webform';
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
                    'question_1_id', 'question_2_id', 'question_2_text','question_3_id' ,'question_4_text','question_5_id'
                    ,'question_6_id','question_7_id','question_8_text' ,'created_at'
                ], function ($attribute) 
                {
                    if (preg_match('/<[^b][^r][^>]*>/', $this->$attribute)) {
                        $this->addError($attribute, Yii::t('site', 'HTML is invalid.'));
                    }
                }
            ],
            
            [   
                [
                    'question_1_id', 'question_2_id', 'question_2_text','question_3_id' ,'question_4_text','question_5_id'
                    ,'question_6_id','question_7_id','question_8_text' ,'created_at'
                    ], function ($attribute) {
                    $this->$attribute = \yii\helpers\HtmlPurifier::process($this->$attribute);
                }
            ],

            [[/*'reCaptcha',*/'question_1_id', 'question_2_id','question_3_id','question_5_id',
                'question_6_id','question_7_id'], 'required'],

            [[  'question_1_id', 'question_2_id','question_3_id','question_5_id','question_6_id','question_7_id'], 'integer'],

            [['question_8_text','question_4_text','question_2_text'], 'string'],



         //   [['reCaptcha'], \himiklab\yii2\recaptcha\ReCaptchaValidator::className(),],
            
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
            'question_1_id' => Yii::t('site', 'QUESTION_1_ID'),
            'question_2_id' => Yii::t('site', 'QUESTION_2_ID'),
            'question_2_text' => Yii::t('site', 'question_2_text'),
            'question_3_id' => Yii::t('site', 'QUESTION_3_ID'),
            'question_4_text' => Yii::t('site', 'QUESTION_4_TEXT'),
            'question_5_id' => Yii::t('site', 'QUESTION_5_ID'),
            'question_6_id' => Yii::t('site', 'QUESTION_6_ID'),
            'question_7_id' => Yii::t('site', 'QUESTION_7_ID'),
            'question_8_text' => Yii::t('site', 'QUESTION_8_TEXT'),
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
        
                    'created_at:datetime',
                
                ],
            ]);


            $message = Yii::$app->mailer->compose()
                ->setTo($email)
                ->setFrom([Yii::$app->params['fromEmail'] => Yii::$app->name])
                ->setSubject('Rating Form ' . $this->name . '<' . $this->email . '>')
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
