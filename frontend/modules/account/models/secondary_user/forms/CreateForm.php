<?php

namespace frontend\modules\account\models\secondary_user\forms;

use frontend\modules\account\models\client\Client;
use frontend\modules\account\models\secondary_user\SecondaryUser;
use yii\base\Model;

class CreateForm extends Model
{
    public $guid;
    public $email;
    public $name;
    public $parent_id;

    public function rules()
    {
        return [
            [['name', 'guid', 'parent_id'], 'required'],
            [['name', 'email'], 'string', 'max' => 255],
            [['guid'], 'uniqueGuidValidation'],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Client::class, 'targetAttribute' => ['parent_id' => 'id']]
        ];
    }

    public function uniqueGuidValidation($attribute, $params){
        $exists = (new \yii\db\Query())
            ->from('secondary_users')
            ->where(['guid' => $this->$attribute])
            ->exists();

        if ($exists) {
            $this->addError($attribute, \Yii::t('site', 'This guid is already registered.'));
        }
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => 'Email',
            'name' => 'Name',
            'guid' => 'Guid',
            'parent_id' => 'Parent ID',
        ];
    }

    public function create(){
        if ($this->validate()) {
            $secondary_user = new SecondaryUser();
            $secondary_user->guid = $this->guid;
            $secondary_user->email = $this->email;
            $secondary_user->name = $this->name;
            $secondary_user->parent_id = $this->parent_id;
            return $secondary_user->save();
        }
    }
}