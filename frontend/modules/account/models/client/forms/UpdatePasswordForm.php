<?php

namespace frontend\modules\account\models\client\forms;

use frontend\modules\account\models\client\Client;
use Yii;
use yii\base\Model;

class UpdatePasswordForm extends Model
{
    public $password;
    public $new_password;
    public $confirm_new_password;

    private ?Client $_client = null;

    public function rules()
    {
        return [
            [['password', 'new_password', 'confirm_new_password'], 'required'],
            [['password', 'new_password', 'confirm_new_password'], 'string', 'max' => 255],
            [['password'], 'validatePassword'],
            ['confirm_new_password', 'compare', 'compareAttribute' => 'new_password', 'message' => \Yii::t('site','Passwords do not match')],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'password' => Yii::t('site','PASSWORD'),
            'new_password' =>  Yii::t('site','NEW_PASSWORD'),
            'confirm_new_password' =>  Yii::t('site','CONFIRM_PASSWORD'),
        ];
    }

    public function validatePassword($attribute, $params){
        if (!$this->hasErrors()) {
            $client = $this->getClient();
            if (!$client || !$client->validatePassword($this->password)) {
                $this->addError($attribute, \Yii::t('site', 'Incorrect password.'));
            }
        }
    }

    public function update(){
        $client = $this->getClient();
        $client->password = Yii::$app->getSecurity()->generatePasswordHash($this->new_password);
        return $client->save(false);
    }

    public function getClient(){
        if (!$this->_client)
            $this->_client = \Yii::$app->user->identity;
        return $this->_client;
    }
}