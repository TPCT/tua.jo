<?php

namespace frontend\modules\account\models\guarantees\forms;

use backend\modules\sponsorship_families\models\SponsorshipFamilies;
use backend\modules\webforms\models\RequestCallWebform;
use backend\modules\webforms\models\RequestVisitWebform;
use borales\extensions\phoneInput\PhoneInputValidator;
use frontend\modules\account\models\client\Client;
use libphonenumber\PhoneNumberUtil;
use Yii;
use yii\base\Model;

class RequestVisitForm extends Model
{
    public $name;
    public $phone;
    public $email;
    public $date;
    public $message;
    public $family_id;



    public function rules()
    {
        return [
            [['name', 'phone', 'email', 'family_id', 'date'], 'required'],
            [['name', 'message'], 'string', 'max' => 255],
            [['email'], 'email'],
            [['phone'], 'string', 'max' => 20],
            [['phone'], 'number'],
            [['phone'], PhoneInputValidator::className()],
            [['family_id'], 'exist', 'skipOnError' => true, 'targetClass' => SponsorshipFamilies::className(), 'targetAttribute' => ['family_id' => 'id']],
            [['date'], 'datetime', 'format' => 'php:Y-m-d H:i:s'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => Yii::t('site', 'Name'),
            'phone' => Yii::t('site', 'Phone'),
            'email' => Yii::t('site', 'Email'),
            'date' => Yii::t('site', 'Date'),
            'message' => Yii::t('site', 'Message'),
        ];
    }

    public function save(){
        if ($this->validate()){
            $form = new RequestVisitWebform();
            $form->name = $this->name;
            $form->phone = $this->phone;
            $form->email = $this->email;
            $form->client_id = Yii::$app->user->id;
            $form->sponsorship_family_id = $this->family_id;
            $form->date = (new \DateTime($this->date))->getTimestamp();
            $form->message = $this->message;
            return $form->save(false);
        }
    }
}