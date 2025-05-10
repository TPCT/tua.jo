<?php

namespace yeesoft\auth\controllers;

// use common\helpers\JPA_WS\JPA_WS;
use common\helpers\Utility;
use common\helpers\ZainSms;
use yeesoft\auth\assets\AvatarAsset;
use yeesoft\auth\AuthModule;
use yeesoft\auth\helpers\AvatarHelper;
use yeesoft\auth\models\Auth;
use yeesoft\auth\models\forms\ConfirmEmailForm;
use yeesoft\auth\models\forms\ConfirmSmsForm;
use yeesoft\auth\models\forms\LoginForm;
use yeesoft\auth\models\forms\ResetPasswordForm;
use yeesoft\auth\models\forms\SetEmailForm;
use yeesoft\auth\models\forms\SetPasswordForm;
use yeesoft\auth\models\forms\SetUsernameForm;
use yeesoft\auth\models\forms\SignupForm;
use yeesoft\auth\models\forms\UpdatePasswordForm;
use yeesoft\components\AuthEvent;
use yeesoft\controllers\BaseController;
use common\models\User;
use yeesoft\widgets\ActiveForm;
use Yii;
use yii\base\DynamicModel;
use yii\base\Exception;
use yii\base\Security;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\web\UploadedFile;

class DefaultController extends BaseController
{
    /**
     * @var array
     */
    public $freeAccessActions = 
    [
        'login', /*'signup', 'confirm-registration-email', 'reset-password', 'reset-password-request',
        'send-new-token', 'profile', 'update-password'
        /* 'logout', 'confirm-email', 'captcha', 'oauth', 'update-password',  'confirm-sms',
        'confirm-registration-sms', 'confirm-email-receive','reset-password-by-sms',
        'set-email', 'set-username', 'set-password',  'upload-avatar', 'remove-avatar',
        'unlink-oauth'*/
    ];

