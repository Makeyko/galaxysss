<?php

namespace app\controllers;

use app\models\Event;
use cs\models\Calendar\Maya;
use cs\services\VarDumper;
use cs\web\Exception;
use Yii;
use yii\base\UserException;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\NewsItem;
use cs\base\BaseController;
use DateTime;

class CalendarController extends BaseController
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

    /**
     * Выводит год по лунам
     *
     * @return string
     */
    public function actionMoon()
    {
        return $this->render();
    }

    /**
     * Выводит Оракул дня
     *
     * @return string
     */
    public function actionOrakul()
    {
        return $this->render();
    }

    /**
     * Выводит год по лунам
     *
     * @return string
     */
    public function actionEvents_mandala_festival()
    {
        return $this->render();
    }

    /**
     * Выводит событие
     *
     * @param int $id идентификатор события
     *
     * @return string
     * @throws \cs\web\Exception
     */
    public function actionEvents_item($id)
    {
        $item = Event::find($id);
        if (is_null($item)) {
            throw new Exception('Событие не найдено');
        }

        return $this->render([
            'item' => $item
        ]);
    }

    /**
     * Выводит события
     *
     * @return string
     * @throws \cs\web\Exception
     */
    public function actionEvents()
    {
        return $this->render([
            'items' => Event::query()
                ->limit(12)
                ->where(['>=', 'end_date', gmdate('Ymd')])
                ->orderBy([
                    'start_date' => SORT_ASC,
                ])
                ->all(),
        ]);
    }

    public function actionIndex()
    {
        return $this->redirect(['calendar/orakul']);
    }

    public function actionColkin()
    {
        $days = Maya::colkin();
        $nextDate = new \DateTime($days[20][13]['date']);
        $nextDate->add(new \DateInterval('P1D'));
        $nextDate = $nextDate->format('Y-m-d');

        return $this->render([
            'days'     => $days,
            'nextDate' => $nextDate,
        ]);
    }

    /**
     * Возвращает html для цолькина и дату следующую за ним
     * REQUEST:
     * - date - string - дата в формате 'yyyy-mm-dd'
     *
     * @return string json
     *                [
     *                 'html'     => string - html содержимое цолькина
     *                 'nextDate' => string - дата в формате 'yyyy-mm-dd'
     *                ]
     */
    public function actionColkin_more()
    {
        $date = self::getParam('date');
        $days = Maya::colkin($date);
        $nextDate = new \DateTime($days[20][13]['date']);
        $nextDate->add(new \DateInterval('P1D'));
        $nextDate = $nextDate->format('Y-m-d');

        return self::jsonSuccess(
            [
                'html'     => $this->renderFile('@app/views/calendar/colkin_more.php', [
                    'days' => $days,
                ]),
                'nextDate' => $nextDate,
            ]
        );
    }


    /**
     * Сохраняет дату маянскую для вывода ее потом в шаблоне
     * AJAX
     *
     * REQUEST:
     * - maya - str - json
     * - stamp - int - идентификатор печати от 1
     * - datetime - str - время у пользователя в формате 'yyyy-mm-dd hh:mm:ss'
     * - date - str - '4 апр 2015 г.'
     */
    public function actionSave()
    {
//        self::validateRequestJson([
//            ['required', ['stamp', 'datetime', 'date', 'maya']],
//            ['integer', ['stamp']],
//            ['len', ['datetime'], 19],
//        ]);

        $stamp = self::getParam('stamp');
        $maya = self::getParam('maya');
        $datetime = self::getParam('datetime');
        $date = self::getParam('date');
        Yii::$app->session->open();
        Yii::$app->cache->set(Yii::$app->session->getId() . '/maya', [
            'stamp' => $stamp,
            'date'  => $date,
            'maya'  => $maya,
        ], self::actionSave_getDuration($datetime));

        return self::jsonSuccess();
    }

    public function actionSpyral()
    {
        return $this->render([]);
    }

    public function actionFriends()
    {
        if (Yii::$app->user->isGuest) {
            $options = [];
        } else {
            $options = [
                'me' => [
                    'birth_date' => Yii::$app->user->identity->getField('birth_date')
                ]
            ];
        }

        return $this->render($options);
    }

    /**
     * AJAX
     * Выдает список друзей у которых указана полная дата рождения
     *
     * @return string json
     *                [ 'friends' => [
     *                  [
     *                      'id' => int
     *                      'id' => int
     *                      'id' => int
     *                      'id' => int
     * ], ...
     * ]]
     *
     */
    public function actionFriends_vkontakte()
    {
        /** @var \app\services\authclient\VKontakte $client */
        $client = Yii::$app->authClientCollection->clients['vkontakte'];
        $data = $client->api('friends.get', 'GET', [
            'fields' => [
                'nickname',
                'photo_100',
                'bdate',
            ]
        ]);
        $ret = [];
        foreach($data['response'] as $item) {
            $birthDate = ArrayHelper::getValue($item, 'bdate', '');
            if ($birthDate != '') {
                $arr = explode('.', $birthDate);
                if (count($arr) == 3) {
                    $ret[] = [
                        'id'        => $item['uid'],
                        'name'      => $item['first_name'] . ' ' . $item['last_name'],
                        'avatar'    => $item['photo_100'],
                        'birthDate' => $arr,
                    ];
                }
            }
        }

        return self::jsonSuccess([
            'friends' => $ret,
        ]);
    }

    /**
     * Показывает значение в кеше
     */
    public function actionCache_show()
    {
        Yii::$app->session->open();
        VarDumper::dump(Yii::$app->cache->get(Yii::$app->session->getId() . '/maya'));
    }

    /**
     * Выводит страницу с виджетами
     */
    public function actionWidget()
    {
        return $this->render([]);
    }

    /**
     * 13 Ясных Знаков Пакаль Вотана
     */
    public function actionYasnih_znakov()
    {
        return $this->render([]);
    }

    /**
     * Показывает значение в кеше
     */
    public function actionCache_delete()
    {
        Yii::$app->session->open();
        Yii::$app->cache->delete(Yii::$app->session->getId() . '/maya');

        return self::jsonSuccess();
    }

    /**
     * Возвращает количество секунд оставшееся до завершения суток
     *
     * @param $datetime
     *
     * @return int
     */
    private static function  actionSave_getDuration($datetime)
    {
        $thisDateTime = new DateTime($datetime);
        $thisTime = (int)$thisDateTime->format('U');
        $dayNext = $thisDateTime->add(new \DateInterval('P1D'));
        /** @var string $dayNextString 'yyyy-mm-dd hh:mm:ss' */
        $dayNextString = $dayNext->format('Y-m-d') . '00:00:01';
        $dayNextDateTime = new DateTime($dayNextString);
        $dayNextTime = (int)$dayNextDateTime->format('U');

        return $dayNextTime -  $thisTime;
    }
}
