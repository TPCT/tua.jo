<?php

namespace yeesoft\auth\models\forms;

use common\helpers\Utility;
use common\models\User;
use Yii;
use yii\base\Model;

class ConfirmSmsForm extends Model
{
    /**
     * @var User
     */
    public $user;

    /**
     * @var string
     */
    public $sms;

    /**
     * @var string
     */
    public $token;

    /**
     * Remove confirmation token if it's expiration date is over
     */
    public function init()
    {
//        if ($this->user->confirmation_token !== null AND $this->getTokenTimeLeft()
//            == 0
//        ) {
//            $this->user->removeConfirmationToken();
//            $this->user->save(false);
//        }
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sms', 'token'], 'required'],
//            ['sms', 'trim'],
//            ['email', 'email'],
            ['sms', 'validateSMS'],
        ];
    }

    /**
     * Check that there is no such confirmed E-mail in the system
     */
    public function validateSMS()
    {

        $this->token = Utility::encrypt_decrypt('decrypt', $this->token);
        $this->user = User::findInactiveByConfirmationToken($this->token);
        $request = Yii::$app->request;
        $inputSmsCode = $request->post('code', $this->sms);

        $parts = explode('_', $this->token);
        $smsCode = (int)($parts[0]);

//        if (!$this->user || $smsCode <> $inputSmsCode) {
        if (!$this->user || false) {
            $this->addError('sms', Yii::t('site', 'Code Invalid'));
        }

    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'sms' => Yii::t('site', 'SMS Code'),
        ];
    }

    /**
     *
     *
     * @param bool $inMinutes
     *
     * @return int
     */
    public function getTokenTimeLeft($inMinutes = false)
    {
        if ($this->user AND $this->user->confirmation_token) {
            $expire = Yii::$app->yee->confirmationTokenExpire;

            $parts = explode('_', $this->user->confirmation_token);
            $timestamp = (int)end($parts);

            $timeLeft = $timestamp + $expire - time();

            if ($timeLeft < 0) {
                return 0;
            }

            return $inMinutes ? round($timeLeft / 60) : $timeLeft;
        }

        return 0;
    }

    /**
     * @param bool $performValidation
     *
     * @return bool
     */
    public function sendEmail($performValidation = true)
    {
        if ($performValidation AND !$this->validate()) {
            return false;
        }

        $this->user->email = $this->email;
        $this->user->generateConfirmationToken();
        $this->user->save(false);

        return Yii::$app->mailer->compose(Yii::$app->yee->emailTemplates['confirm-email'],
            ['user' => $this->user])
            ->setFrom(Yii::$app->yee->emailSender)
            ->setTo($this->email)
            ->setSubject(Yii::t('site', 'E-mail confirmation for') . ' ' . Yii::$app->name)
            ->send();
    }


    /**
     * Check received confirmation token and if user found - activate it, set username, roles and log him in
     *
     * @param string $token
     *
     * @return bool|User
     */
//    public function checkConfirmationSMS($sms, $token)
//    {
//        return true;
////        $user = User::findInactiveByConfirmationToken($token);
////
////        if ($user) {
////
////            $user->status = User::STATUS_ACTIVE;
////            $user->email_confirmed = 1;
////            $user->removeConfirmationToken();
////            $user->save(false);
////            $user->assignRoles(Yii::$app->yee->defaultRoles);
////            Yii::$app->user->login($user);
////
////            return $user;
////        }
////
////        return false;
//    }
}