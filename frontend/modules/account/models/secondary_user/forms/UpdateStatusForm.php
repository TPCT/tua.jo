<?php

namespace frontend\modules\account\models\secondary_user\forms;

use frontend\modules\account\models\secondary_user\SecondaryUser;
use yii\base\Model;

class UpdateStatusForm extends Model
{
    public $guid;
    public $status;

    public function rules()
    {
        return [
            [['guid', 'status'], 'required'],
            [['guid'], 'uniqueGuidValidation'],
            [['status'], 'boolean']
        ];
    }

    public function uniqueGuidValidation($attribute, $params){
        $exists = (new \yii\db\Query())
            ->from('secondary_users')
            ->where(['guid' => $this->$attribute])
            ->exists();

        if (!$exists) {
            $this->addError($attribute, \Yii::t('site', 'This guid is not registered.'));
        }
    }

    public function attributeLabels()
    {
        return [
            'guid' => 'Guid',
            'status' => 'Status',
        ];
    }

    public function update(){
        if ($this->validate()) {
            $secondary_user = SecondaryUser::findOne(['guid' => $this->guid]);
            return $secondary_user->updateAttributes([
                'status' => $this->status,
            ]);
        }
    }
}