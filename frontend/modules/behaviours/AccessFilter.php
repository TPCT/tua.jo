<?php

namespace frontend\modules\behaviours;

use Mpdf\Tag\U;
use yeesoft\helpers\YeeHelper;
use yeesoft\models\OwnerAccess;
use yeesoft\models\Route;
use yeesoft\models\User;
use Yii;
use yii\base\Action;
use yii\base\ActionFilter;
use yii\helpers\Url;
use yii\web\ForbiddenHttpException;

class AccessFilter extends ActionFilter
{
    /**
     * @var callable a callback that will be called if the access should be denied
     * to the current user. If not set, [[denyAccess()]] will be called.
     *
     * The signature of the callback should be as follows:
     *
     * ~~~
     * function ($rule, $action)
     * ~~~
     *
     * where `$rule` is the rule that denies the user, and `$action` is the current [[Action|action]] object.
     * `$rule` can be `null` if access is denied because none of the rules matched.
     */
    public $denyCallback;

    /**
     * Check if user has access to current route
     *
     * @param Action $action the action to be executed.
     *
     * @return boolean whether the action should continue to be executed.
     */
    public function beforeAction($action)
    {

        if ($action->controller->id == "secondary-users" && in_array($action->id, ['create', 'update-status']))
            return true;

        if ($action->controller->id == "auth" && in_array($action->id, ['login', 'logout', 'register', 'forget-password'])) {
            return true;
        }
        if (!Yii::$app->user->isGuest && (Yii::$app->user->identity === null || Yii::$app->user->identity->status != User::STATUS_ACTIVE)) {
            Yii::$app->session->destroy();
            $this->denyAccess();
        }

        if (!Yii::$app->user->isGuest)
            return true;

        if (isset($this->denyCallback)) {
            call_user_func($this->denyCallback, null, $action);
        } else {
            $this->denyAccess();
        }

        return false;
    }

    /**
     * Denies the access of the user.
     * The default implementation will redirect the user to the login page if he is a guest;
     * if the user is already logged, a 403 HTTP exception will be thrown.
     *
     * @throws ForbiddenHttpException if the user is already logged in.
     */
    protected function denyAccess()
    {
        if (Yii::$app->user->getIsGuest()) {
            Yii::$app->response->redirect(['account/login']);
        }
    }
}