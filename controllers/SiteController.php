<?php

namespace app\controllers;

use app\models\Form\Event;
use app\models\HD;
use app\models\HDtown;
use app\models\Log;
use app\models\SiteUpdate;
use app\models\User;
use app\services\GetArticle\YouTube;
use app\services\GraphExporter;
use app\services\HumanDesign2;
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
            'events' => \app\models\Event::query()
                ->limit(3)
                ->where(['>=', 'end_date', gmdate('Ymd')])
                ->orderBy([
                    'date_insert' => SORT_DESC,
                ])
                ->all(),
        ]);
    }

    public function actionThank()
    {
        return $this->render();
    }

    /**
     * Выводит карточку профиля
     *
     * @param $id
     *
     * @return string
     * @throws \cs\web\Exception
     */
    public function actionUser($id)
    {
        $user =  User::find($id);
        if (is_null($user)) {
            throw new \cs\web\Exception('Пользователь не найден');
        }

        return $this->render([
            'user' => $user,
        ]);
    }

    /**
     *  Прием уведомлений о платежах
     */
    public function actionMoney()
    {
        Yii::info(\yii\helpers\VarDumper::dumpAsString(Yii::$app->request->post()), 'gs\\money');

        return self::jsonSuccess();
    }

    /**
     *  Прием уведомлений о платежах
     */
    public function actionThankyou()
    {
        return $this->render();
    }

    public function actionService()
    {
        return $this->render();
    }

    public function actionTest()
    {
        $url = 'http://vk.com/wall-84190266';

        VarDumper::dump(file_get_contents($url, false, null, -1));
    }

    public function actionStatistic()
    {
        $data = User::query()
            ->select([
                'datetime_reg',
            ])
            ->column();
        $data2 = \app\services\Statistic::getIncrementDataAllGraphic($data, 'Y-m-d');

        $new = [];
        for ($i = 0; $i < count($data2['x']); $i++) {
            if ($data2['x'][ $i ] > '2015-07-18') {
                $new['x'][] = (new \DateTime($data2['x'][ $i ]))->format('d.m');
                $new['y'][] = $data2['y'][ $i ];
            }
        }
        $data2 = $new;
        $data3 = GraphExporter::convert([
            'rows'             => [User::query()
                ->select([
                    'COUNT(id) as `kurs`',
                    'DATE(datetime_reg) as `date`',
                ])
                ->groupBy('DATE(datetime_reg)')
                ->all()],
            'formatX'          => 'd.m',
            'start'            => new \DateTime('2015-07-05'),
            'isExcludeWeekend' => false,
        ]);

        return $this->render([
            'lineArray'  => $data3,
            'lineArray2' => [
                'x' => $data2['x'],
                'y' => [$data2['y']],
            ],
        ]);
    }

    public function actionSite_update()
    {
        \app\services\SiteUpdateItemsCounter::clear();

        return $this->render([
            'list' => SiteUpdate::query()->orderBy(['date_insert' => SORT_DESC])->limit(50)->all()
        ]);
    }

    public function actionSite_update_ajax()
    {
        $typeId = self::getParam('id');

        return self::jsonSuccess($this->renderFile('@app/views/site/site_update_ajax.php', [
            'list' => SiteUpdate::query(['type' => $typeId])->orderBy(['date_insert' => SORT_DESC])->limit(50)->all()
        ]));
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

    public function actionLogo()
    {
        return $this->render();
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
            $query->where(['like', 'category', $category . '%', false]);
        }
        $type = self::getParam('type', '');
        if ($type) {
            switch ($type) {
                case 'INFO':
                    $type = \yii\log\Logger::LEVEL_INFO;
                    break;
                case 'ERROR':
                    $type = \yii\log\Logger::LEVEL_ERROR;
                    break;
                case 'WARNING':
                    $type = \yii\log\Logger::LEVEL_WARNING;
                    break;
                case 'PROFILE':
                    $type = \yii\log\Logger::LEVEL_PROFILE;
                    break;
                default:
                    $type = null;
                    break;
            }
            if ($type) {
                $query->where(['type' => $type]);
            }
        }

        return $this->render([
            'dataProvider' => new ActiveDataProvider([
                'query'      => $query,
                'pagination' => [
                    'pageSize' => 50,
                ],
            ])
        ]);
    }
}
