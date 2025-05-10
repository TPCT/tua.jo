<?php

namespace common\models;

use common\helpers\JPA_WS\JPA_Profile;
use common\helpers\JPA_WS\JPA_WS;
use yeesoft\helpers\Html;
use Yii;

class User extends \yeesoft\models\User
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
        ]);
    }

    /**
     * @param string $id user_id from audit_entry table
     * @return mixed|string
     */
    public static function userIdentifierCallback($id)
    {
        $user = self::findOne($id);
        return $user ? Html::a($user->username, ['/user/update', 'id' => $user->id]) : $id;
    }

    public function __toString()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    public function getFullName()
    {
        return $this->__toString();
    }

    public function setProfile()
    {

    }

    public function getProfile()
    {

        if(Yii::$app->id != 'JPA-API' )
            $userProfile = Yii::$app->session->get('__currentUserProfile');

        if (!$userProfile) {
            $profile = new JPA_Profile();

            $jsonResponse = JPA_WS::getProfile($this->username);
            $profile->load(['JPA_Profile' => $jsonResponse], 'JPA_Profile');
            $userProfile = $profile;

            if(Yii::$app->id != 'JPA-API' )
                Yii::$app->session->set('__currentUserProfile', $profile);
        }


        return $userProfile;
    }

}
