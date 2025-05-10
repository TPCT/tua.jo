<?php

namespace frontend\controllers;

use common\components\TuaClient;
use frontend\components\HyperPay;
use frontend\modules\account\models\client\Client;
use Yii;
use common\helpers\Utility;
use backend\modules\webforms\models\DonationGiftWebform;
use backend\modules\e_card\models\ECard;
use common\components\traits\ArticleSchemaTrait;
use yii\helpers\ArrayHelper;


/**
 * BlogController
 */
class DonateChildGiftController extends \yeesoft\controllers\BaseController
{
    use ArticleSchemaTrait;

    public $freeAccess = true;

    public function actionIndex(){
        return $this->render('index', []);
    }
}