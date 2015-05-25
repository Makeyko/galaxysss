<?php

namespace app\controllers;

use app\models\User;
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
     * @param \yii\authclient\ClientInterface $client
     */
    public function successCallback($client)
    {
        $attributes = $client->getUserAttributes();
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
     * - email
     * - password
     *
     * @return string
     */
    public function actionLogin_ajax()
    {
        $email = self::getParam('email');
        $password = self::getParam('password');
        $user = User::find([
            'email' => $email,
        ]);
        if (is_null($user)) {
            return self::jsonErrorId(101, 'Пользователь не найден');
        }
        $user = User::find([
            'email'      => $email,
            'is_confirm' => 1,
        ]);
        if (is_null($user)) {
            return self::jsonErrorId(102, 'Пользователь не активирован');
        }
        $user = User::find([
            'email'      => $email,
            'is_confirm' => 1,
            'is_active'  => 1,
        ]);
        if (is_null($user)) {
            return self::jsonErrorId(103, 'Пользователь заблокирован');
        }
        if ($user->validatePassword($password)) {
            Yii::$app->user->login($user);

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
        $model = new \app\models\Form\Registration();
        $model->setScenario('insert');

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            $model->setScenario('ajax');
            Yii::$app->response->format = Response::FORMAT_JSON;

            return ActiveForm::validate($model);
        }

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
        $row = RegistrationDispatcher::query(['code' => $code])->one();
        if ($row === false) {
            throw new Exception('Не верный код активации');
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
