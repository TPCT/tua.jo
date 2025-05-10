<?php

namespace api\modules\v1\controllers;

use common\helpers\Utility;
use common\models\User;
use Yii;
use yii\rest\Controller;
use yii\web\Response;

class DefaultController extends Controller
{

    public $accessToken;
    public $confirmationToken;
    public $user;
    public $subscription;
    public $userDeviceID;


    public function beforeAction($action)
    {
        //Just to solve request from browser
        header('Access-Control-Allow-Origin: http://yiidocgen.dev.dot.jo');

        $return = parent::beforeAction($action);
        Yii::$app->response->format = Response::FORMAT_JSON;


        //Check user status if logged in or not
        $request = Yii::$app->request;
        $this->accessToken = $request->post('accessToken');
        $this->confirmationToken = $request->post('confirmationToken');
        Yii::$app->language = $request->post('lng', 'ar');
        Yii::$app->formatter->locale = Yii::$app->language;

        $this->user = User::findIdentityByAccessToken($this->accessToken);

        if (Yii::$app->params['ADD_API_LOG']) {
            Utility::ADD_API_LOG($request->getAbsoluteUrl(), $request->post(), $this->user);
        }

        if ($this->user) {
            if ($this->user->status == 0) {
                return ([
                    'Status' => 'S400',
                    'Data' => json_decode("{}"),
                    'Error' => [
                        Yii::t('site', 'User account is disabled')
                    ],
                    'Extra' => json_decode("{}")
                ]);
                return false;
            }

            Yii::$app->user->switchIdentity($this->user);
        }


        return $return;
    }


}
