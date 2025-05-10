<?php

namespace backend\modules\webforms\models;

use backend\modules\donation_types\models\DonationTypes;
use backend\modules\dropdown_list\models\DropdownList;
use backend\modules\countries\models\Country;
use backend\modules\city\models\City;
use borales\extensions\phoneInput\PhoneInputValidator;
use backend\modules\e_card\models\ECard;
use backend\modules\donation_programs\models\DonationProgram;

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

class DonationCampainWebform extends \yii\db\ActiveRecord
{
    public $reCaptcha;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
    return 'donation_campain_webform';
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
                    'name','mobile_number','email','campaing_name','reason_id','donation_goal'
                    ,'start_date','end_date','donation_type_id','e_card_id'
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
                    'name','mobile_number','email','campaing_name','reason_id','donation_goal'
                    ,'start_date','end_date','donation_type_id','e_card_id','message'
                    ,'created_at'
                    ], function ($attribute) {
                    $this->$attribute = \yii\helpers\HtmlPurifier::process($this->$attribute);
                }
            ],

            [['reCaptcha',
                'name','mobile_number','email','campaing_name'
                ,'start_date','end_date','donation_type_id','message'
            ], 'required'],

            [['name','email','campaing_name','message'],'string'],
            [['created_at','reason_id','donation_type_id','e_card_id', 'donation_goal'], 'integer'],


            [[ 'name','campaing_name'],'match', 'pattern' => "/^[a-zA-Z\s \x{0600}-\x{06FF}]+$/u",],

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
            'name' => Yii::t('site', 'DONATION_NAME'),
            'mobile_number' => Yii::t('site', 'DONATION_MOBILE_NUMBER'),
            'campaing_name' => Yii::t('site', 'DONATION_CAPAIGN_NAMEM'),
            'email' => Yii::t('site', 'DONATION_EMAIL'),
            'reason_id' => Yii::t('site', 'DONATION_REASON'),
            'donation_goal' => Yii::t('site', 'DONATION_GOAL'),
            'start_date' => Yii::t('site', 'DONATION_START_DATE'),
            'end_date' => Yii::t('site', 'DONATION_END_DATE'),
            'donation_type_id' => Yii::t('site', 'DONATION_TYPE'),
            'e_card_id' => Yii::t('site', 'DONATION_E_CARDID'),
            'message' => Yii::t('site', 'DONATION_MESSAGE'),

        ];
    }

    public function getReason()
    {
        return $this->hasOne(DropdownList::className(), ['id' => 'reason_id']);
    }

    public static function getReasonList()
    {
        $items = DropdownList::find()->active()->andWhere(["category" => DropdownList::DONATION_CAMPAIN_REASON])->all();
        return ArrayHelper::map($items, "id", "title");
    }
  


    public function getECards()
    {
        return $this->hasOne(ECard::className(), ['id' => 'e_card_id']);
    }

    public static function getECardsList()
    {
        $items = ECard::find()->active()->all();
        return ArrayHelper::map($items, "id", "title");
    }

    public function getDonationType()
    {
        return $this->hasOne(DonationTypes::className(), ['id' => 'donation_type_id']);
    }

    public static function getDonationTypesList()
    {
        $items = DonationTypes::find()->active()->all();
        return ArrayHelper::map($items, "id", "cms_title");
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
                    'email',
                    'campaing_name',
                    'donation_goal',
                    'start_date',
                    'end_date',
                    'donationType',
                    'eCards',
            
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
