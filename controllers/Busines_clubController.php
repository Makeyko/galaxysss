<?php

namespace app\controllers;

use app\models\Form\Union;
use app\models\HD;
use app\models\HDtown;
use app\models\SiteUpdate;
use app\models\User;
use app\services\Subscribe;
use cs\Application;
use cs\services\SitePath;
use cs\services\VarDumper;
use cs\web\Exception;
use Yii;
use yii\base\UserException;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\NewsItem;
use cs\base\BaseController;
use yii\web\Response;
use yii\widgets\ActiveForm;

class Busines_clubController extends BaseController
{
    public $layout = 'menu';

    public function init()
    {
         if (\yii\helpers\ArrayHelper::getValue(Yii::$app->params, 'isTransfere', false) == true) {
             if ($this->action != 'logout')
             {
                 throw new Exception(Yii::$app->params['isTransfere_string']);
             }
         }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionIndex()
    {
        throw new Exception('Извините ваше сознание не готово. Вам необходимо сначала пройти Школу Богов (http://www.i-am-avatar.com/)');
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->redirect(Url::to(['busines_club/index']));
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(Url::to(['busines_club/index']));
        }
        else {
            return $this->render([
                'model' => $model,
            ]);
        }
    }
}
