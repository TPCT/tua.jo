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
 * This is the model class for table "IntimationWebform".
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

class IntimationWebform extends \yii\db\ActiveRecord
{
    public $reCaptcha;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'inimation_webform';
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
                    'inimation_webform','created_at'
                ], function ($attribute) 
                {
                    if (preg_match('/<[^b][^r][^>]*>/', $this->$attribute)) {
                        $this->addError($attribute, Yii::t('site', 'HTML is invalid.'));
                    }
                }
            ],
            
            [   
                [
                    'inimation_webform','created_at'
                    ], function ($attribute) {
                    $this->$attribute = \yii\helpers\HtmlPurifier::process($this->$attribute);
                }
            ],

            [['reCaptcha','inimation_webform'], 'required'],

            [['created_at'], 'integer'],

   

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
            'inimation_webform' => Yii::t('site', 'EXPLAIN_INTIMATION'),
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
                    'inimation_webform',


        
                    'created_at:datetime',
                
                ],
            ]);


            $message = Yii::$app->mailer->compose()
                ->setTo($email)
                ->setFrom([Yii::$app->params['fromEmail'] => Yii::$app->params['fromName']])
                ->setSubject('Contact Us From ' )
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
