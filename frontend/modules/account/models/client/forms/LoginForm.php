<?php

namespace frontend\modules\account\models\client\forms;

use frontend\modules\account\models\client\Client;
use yii\base\Model;
use Yii;

class LoginForm extends Model
{
    public $email;
    public $password;

    private ?Client $_client = null;

    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            [['email'], 'email'],
            [['email'], 'validateEmailExists'],
            [['password'], 'string', 'max' => 255],
            [['password'], 'validatePassword'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' =>  Yii::t('site', 'LOGIN_EMAIL') ,
            'password' =>  Yii::t('site', 'LOGIN_PASSWORD')
        ];
    }

    public function validateEmailExists($attribute, $params)
{
    if (!$this->hasErrors()) {
        $client = Client::findOne(['email' => $this->email]);
        if (!$client) {
            $this->addError($attribute, \Yii::t('site', 'EMAIL_NOT_FOUND'));
        }
    }
}

    public function validatePassword($attribute, $params){
        if (!$this->hasErrors()) {
            $client = $this->getClient();
            if (!$client || !$client->validatePassword($this->password)) {
                $this->addError($attribute, \Yii::t('site', 'INCORRECT_EMAIL_OR_PASSWORD'));
            }
        }
    }

    public function getClient(){
        if (!$this->_client)
            $this->_client = Client::findByEmail($this->email);
        return $this->_client;
    }
    public function login(){
        if ($this->validate())
            return \Yii::$app->user->login($this->getClient(), 3600*24*30);
        return false;
    }
}