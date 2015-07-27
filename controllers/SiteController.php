<?php

namespace app\controllers;

use app\models\Form\Event;
use app\models\Log;
use app\models\SiteUpdate;
use app\models\User;
use app\services\GetArticle\YouTube;
use cs\base\BaseController;
use cs\helpers\Html;
use cs\services\SitePath;
use cs\services\Str;
use cs\services\VarDumper;
use Yii;
use yii\base\Exception;
use yii\base\UserException;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\helpers\StringHelper;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\web\Response;
use yii\widgets\ActiveForm;
use app\services\RegistrationDispatcher;

class SiteController extends BaseController
{
    public $layout = 'menu';

    public function actions()
    {
        return [
            'error'   => [
                'class' => 'yii\web\ErrorAction',
                'view'  => '@app/views/site/error.php'
            ],
            'captcha' => [
                'class'           => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index', [
            'events' => \app\models\Event::query()->limit(3)->orderBy(['date_insert' => SORT_DESC])->all(),
        ]);
    }

    public function actionTest()
    {
        Yii::$app->session->open();
        VarDumper::dump(Yii::$app->cache->get(Yii::$app->session->getId() . '/maya'));
        Yii::$app->cache->delete(Yii::$app->session->getId() . '/maya');
    }

    public function actionSite_update()
    {
        return $this->render([
            'list' => SiteUpdate::query()->orderBy(['date_insert' => SORT_DESC])->all()
        ]);
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['mailList']['contact'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionLog()
    {
        return $this->render([
            'log' => file_get_contents(Yii::getAlias('@runtime/logs/app.log')),
        ]);
    }

    public function actionLog_db()
    {
        $query = Log::query()->orderBy(['log_time' => SORT_DESC]);
        $category = self::getParam('category', '');
        if ($category) {
            $query->where(['like', 'category', $category.'%', false]);
        }
        $type = self::getParam('type', '');
        if ($type) {
            switch($type) {
                case 'INFO':    $type = \yii\log\Logger::LEVEL_INFO; break;
                case 'ERROR':   $type = \yii\log\Logger::LEVEL_ERROR; break;
                case 'WARNING': $type = \yii\log\Logger::LEVEL_WARNING; break;
                case 'PROFILE': $type = \yii\log\Logger::LEVEL_PROFILE; break;
                default:  $type = null; break;
            }
            if ($type) {
                $query->where(['type' => $type]);
            }
        }

        return $this->render([
            'dataProvider' => new ActiveDataProvider([
                'query' => Log::query()->orderBy(['log_time' => SORT_DESC]),
                'pagination' => [
                    'pageSize' => 50,
                ],
            ])
        ]);
    }
}
