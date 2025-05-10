<?php

namespace backend\modules\webforms\models;

use backend\modules\dropdown_list\models\DropdownList;
use backend\modules\countries\models\Country;
use backend\modules\city\models\City;
use borales\extensions\phoneInput\PhoneInputValidator;
use backend\modules\e_card\models\ECard;
use frontend\modules\account\models\client\Client;
use backend\modules\donation_programs\models\DonationProgram;

use common\helpers\Utility;
use Exception;
use kartik\detail\DetailView;
use Yii;
use yii\db\ActiveRecord;
use yii\helpers\HtmlPurifier;
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
class DonationGiftWebform extends ActiveRecord
{
    public $reCaptcha;

    public function __construct(array $config = [])
    {
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'donation_gift_webform';
    }


    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' =>
                [
                    'class' => TimestampBehavior::className(),
                    'updatedAtAttribute' => false,
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
                    'amount', 'sender_name', 'sender_email', 'recipient_name', 'recipient_email', 'message'
                    , 'e_card_id', 'client_id', 'sender_mobile_number', 'recipient_mobile_number', 'donor_id'
                    , 'created_at'
                ], function ($attribute) {
                if (preg_match('/<[^b][^r][^>]*>/', $this->$attribute)) {
                    $this->addError($attribute, Yii::t('site', 'HTML is invalid.'));
                }
            }
            ],

            [
                [
                    'amount', 'sender_name', 'sender_email', 'recipient_name', 'recipient_email', 'message'
                    , 'e_card_id', 'client_id', 'sender_mobile_number', 'recipient_mobile_number', 'donor_id'
                    , 'created_at'
                ], function ($attribute) {
                $this->$attribute = HtmlPurifier::process($this->$attribute);
            }
            ],

            [['e_card_id'], 'required', 'on' => 'step_one'],
            [['amount', 'sender_name', 'sender_email', 'recipient_name', 'recipient_email', 'message', 'sender_mobile_number', 'recipient_mobile_number', 'e_card_id', 'donor_id'], 'required', 'on' => 'step_two'],
            [['checkout_id'], 'required', 'on' => 'step_three'],
            [['sender_name', 'sender_email', 'recipient_name', 'recipient_email', 'message'], 'string'],
            [['created_at', 'client_id', 'e_card_id', 'send_when_finished', 'status'], 'integer'],


            [['sender_name', 'recipient_name'], 'match', 'pattern' => "/^[a-zA-Z\s \x{0600}-\x{06FF}]+$/u",],

            [['sender_email', 'recipient_email'], 'email'],
            [['sender_mobile_number', 'recipient_mobile_number'], 'string', 'max' => 20],
            [['sender_mobile_number', 'recipient_mobile_number'], 'number'],
            [['sender_mobile_number', 'recipient_mobile_number'], PhoneInputValidator::className()],


            //   [['reCaptcha'], \himiklab\yii2\recaptcha\ReCaptchaValidator::className(),],

        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();

        // Step 1 only needs e_card_id
        $scenarios['step_one'] = ['e_card_id'];
        // Step 2 needs the rest
        $scenarios['step_two'] = ['amount', 'sender_name', 'sender_email', 'recipient_name', 'recipient_email', 'message', 'recipient_mobile_number', 'sender_mobile_number', 'e_card_id', 'donor_id', 'send_when_finished'];
        $scenarios['step_three'] = ['checkout_id', 'status'];
        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [

            'id' => Yii::t('site', 'ID'),
            'amount' => Yii::t('site', 'AMOUNT'),
            'sender_name' => Yii::t('site', 'DONATE_SENDER_NAME'),
            'sender_email' => Yii::t('site', 'DONATE_SENDER_EMAIL'),

            'recipient_name' => Yii::t('site', 'DONATION_RECEIPIENT_NAME'),
            'recipient_email' => Yii::t('site', 'DONATION_RECEIPIENT_EMAIL'),

            'sender_mobile_number' => Yii::t('site', 'DONATION_SENDER_MOBILE_NUMBER'),
            'recipient_mobile_number' => Yii::t('site', 'DONATION_RECEIPIENT_MOBILE_NUMBER'),

            'MESSAGE' => Yii::t('site', 'DONATION_MESSAGE'),
            'e_card_id' => Yii::t('site', 'DONATION_E_CARD'),
            'client_id' => Yii::t('site', 'DONATION_CLIENT'),

        ];
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

    public function getClient()
    {
        return $this->hasOne(Client::className(), ['id' => 'client_id']);
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param string $email the target email address
     * @return boolean whether the email was sent
     */
    public function sendEmail($email)
    {


        try {
            $output = DetailView::widget([
                'model' => $this,
                'formatter' => [

                    'class' => '\yii\i18n\Formatter',

                    'dateFormat' => 'MM/dd/yyyy',

                    'datetimeFormat' => 'MM/dd/yyyy HH:mm:ss',

                ],
                'attributes' => [

                    //'id',
                    'amount',
                    'sender_name',
                    'sender_email',
                    'recipient_name',
                    'recipient_email',
                    'message',
                    'sender_mobile_number',
                    'recipient_mobile_number',
                    'eCards',
                    'client',

                    'created_at:datetime',
                ],
            ]);


            $message = Yii::$app->mailer->compose()
                ->setTo($email)
                ->setFrom([Yii::$app->params['fromEmail'] => Yii::$app->name])
                ->setSubject('Donation Gift Form ' . $this->sender_name . '<' . $this->sender_email . '>')
                ->setHtmlBody($output)
                ->setTextBody('--');

            $status = $message->send();

            return $status;
        } catch (Exception $e) {
            var_dump($e);
            exit;
            return false;
        }

    }

}
