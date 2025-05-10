<?php

namespace frontend\modules\account\models\client\forms;

use common\components\TuaClient;
use common\models\Countries;
use frontend\modules\account\models\client\Client;
use frontend\modules\account\models\secondary_user\SecondaryUser;
use libphonenumber\PhoneNumberUtil;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use Yii;
class RegisterForm extends Model
{
    public $email;
    public $password;
    public $confirm_password;

    public $first_name;
    public $last_name;
    public $nationality_id;
    public $residency_id;
    public $country_code;
    public $phone;


    public $gender;

    public function rules()
    {
        return [
            [['email', 'password', 'first_name', 'last_name', 'nationality_id', 'residency_id', 'phone', 'gender'], 'required'],
            [['email'], 'email'],
            [['first_name','last_name'],'match', 'pattern' => "/^[a-zA-Z\s \x{0600}-\x{06FF}]+$/u",],
            [['phone'], 'phoneValidation'],
            [['email'], 'validateUniqueEmail'],
            [['nationality_id', 'residency_id'], 'integer'],
            [['password', 'first_name', 'last_name', 'phone', 'gender'], 'string', 'max' => 255],
            [['gender'] , 'in', 'range' => ['Male', 'Female']],
            ['confirm_password', 'compare', 'compareAttribute' => 'password', 'message' => \Yii::t('site','Passwords do not match')],
            [['nationality_id'], 'exist', 'skipOnError' => true, 'targetClass' => Countries::class, 'targetAttribute' => ['nationality_id' => 'id']],
            [['residency_id'], 'exist', 'skipOnError' => true, 'targetClass' => Countries::class, 'targetAttribute' => ['residency_id' => 'id']],

        ];
    }

    public function phoneValidation($attribute, $params){
        try{
            $phone = PhoneNumberUtil::getInstance()->parse($this->$attribute);
            if (!PhoneNumberUtil::getInstance()->isValidNumber($phone)){
                $this->addError($attribute, \Yii::t('site','Phone number is invalid'));
                return false;
            }

            [$this->country_code, $this->phone] = [(String) $phone->getCountryCode(), $phone->getNationalNumber()];
            $this->country_code = str_replace('+', '', $this->country_code);

            if (Client::find()->where([
                'country_code' => $this->country_code,
                'phone' => $this->phone,
            ])->exists()){
                $this->addError($attribute, \Yii::t('site','Phone number is invalid'));
                return false;
            }

        }catch (\Exception $e){
            $this->addError($attribute, \Yii::t('site','Phone number is invalid'));
        }
    }

    public function validateUniqueEmail($attribute, $params)
    {
        $exists = (new \yii\db\Query())
            ->from('clients')
            ->where(['email' => $this->$attribute])
            ->exists();

        if ($exists) {
            $this->addError($attribute, \Yii::t('site', 'This email is already registered.'));
        }
    }

//    public function validateUniquePhone($attribute, $params){
//        $exists = (new \yii\db\Query())
//            ->from('clients')
//            ->where(['country_code' => $this->country_code, 'phone' => $this->$attribute])
//            ->exists();
//        if ($exists) {
//            $this->addError($attribute, \Yii::t('site', 'This phone number is already registered.'));
//        }
//    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'email' => Yii::t('site', 'REGISTER_EMAIL'),
            'confirm_password' =>  Yii::t('site', 'CONFIRM_PASSWORD') ,
            'password' =>  Yii::t('site', 'REGISTER_PASSWORD') ,
            'first_name' =>  Yii::t('site', 'FIRST_NAME') ,
            'last_name' =>  Yii::t('site', 'LAST_NAME') ,
            'nationality_id' => Yii::t('site', 'NATIONALITY') ,
            'residency_id' => Yii::t('site', 'RESIDENCY') ,
            'country_code' =>  Yii::t('site', 'COUNTRY_CODE') ,
            'phone' =>  Yii::t('site', 'PHONE') ,
            'gender' =>  Yii::t('site', 'GENDER') ,
        ];
    }

    public function register(){
        if ($this->validate()) {
            $client = new Client();
            $client->email = strtolower($this->email);
            $client->first_name = $this->first_name;
            $client->last_name = $this->last_name;
            $client->password = \Yii::$app->security->generatePasswordHash($this->password);
            $client->nationality_id = $this->nationality_id;
            $client->residency_id = $this->residency_id;
            $client->country_code = $this->country_code;
            $client->phone = $this->phone;
            $client->gender = $this->gender;
            $client->auth_key = \Yii::$app->security->generateRandomString();
            $client->access_token = \Yii::$app->security->generateRandomString();
            $response = TuaClient::createContact($client);

            if ($response['success']) {
                $users = $response['response'];
                $client->guid = $users[0]['ContactId'];
                $client->save();
                $client->refresh();

                foreach ($users as $index => $user){
                    if ($index == 0)
                        continue;
                    $secondary_user = SecondaryUser::find()->where(['guid' => $user['ContactId']]);
                    $secondary_user = $secondary_user->exists() ? $secondary_user->one() : new SecondaryUser();
                    $secondary_user->name = $user['Fullname'];
                    $secondary_user->email = $user['Email'];
                    $secondary_user->guid = $user['ContactId'];
                    $secondary_user->parent_id = $client->id;
                    $secondary_user->save(false);
                }
                return true;
            }

            $this->addError('email', \Yii::t('site', 'Email might be already registered'));
            $this->addError('phone', \Yii::t('site', 'phone might be already registered'));
        }
    }

    public static function nationalities(){
        return ArrayHelper::map(Countries::find()->all(), 'id', \Yii::$app->language . '_nationality');
    }

    public static function residencies(){
        return ArrayHelper::map(Countries::find()->orderBy([\Yii::$app->language.'_short_name' => SORT_ASC])->all(), 'id', \Yii::$app->language . '_short_name');
    }
}