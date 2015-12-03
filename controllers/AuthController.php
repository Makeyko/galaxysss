<?php

namespace app\controllers;

use app\models\User;
use app\services\EmailChangeDispatcher;
use cs\base\BaseController;
use cs\services\VarDumper;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use yii\web\Request;
use yii\web\Response;
use yii\widgets\ActiveForm;
use app\services\RegistrationDispatcher;
use app\services\PasswordRecoverDispatcher;
use cs\web\Exception;

class AuthController extends BaseController
{
    public $layout = 'menu';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only'  => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow'   => true,
                        'roles'   => ['@'],
                    ],
                ],
            ],
            'verbs'  => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'auth' => [
                'class'           => 'yii\authclient\AuthAction',
                'successCallback' => [
                    $this,
                    'successCallback'
                ],
            ],
        ];
    }

    /**
     * Страница активации для подтверждения сменя email
     *
     * @param string $code код подтверждения
     *
     * @return string|\yii\web\Response
     *
     * @throws \cs\web\Exception
     */
    public function actionChange_email_activate($code)
    {
        $row = EmailChangeDispatcher::find(['code' => $code]);
        if (is_null($row)) {
            throw new Exception('Данный код уже активирован или не найден');
        }
        if (Yii::$app->user->isGuest) {
            /** @var \app\models\User $user */
            $user = User::find($row->getField('parent_id'));
            $user->update(['email' => $row->getField('email')]);
            Yii::$app->user->login($user);
        } else {
            /** @var \app\models\User $user */
            $user = Yii::$app->user->identity;
            $user->update(['email' => $row->getField('email')]);
        }
        $row->delete();

        return $this->render();
    }

    /**
     * @param \yii\authclient\ClientInterface $client
     */
    public function successCallback($client)
    {
        $attributes = $client->getUserAttributes();
        /** @var \app\services\authclient\authClientInterface $client */
        $client->saveToken();
        if (Yii::$app->user->isGuest) {
            $user = $client->login($attributes);
            if (is_null($user)) {
                $user = $client->register($attributes);
            }
            if (!is_null($user)) Yii::$app->user->login($user);
        }
        else {
            $client->attach($attributes, Yii::$app->user->identity);
        }
        $client->setAuthFlag();
        Yii::$app->user->setReturnUrl($_SERVER['HTTP_REFERER']);
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Провряет логин
     * REQUEST:
     * - email - string - почта/логин
     * - password - string - пароль
     * - is_stay - int - оставаться в системе
     * 0 - не запоминать меня
     * 1 - запомнить меня на этом компьютере
     *
     * @return string
     * errors
     * 101, 'Пользователь не найден'
     * 102, 'Пользователь не активирован'
     * 103, 'Пользователь заблокирован'
     * 104, 'Не верный пароль'
     * 105, 'Вы  не завели себе пароль для аккаунта. Зайдите в восстановление пароля'
     */
    public function actionLogin_ajax()
    {
        $email = strtolower(self::getParam('email'));
        $password = self::getParam('password');
        $user = User::find([
            'email' => $email,
        ]);
        if (is_null($user)) {
            return self::jsonErrorId(101, 'Пользователь не найден');
        }
        if ($user->getField('is_confirm') != 1) {
            return self::jsonErrorId(102, 'Пользователь не активирован');
        }
        if ($user->getField('is_active') != 1) {
            return self::jsonErrorId(103, 'Пользователь заблокирован');
        }
        if ($user->getField('password') == '') {
            return self::jsonErrorId(105, 'Вы  не завели себе пароль для аккаунта. Зайдите в восстановление пароля');
        }
        if ($user->validatePassword($password)) {
            $duration = 0;
            if (self::getParam('is_stay', 0) == 1) {
                $duration = 60*60*24*365*10;
            }
            Yii::$app->user->login($user, $duration);

            return self::jsonSuccess();
        }
        else {
            return self::jsonErrorId(104, 'Не верный пароль');
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect($_SERVER['HTTP_REFERER']);
    }

    public function actionPassword_recover()
    {
        if (\yii\helpers\ArrayHelper::getValue(Yii::$app->params, 'isTransfere', false) == true) {
            throw new Exception(Yii::$app->params['isTransfere_string']);
        }

        $model = new \app\models\Form\PasswordRecover();
        $model->setScenario('insert');

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            $model->setScenario('ajax');
            Yii::$app->response->format = Response::FORMAT_JSON;

            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) && $model->send()) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        else {
            return $this->render([
                'model' => $model,
            ]);
        }

    }

    public function actionRegistration()
    {
        if (\yii\helpers\ArrayHelper::getValue(Yii::$app->params, 'isTransfere', false) == true) {
            throw new Exception(Yii::$app->params['isTransfere_string']);
        }
        $model = new \app\models\Form\Registration();

        if (Yii::$app->request->isAjax) {
            $model->setScenario('ajax');
            if ($model->load(Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
        }
        $model->setScenario('insert');

        if ($model->load(Yii::$app->request->post()) && $model->register()) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        else {
            return $this->render([
                'model' => $model,
            ]);
        }
    }

    /**
     * Активация регистрации
     *
     * @param string $code
     *
     * @return Response
     * @throws Exception
     */
    public function actionRegistration_activate($code)
    {
        if (\yii\helpers\ArrayHelper::getValue(Yii::$app->params, 'isTransfere', false) == true) {
            throw new Exception(Yii::$app->params['isTransfere_string']);
        }
        $row = RegistrationDispatcher::query(['code' => $code])->one();
        if ($row === false) {
            throw new Exception('Срок ссылки истек или не верный код активации');
        }
        $user = User::find($row['parent_id']);
        if (is_null($user)) {
            throw new Exception('Пользователь не найден');
        }
        $user->activate();
        Yii::$app->user->login($user);
        RegistrationDispatcher::delete($row['parent_id']);

        return $this->goHome();
    }

    /**
     * Активация восстановления пароля
     *
     * @param string $code
     *
     * @return Response
     * @throws Exception
     */
    public function actionPassword_recover_activate($code)
    {
        if (\yii\helpers\ArrayHelper::getValue(Yii::$app->params, 'isTransfere', false) == true) {
            throw new Exception(Yii::$app->params['isTransfere_string']);
        }
        $row = PasswordRecoverDispatcher::query(['code' => $code])->one();
        if ($row === false) {
            throw new Exception('Не верный код активации');
        }
        $user = User::find($row['parent_id']);
        if (is_null($user)) {
            throw new Exception('Пользователь не найден');
        }

        $model = new \app\models\Form\PasswordNew();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            return ActiveForm::validate($model);
        }
        if ($model->load(Yii::$app->request->post()) && $model->action($user)) {
            PasswordRecoverDispatcher::delete($row['parent_id']);
            Yii::$app->user->login($user);
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->goHome();
        }
        else {
            return $this->render([
                'model' => $model,
            ]);
        }
    }
}