    /**
     * @return array
     */
    public function actions()
    {
        return [
//            'captcha' => Yii::$app->yee->captchaAction,
            'oauth' => [
                'class' => 'yeesoft\auth\AuthAction',
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
        ];
    }

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                    'upload-avatar' => ['post'],
                    'remove-avatar' => ['post'],
                ],
            ],
        ]);
    }

    public function onAuthSuccess($client)
    {
        $source = $client->getId();
        $userAttributes = $client->getUserAttributes();

        if (!isset($this->module->attributeParsers[$source])) {
            throw \yii\base\InvalidConfigException("There are no settings for '{$source}' in the AuthModule::attributeParsers.");
        }

        $attributes = $this->module->attributeParsers[$source]($userAttributes);
        $attributes['username'] = $attributes['email'];//use email as username

        Yii::$app->session->set(AuthModule::PARAMS_SESSION_ID, $attributes);

        /* @var $auth Auth */
        $auth = Auth::find()->where([
            'source' => $attributes['source'],
            'source_id' => $attributes['source_id'],
        ])->one();

        if (Yii::$app->user->isGuest) {
            if ($auth) { // login
                $user = $auth->user;
                Yii::$app->user->login($user);
            } else { // signup
                if (isset($attributes['email']) && $attributes['email'] && User::find()->where(['email' => $attributes['email']])->exists()) {
                    Yii::$app->getSession()->setFlash('error', [
                        Yii::t('site', "User with the same email as in {client} account already exists but isn't linked to it. Login using email first to link it.", ['client' => $client->getTitle()]),
                    ]);
                    Yii::$app->getResponse()->redirect(['auth/default/login']);
                } else {
                    return $this->createUser($attributes);
                }
            }
        } else { // user already logged in
            if (!$auth) { // add auth provider
                $auth = new Auth([
                    'user_id' => Yii::$app->user->id,
                    'source' => $attributes['source'],
                    'source_id' => $attributes['source_id'],
                ]);
                $auth->save();
            }
        }
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionSetEmail()
    {
        $attributes = Yii::$app->session->get(AuthModule::PARAMS_SESSION_ID);

        if (!Yii::$app->user->isGuest || !$attributes || !is_array($attributes)) {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        $model = new SetEmailForm();

        if (Yii::$app->request->isAjax AND $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) AND $model->validate()) {
            $attributes['email'] = $model->email;
            Yii::$app->session->set(AuthModule::PARAMS_SESSION_ID, $attributes);
            return $this->createUser($attributes);
        }

        return $this->renderIsAjax('set-email', compact('model'));
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionSetUsername()
    {
        $attributes = Yii::$app->session->get(AuthModule::PARAMS_SESSION_ID);

        if (!Yii::$app->user->isGuest || !$attributes || !is_array($attributes)) {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        $model = new SetUsernameForm();

        if (Yii::$app->request->isAjax AND $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) AND $model->validate()) {
            $attributes['username'] = $model->username;
            Yii::$app->session->set(AuthModule::PARAMS_SESSION_ID, $attributes);
            return $this->createUser($attributes);
        }

        return $this->renderIsAjax('set-username', compact('model'));
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionSetPassword()
    {
        $attributes = Yii::$app->session->get(AuthModule::PARAMS_SESSION_ID);

        if (!Yii::$app->user->isGuest || !$attributes || !is_array($attributes)) {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        $model = new SetPasswordForm();

        if (Yii::$app->request->isAjax AND $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) AND $model->validate()) {
            $attributes['password'] = $model->password;
            Yii::$app->session->set(AuthModule::PARAMS_SESSION_ID, $attributes);
            return $this->createUser($attributes);
        }

        return $this->renderIsAjax('set-password', compact('model'));
    }

    protected function createUser($attributes)
    {
        $auth = [
            'source' => (string)$attributes['source'],
            'source_id' => (string)$attributes['source_id'],
        ];

        unset($attributes['source']);
        unset($attributes['source_id']);

        $attributes['repeat_password'] = isset($attributes['password']) ? $attributes['password'] : NULL;

        $user = new User($attributes);

        $user->setScenario(User::SCENARIO_NEW_USER);
        $user->generateAuthKey();
        //Added By Abujoudeh. Auto password on social login
        $security = new Security();
        try {
            $user->setPassword($security->generateRandomString());
        } 
        catch (Exception $e) 
        {
            error_log($e->getMessage());
        }
        //$user->generatePasswordResetToken();

        $transaction = $user->getDb()->beginTransaction();

        if ($user->save()) {

            $auth = new Auth([
                'user_id' => $user->id,
                'source' => $auth['source'],
                'source_id' => $auth['source_id'],
            ]);

            if ($auth->save()) {
                $transaction->commit();
                Yii::$app->user->login($user);
            } else {
                Yii::$app->session->setFlash('error', 'Error 901: ' . Yii::t('site', "Authentication error occurred."));
                return Yii::$app->response->redirect(Url::to(['/auth/default/login']));
            }
        } else {

            $errors = $user->getErrors();
            $fields = ['username', 'email', 'password'];

            foreach ($fields as $field) {
                if (isset($errors[$field])) {
                    Yii::$app->session->setFlash('error', $user->getFirstError($field));
                    return Yii::$app->response->redirect(Url::to(['/auth/default/set-' . $field]));
                }
            }

            Yii::$app->session->setFlash('error', 'Error 902: ' . Yii::t('site', "Authentication error occurred."));
            return Yii::$app->response->redirect(Url::to(['/auth/default/login']));
        }

        Yii::$app->session->remove(AuthModule::PARAMS_SESSION_ID);
        return Yii::$app->response->redirect(Url::to(['/']));
    }

    /**
     * Login form
     *
     * @return string
     */
    public function actionLogin()
    {
//        $this->layout = 'auth';

        if (!Yii::$app->user->isGuest) {
            return $this->goBack();
        }
        $model = new LoginForm();

        //Clean User Input
        $params = Utility::sanitize(Yii::$app->request->post('LoginForm', []));

        if(Yii::$app->request->post())
        {
            if (Yii::$app->request->isAjax AND $model->load(['LoginForm' => $params], 'LoginForm')) 
            {
                Yii::$app->response->format = Response::FORMAT_JSON;
                ActiveForm::validate($model);
                if ($model->load(['LoginForm' => $params], 'LoginForm') AND $model->login())
                {
                    return json_encode(["success"=>"success","message"=>Yii::t("site","Logged In Successfully")]);
                }
                return json_encode(["success"=>"faild","message"=>Yii::t("site","Not VAlid") ,"errors"=>$model->errors, 'model'=>'LoginForm' ]);

                //return ActiveForm::validate($model);
            }
            if ($model->load(['LoginForm' => $params], 'LoginForm') AND $model->login()) 
            {
                return $this->goBack();
            }
        }
        
        return $this->renderIsAjax('login', compact('model'));

    }

    /**
     * Logout and redirect to home page
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();
        Yii::$app->cache->flush();

        return $this->redirect(Yii::$app->homeUrl);
    }

    /**
     * Signup page
     *
     * @return string
     */
    public function actionSignup()
    {
        if (Yii::$app->id == 'backend')
        {
            return $this->redirect(Yii::$app->homeUrl);
        }

        if (!Yii::$app->user->isGuest) {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }
        //Clean User Input
        $params = Utility::sanitize(Yii::$app->request->post('SignupForm', []));

        $model = new SignupForm();
        
        if(Yii::$app->request->post())
        {
            if (Yii::$app->request->isAjax AND $model->load(['SignupForm' => $params], 'SignupForm')) 
            {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return $model->validate();
            }

            if ($model->load(['SignupForm' => $params], 'SignupForm') AND $model->validate()) 
            {
                // Trigger event "before registration" and checks if it's valid
                if ($this->triggerModuleEvent(AuthEvent::BEFORE_REGISTRATION, ['model' => $model])) {
                    $user = $model->signup(false);
                    // Trigger event "after registration" and checks if it's valid
                    if ($user && $this->triggerModuleEvent(AuthEvent::AFTER_REGISTRATION, ['model' => $model, 'user' => $user])) {
                        if (Yii::$app->yee->emailConfirmationRequired) 
                        {
                            return $this->renderIsAjax('signup-confirmation', compact('user'));
                        } 
                        else 
                        {
                            $user->assignRoles(Yii::$app->yee->defaultRoles);
                            Yii::$app->user->login($user);
                            return $this->redirect(Yii::$app->user->returnUrl);
                        }
                    }
                }
            }

        }

        // echo "<pre>"; print_r($model); die();

        return $this->renderIsAjax('signup', compact('model'));
    }

    /**
     * Receive token after registration, find user by it and confirm email
     *
     * @param string $token
     *
     * @throws \yii\web\NotFoundHttpException
     * @return string|\yii\web\Response
     */
    public function actionConfirmRegistrationEmail($token)
    {
        if (Yii::$app->yee->emailConfirmationRequired) 
        {
            $currentRoute = Url::to(Yii::$app->request->getUrl(),true) ;

            
            $model = new SignupForm();
            
            $user = $model->checkExistingConfirmationToken($token);

            if($user)
            {
                $data['validToken'] = $model->validateToken($token);
                $data['user'] = $user;

                if($data["validToken"])
                {
                    $data['user'] = $model->activateEmailConfirmation($user);
                }

                
                return $this->renderIsAjax('confirm-email-success', $data);

            }

            throw new NotFoundHttpException(Yii::t('site', 'PAGE_NOT_FOUND'));
        }
    }

    public function actionSendNewToken($token)
    {
        if (Yii::$app->yee->emailConfirmationRequired) 
        {
            $currentRoute = Url::to(Yii::$app->request->getUrl(),true) ;

            
            $model = new SignupForm();

            $user = $model->checkExistingConfirmationToken($token);

            if($user)
            {
                $model->resendConfirmationEmail($user);

                return $this->renderIsAjax('resend-email-confirmation', compact('user'));
            }

            throw new NotFoundHttpException(Yii::t('site', 'PAGE_NOT_FOUND'));
        }
    }

    /**
     * Receive token after registration, find user by it and confirm email
     *
     * @param string $token
     *
     * @throws \yii\web\NotFoundHttpException
     * @return string|\yii\web\Response|array
     */
    public function actionConfirmRegistrationSms()
    {
        if (!Yii::$app->user->isGuest) {
            $this->goHome();
        }

        if (Yii::$app->yee->smsConfirmationRequired) {
            $model = new ConfirmSmsForm();

            if (Yii::$app->request->isAjax AND $model->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }

            if ($model->load(Yii::$app->request->post()) AND $model->validate()) {
                $user = $model->user;
                if ($user) {
                    $user->status = User::STATUS_ACTIVE;
                    $user->save(false);
                    $user->assignRoles(Yii::$app->yee->defaultRoles);

                    Yii::$app->user->login($user);

                    return $this->renderIsAjax('confirm-sms-success', compact('user'));
                }
            }
            throw new NotFoundHttpException(Yii::t('site', 'Token not found. It may be expired'));
        }
    }

    /**
     * Change your own password
     *
     * @throws \yii\web\ForbiddenHttpException
     * @return string|\yii\web\Response
     */
    public function actionUpdatePassword()
    {
        if (Yii::$app->user->isGuest) {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        $user = User::getCurrentUser();

        if ($user->status != User::STATUS_ACTIVE) {
            throw new ForbiddenHttpException();
        }

        $model = new UpdatePasswordForm(compact('user'));

        if (Yii::$app->request->isAjax AND $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) AND $model->updatePassword()) {
            return $this->renderIsAjax('update-password-success');
        }

        return $this->renderIsAjax('update-password', compact('model'));
    }

    /**
     * Action to reset password
     *
     * @return string|\yii\web\Response
     */
    public function actionResetPassword()
    {
        
        if (Yii::$app->id == 'backend')
        {
            return $this->redirect(Yii::$app->homeUrl);
        }


        if (!Yii::$app->user->isGuest) {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        $model = new ResetPasswordForm();

        if (Yii::$app->request->isAjax AND $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $model->validate();
        }

        if ($model->load(Yii::$app->request->post()) AND $model->validate()) {
            if ($this->triggerModuleEvent(AuthEvent::BEFORE_PASSWORD_RECOVERY_REQUEST, ['model' => $model])) {
                if ($model->sendEmail(false)) {
                    if ($this->triggerModuleEvent(AuthEvent::AFTER_PASSWORD_RECOVERY_REQUEST, ['model' => $model])) {
                        return $this->renderIsAjax('reset-password-success');
                    }
                } else {
                    Yii::$app->session->setFlash('error', Yii::t('site', "Unable to send message for email provided"));
                }
            }
        }

        return $this->renderIsAjax('reset-password', compact('model'));
    }

    /**
     * Action to reset password
     *
     * @return string|\yii\web\Response
     */
    public function actionResetPasswordBySms()
    {
        if (!Yii::$app->user->isGuest) {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }
        $model = new ResetPasswordForm();

        if (Yii::$app->request->isAjax AND $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $model->validate();
        }

        if ($model->load(Yii::$app->request->post()) AND $model->validate()) {

            //Send SMS
            $model->user->generateConfirmationToken();
            $model->user->save(false);

            $parts = explode('_', $model->user->confirmation_token);
            $smsCode = (int)($parts[0]);

            ZainSms::Send('', $smsCode);

            $this->redirect(['/auth/reset-password-request', 'token' => Utility::encrypt_decrypt('encrypt', $model->user->confirmation_token)]);

        }

        return $this->renderIsAjax('reset-password', compact('model'));
    }

    /**
     * Receive token, find user by it and show form to change password
     *
     * @param string $token
     *
     * @throws \yii\web\NotFoundHttpException
     * @return string|\yii\web\Response
     */
    public function actionResetPasswordRequest($token)
    {
        if (Yii::$app->id == 'backend')
        {
            return $this->redirect(Yii::$app->homeUrl);
        }
        
        //Decrypt $token
        $token =  Utility::encrypt_decrypt('decrypt', $token);
        if (!Yii::$app->user->isGuest) {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        $user = User::findByConfirmationToken($token);

        if (!$user) {
            Yii::$app->session->setFlash('error', Yii::t('site', 'Token not found. It may be expired. Try reset password once more'));
            $this->goHome();
        }



        $model = new UpdatePasswordForm([
            'user' => $user,
        ]);
        $model->scenario = "restoreViaEmail";


        if (Yii::$app->request->isAjax AND $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }


        if ($model->load(Yii::$app->request->post()) AND $model->validate()) {
            if ($this->triggerModuleEvent(AuthEvent::BEFORE_PASSWORD_RECOVERY_COMPLETE, ['model' => $model])) {
                $model->updatePassword(false);

                if ($this->triggerModuleEvent(AuthEvent::AFTER_PASSWORD_RECOVERY_COMPLETE, ['model' => $model])) {
                    Yii::$app->session->setFlash('success', Yii::t('yii', 'Password updated.'));

                    return $this->redirect('/');
                }
            }
        }

        return $this->renderIsAjax('update-password-request', compact('model'));
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionConfirmSms()
    {
//        if (Yii::$app->user->isGuest) {
//            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
//        }
//
//        $user = User::getCurrentUser();
//
//        if ($user->email_confirmed == 1) {
//            return $this->renderIsAjax('confirmEmailSuccess', compact('user'));
//        }
//
        $model = new ConfirmSmsForm([
//            'email' => $user->email,
//            'user' => $user,
        ]);

        if (Yii::$app->request->isAjax AND $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) AND $model->validate()) {
//            if ($this->triggerModuleEvent(AuthEvent::BEFORE_EMAIL_CONFIRMATION_REQUEST, ['model' => $model])) {
//                if ($model->sendEmail(false)) {
//                    if ($this->triggerModuleEvent(AuthEvent::AFTER_EMAIL_CONFIRMATION_REQUEST, ['model' => $model])) {
            $user = User::findOne(2);
            Yii::$app->user->login($user);

            return $this->goHome();
//                    }
//                } else {
//                    Yii::$app->session->setFlash('error', Yii::t('site', "Unable to send message for email provided"));
//                }
//            }
        }

        return $this->renderIsAjax('confirm-sms', ['smsConfirm' => $model]);
    }


    /**
     * @return string|\yii\web\Response
     */
    public function actionConfirmEmail()
    {
        if (Yii::$app->user->isGuest) {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        $user = User::getCurrentUser();

        if ($user->email_confirmed == 1) {
            return $this->renderIsAjax('confirmEmailSuccess', compact('user'));
        }

        $model = new ConfirmEmailForm([
            'email' => $user->email,
            'user' => $user,
        ]);

        if (Yii::$app->request->isAjax AND $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) AND $model->validate()) {
            if ($this->triggerModuleEvent(AuthEvent::BEFORE_EMAIL_CONFIRMATION_REQUEST, ['model' => $model])) {
                if ($model->sendEmail(false)) {
                    if ($this->triggerModuleEvent(AuthEvent::AFTER_EMAIL_CONFIRMATION_REQUEST, ['model' => $model])) {
                        return $this->refresh();
                    }
                } else {
                    Yii::$app->session->setFlash('error', Yii::t('site', "Unable to send message for email provided"));
                }
            }
        }

        return $this->renderIsAjax('confirm-email', compact('model'));
    }


    /**
     * Receive token, find user by it and confirm email
     *
     * @param string $token
     *
     * @throws \yii\web\NotFoundHttpException
     * @return string|\yii\web\Response
     */
    public function actionConfirmEmailReceive($token)
    {
        $user = User::findByConfirmationToken($token);

        if (!$user) {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        $user->email_confirmed = 1;
        $user->removeConfirmationToken();
        $user->save(false);

        return $this->renderIsAjax('confirm-email-success', compact('user'));
    }

    /**
     * Universal method for triggering events like "before registration", "after registration" and so on
     *
     * @param string $eventName
     * @param array $data
     *
     * @return bool
     */
    protected function triggerModuleEvent($eventName, $data = [])
    {
        $event = new AuthEvent($data);

        Yii::$app->yee->trigger($eventName, $event);

        return $event->isValid;
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionProfile()
    {
        

//        if ($this->module->profileLayout) {
//            $this->layout = $this->module->profileLayout;
//        }

        if (Yii::$app->user->isGuest) {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        $model = User::findIdentity(Yii::$app->user->id);

        if ($model->load(Yii::$app->request->post()) AND $model->save()) {
            Yii::$app->session->setFlash('success', Yii::t('yii', 'Your item has been updated.'));
        }

        return $this->renderIsAjax('profile', compact('model'));
    }

    public function actionUploadAvatar()
    {
        if (Yii::$app->user->isGuest) {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = new DynamicModel(['image']);
        $model->addRule('image', 'file', ['skipOnEmpty' => false, 'extensions' => 'png, jpg']);

        if (Yii::$app->request->isPost) {
            $model->image = UploadedFile::getInstanceByName('image');

            if ($model->validate()) {
                try {
                    return AvatarHelper::saveAvatar($model->image);
                } catch (Exception $exc) {
                    Yii::$app->response->statusCode = 400;
                    return Yii::t('yee', 'An unknown error occurred.');
                }
            } else {
                $errors = $model->getErrors();
                Yii::$app->response->statusCode = 400;
                return $model->getFirstError(key($errors));
            }
        }

        return;
    }

    public function actionRemoveAvatar()
    {
        if (Yii::$app->user->isGuest) {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        Yii::$app->response->format = Response::FORMAT_JSON;

        try {
            Yii::$app->user->identity->removeAvatar();
            AvatarAsset::register($this->view);
            return AvatarAsset::getDefaultAvatar('large');
        } catch (Exception $exc) {
            error_log($exc->getMessage());
            Yii::$app->response->statusCode = 400;
            return 'Error occured!';
        }

        return;
    }

    public function actionUnlinkOauth($redirectUrl = null)
    {
        if (Yii::$app->user->isGuest) {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        $client = Yii::$app->getRequest()->get('authclient');
        if (!Auth::unlinkClient($client)) {
            Yii::$app->session->addFlash('error', 'Error cant unlink');
        }

        if ($redirectUrl === null) {
            $redirectUrl = ['/auth/default/profile'];
        }

        return $this->redirect($redirectUrl);
    }
}