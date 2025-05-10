<?php

namespace frontend\components\classes;

use backend\modules\redirect_url\models\RedirectUrl;
use Yii;
use yii\web\ErrorAction;

class CustomErrorAction extends ErrorAction
{
    /**
     * Runs the action.
     *
     * @return string result content
     */
    public function run()
    {
        if ($this->layout !== null) {
            $this->controller->layout = $this->layout;
        }

        Yii::$app->getResponse()->setStatusCodeByException($this->exception);

        $data['name'] = Yii::t("site", $this->getExceptionName());
        $data['message'] = Yii::t("site", $this->getExceptionMessage());
        $data['exception'] = $this->exception;

        $code = Yii::$app->response->statusCode;
        $currentRoute = Yii::$app->urlManager->getHostInfo() . Yii::$app->request->getUrl();
        $redirectUrl = RedirectUrl::find()->active()->andWhere(["url_from"=> $currentRoute,"status_code_from"=>$code])->one();

        if($redirectUrl)
        {
            return Yii::$app->response->redirect( $redirectUrl->url_to ,$redirectUrl->status_code_to);
        }

        if (Yii::$app->getRequest()->getIsAjax()) 
        {
            return $this->getExceptionName() . ': ' . $this->getExceptionMessage();
            return $this->renderAjaxResponse();
        }


        return $this->controller->render($this->view ?: $this->id, $data);
    
    }

    
    
    
}
