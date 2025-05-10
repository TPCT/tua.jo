<?php

namespace yeesoft\auth\models\forms;

use borales\extensions\phoneInput\PhoneInputValidator;
use kartik\password\StrengthValidator;
use yeesoft\models\User;
use Yii;
use yii\base\Model;
use yii\helpers\Html;


class SignupForm extends Model
{
    public $first_name;
    public $last_name;
    public $phone;
    public $username;
    public $email;
    public $password;
    public $repeat_password;
    public $address;
    public $captcha;
    public $reCaptcha;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = [
            // ['captcha', 'captcha', 'captchaAction' => '/auth/default/captcha'],
            [
                [
                    /*'reCaptcha',*/ 'email', 'password', 'repeat_password',
                    'phone', 'first_name','last_name'
                ], 'required'
            ],
            [['username', 'email', 'password', 'repeat_password'], 'trim'],
            [['email'], 'email'],
            ['username', 'unique',
                'targetClass' => 'yeesoft\models\User',
                'targetAttribute' => 'username',
            ],
            ['email', 'unique',
                'targetClass' => 'yeesoft\models\User',
                'targetAttribute' => 'email',
            ],
            // ['username', 'purgeXSS'],
            [['phone', 'first_name', 'last_name','address'], 'string', 'max' => 50],
            ['username', 'string', 'max' => 50],
            [['phone'], 'number'],
            [['phone'], PhoneInputValidator::className()],
            // ['username', 'match', 'pattern' => Yii::$app->yee->usernameRegexp, 'message' => Yii::t('site', 'The username should contain only Latin letters, numbers and the following characters: "-" and "_".')],
            // ['username', 'match', 'not' => true, 'pattern' => Yii::$app->yee->usernameBlackRegexp, 'message' => Yii::t('site', 'Username contains not allowed characters or words.')],
            ['password', 'string', 'max' => 255, 'min'=>8],
            [['password'], StrengthValidator::className(),
                'min' => Yii::$app->params['password_min'],
                'upper' => Yii::$app->params['password_upper'],
                'lower' => Yii::$app->params['password_lower'],
                'digit' => Yii::$app->params['password_digit'],
                'special' => Yii::$app->params['password_special'],
                'hasUser' => Yii::$app->params['password_hasUser'],
                'hasEmail' => Yii::$app->params['password_hasEmail']
            ],
            ['repeat_password', 'compare', 'compareAttribute' => 'password'],

            // [['reCaptcha'], \himiklab\yii2\recaptcha\ReCaptchaValidator::className(),],
            

        ];

        return $rules;
    }

    /**
     * Remove possible XSS stuff
     *
     * @param $attribute
     */
    public function purgeXSS($attribute)
    {
        $this->$attribute = Html::encode($this->$attribute);
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'username' => Yii::t('site', 'Username'),
            'email' => Yii::t('site', 'Email'),
            'first_name' => Yii::t('site', 'First Name'),
            'last_name' => Yii::t('site', 'Last Name'),
            'password' => Yii::t('site', 'Password'),
            'repeat_password' => Yii::t('site', 'Repeat password'),
            'captcha' => Yii::t('site', 'Captcha'),
            'phone' => Yii::t('site', 'Phone'),
        ];
    }

    /**
     * @param bool $performValidation
     *
     * @return bool|User
     */
    public function signup($performValidation = true)
    {
        if ($performValidation AND !$this->validate()) {
            return false;
        }

        $user = new User();
        $user->password = $this->password;
        $user->username = $this->email;
        $user->email = $this->email;
        $user->first_name = $this->first_name;
        $user->last_name = $this->last_name;
        $user->phone = $this->phone;

        if (Yii::$app->yee->emailConfirmationRequired) {
            $user->status = User::STATUS_ACTIVE;
            $user->generateConfirmationToken();
            // $user->save(false);

            if (!$this->sendConfirmationEmail($user)) {
                $this->addError('username', Yii::t('site', 'Could not send confirmation email'));
            }
        }

        if (!$user->save()) {
            $this->addError('username', Yii::t('site', 'Login has been taken'));
        } else {
            return $user;
        }

        return FALSE;
    }

    /**
     * @param User $user
     *
     * @return bool
     */
    protected function sendConfirmationEmail($user)
    {
        return Yii::$app->mailer->compose(Yii::$app->yee->emailTemplates['signup-confirmation'], ['user' => $user])
            ->setFrom(Yii::$app->yee->emailSender)
            ->setTo($user->email)
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
    public function checkConfirmationToken($token)
    {
        $user = User::findEmailNotConfirmedByConfirmationToken($token);

        if ($user) {
            
            $user->status = User::STATUS_ACTIVE;
            $user->email_confirmed = 1;
            $user->removeConfirmationToken();
            $user->save(false);
            $user->assignRoles(Yii::$app->yee->defaultRoles);
            //Yii::$app->user->login($user);

            return $user;
        }

        return false;
    }

    /**
     * Check received confirmation token and if user found - activate it, set username, roles and log him in
     *
     * @param string $token
     *
     * @return bool|User
     */
    public function checkExistingConfirmationToken($token)
    {
        return User::findEmailNotConfirmedByConfirmationTokenWithoutValidateToken($token);
    }

    public function validateToken($token)
    {
        //$expire = Yii::$app->yee->confirmationTokenExpire;
        $expire = Yii::$app->settings->get('site.confirmation_token_expire');

        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        
        if ($timestamp + $expire < time()) {
            // token expired
            return false;
        }
        return true;

    }

    public function activateEmailConfirmation($user)
    {
            
        $user->status = User::STATUS_ACTIVE;
        $user->email_confirmed = 1;
        $user->removeConfirmationToken();
        $user->save(false);
        $user->assignRoles(Yii::$app->yee->defaultRoles);
        //Yii::$app->user->login($user);

        return $user;
    }


    public function resendConfirmationEmail($user)
    {
        $user->generateConfirmationToken();
        $user->save(false);
        $this->sendConfirmationEmail($user);
    }


}