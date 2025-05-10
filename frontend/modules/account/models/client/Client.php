<?php

namespace frontend\modules\account\models\client;

use backend\modules\recurring_items\models\RecurringItems;
use common\models\Countries;
use frontend\modules\account\models\card\Card;
use frontend\modules\account\models\secondary_user\SecondaryUser;
use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\web\IdentityInterface;

class Client extends ActiveRecord implements IdentityInterface
{
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    public function rules()
    {
        return [
            [['email', 'password', 'first_name', 'last_name', 'nationality_id', 'residency_id', 'country_code', 'phone', 'gender', 'auth_key', 'access_token'], 'required'],
            [['email'], 'email'],
            [['email'], 'unique'],
            [['nationality_id', 'residency_id', 'created_at', 'updated_at'], 'integer'],
            [['password', 'first_name', 'last_name', 'phone', 'gender', 'auth_key', 'access_token'], 'string', 'max' => 255],
            [['gender'], 'in', 'range' => ['Male', 'Female']],
            [['country_code'], 'string', 'max' => 5],
            [['nationality_id'], 'exist', 'skipOnError' => true, 'targetClass' => Countries::class, 'targetAttribute' => ['nationality_id' => 'id']],
            [['residency_id'], 'exist', 'skipOnError' => true, 'targetClass' => Countries::class, 'targetAttribute' => ['residency_id' => 'id']],
            
            [['first_name','last_name'],'match', 'pattern' => "/^[a-zA-Z\s \x{0600}-\x{06FF}]+$/u",],
        ];
    }

    public static function tableName()
    {
        return '{{%clients}}';
    }

    public function getNationality()
    {
        return $this->hasOne(Countries::class, ['id' => 'nationality_id']);
    }

    public function getResidency()
    {
        return $this->hasOne(Countries::class, ['id' => 'residency_id']);
    }

    public function getSecondaryUsers(){
        return $this->hasMany(SecondaryUser::class, ['parent_id' => 'id'])->where([
            'status' => 1
        ]);
    }

    public function getCards(){
        return $this->hasMany(Card::class, ['parent_id' => 'id']);
    }

    public function getRecurringItems(){
        return $this->hasMany(RecurringItems::class, ['client_id' => 'id']);
    }

    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return self::findOne(['access_token' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName(){
        return $this->first_name . " " . $this->last_name;
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->auth_key == $authKey;
    }

    public static function findByEmail($email){
        return self::findOne(['email' => strtolower($email)]);
    }

    public function validatePassword($password){
        return Yii::$app->security->validatePassword($password, $this->password);
    }

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

}
