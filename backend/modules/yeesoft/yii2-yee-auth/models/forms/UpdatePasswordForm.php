<?php

namespace yeesoft\auth\models\forms;

use kartik\password\StrengthValidator;
use yeesoft\models\User;
use Yii;
use yii\base\Model;

class UpdatePasswordForm extends Model
{
    /**
     * @var User
     */
    public $user;

    /**
     * @var string
     */
    public $sms;


    public $current_password;
    /**
     * @var string
     */
    public $password;

    /**
     * @var string
     */
    public $repeat_password;

    public $reCaptcha;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [ 
            [['password', 'repeat_password', /*'sms', 'reCaptcha'*/], 'required'],
            
            [['current_password'], 'required', 'on' => 'updateUserPassword'],
            
            [['password', 'repeat_password',], 'string', 'max' => 255],
//            [['password', 'repeat_password'], 'string', 'min' => 10],
            [['password', 'repeat_password'], 'trim'],
            ['repeat_password', 'compare', 'compareAttribute' => 'password'],
            ['current_password', 'required', 'except' => 'restoreViaEmail'],
            ['current_password', 'validateCurrentPassword', 'except' => 'restoreViaEmail'],
            //['sms', 'validateSMS'],
//            [['password'], StrengthValidator::className(),
//                'min' => Yii::$app->params['password_min'],
//                'upper' => Yii::$app->params['password_upper'],
//                'lower' => Yii::$app->params['password_lower'],
//                'digit' => Yii::$app->params['password_digit'],
//                'special' => Yii::$app->params['password_special'],
//                'hasUser' => Yii::$app->params['password_hasUser'],
//                'hasEmail' => Yii::$app->params['password_hasEmail']
//            ],
        ];
    }

    public function attributeLabels()
    {
        return [
            'current_password' => Yii::t('site', 'Current password'),
            'password' => Yii::t('site', 'Password'),
            'repeat_password' => Yii::t('site', 'Repeat password'),
        ];
    }

    /**
     * Validates current password
     */
    public function validateCurrentPassword()
    {
//        if (!Yii::$app->yee->checkAttempts()) {
//            $this->addError('current_password', Yii::t('site', 'Too many attempts'));
//            return false;
//        }

        if (!Yii::$app->security->validatePassword($this->current_password, $this->user->password_hash)) {
            $this->addError('current_password', Yii::t('site', "Wrong password"));
        }
    }

    /**
     * Validates current password
     */
    public function validateSMS()
    {
//        if (!Yii::$app->yee->checkAttempts()) {
//            $this->addError('sms', Yii::t('site', 'Too many attempts'));
//            return false;
//        }


        $parts = explode('_', $this->user->confirmation_token);
        $smsCode = (int)($parts[0]);

        if ($smsCode <> $this->sms) {
            $this->addError('sms', Yii::t('site', 'Code Invalid'));
            return false;

        }

    }

    /**
     * @param bool $performValidation
     *
     * @return bool
     */
    public function updatePassword($performValidation = true)
    {
        if ($performValidation AND !$this->validate()) {
            return false;
        }
        $this->user->scenario = 'updateMyPassword';
//        $this->user->password = $this->password;
        // $this->user->removeConfirmationToken();
        // return $this->user->save();
        $this->user->generateAuthKey();
        Yii::$app->user->logout(); 
        $this->user->password = $this->password;
        $this->user->removeConfirmationToken();
        return $this->user->save();

    }
}
