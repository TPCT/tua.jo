<?php

namespace yeesoft\auth\models\forms;

use yeesoft\models\User;
use Yii;
use yii\base\Model;

class ResetPasswordForm extends Model
{
    /**
     * @var User
     */
    public $user;

    /**
     * @var string
     */
//    public $email;
    public $username;

    /**
     * @var string
     */
    public $reCaptcha;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
//            ['captcha', 'captcha', 'captchaAction' => '/auth/default/captcha'],
            // [['reCaptcha'], 'required'],
//            [['email'], 'required'],
                [['username'], 'required'],
                [['username'], 'email'],
                
//            ['email', 'trim'],
//            ['email', 'email'],
//            ['email', 'validateEmailConfirmedAndUserActive'],
            ['username', 'validateUsernameConfirmedAndUserActive'],
        ];
    }

    /**
     * @return bool
     */
    public function validateEmailConfirmedAndUserActive()
    {
        if (!Yii::$app->yee->checkAttempts()) {
            $this->addError('email', Yii::t('site', 'Too many attempts'));
            return false;
        }

        $user = User::findOne([
            'email' => $this->email,
//            'email_confirmed' => 1,
            'status' => User::STATUS_ACTIVE,
        ]);

        if ($user) {
            $this->user = $user;
        } else {
            $this->addError('email', Yii::t('site', 'E-mail is invalid'));
        }
    }

    /**
     * @return bool
     */
    public function validateUsernameConfirmedAndUserActive()
    {
        if (!Yii::$app->yee->checkAttempts()) {
            $this->addError('username', Yii::t('site', 'Too many attempts'));
            return false;
        }

        $user = User::findOne([
            'username' => $this->username,
            'email_confirmed' => 1,
            'status' => User::STATUS_ACTIVE,
        ]);

        if ($user) {
            $this->user = $user;
        } else {
            $this->addError('username', Yii::t('site', 'Email is invalid, Or Email maybe not confirmed'));
        }
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('site', 'Email'),
            'captcha' => Yii::t('site', 'Captcha'),
        ];
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

        $this->user->generateConfirmationToken();
        $this->user->save(false);

        return Yii::$app->mailer->compose(Yii::$app->yee->emailTemplates['password-reset'],
            ['user' => $this->user])
            ->setFrom(Yii::$app->yee->emailSender)
            ->setTo($this->user->email)
            ->setSubject(Yii::t('site', 'Password reset for') . ' ' . Yii::$app->name)
            ->send();
    }
}