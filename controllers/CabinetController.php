<?php

namespace app\controllers;

use app\models\Form\Union;
use app\models\HDtown;
use app\models\SiteUpdate;
use app\models\User;
use app\services\Subscribe;
use cs\Application;
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

class CabinetController extends BaseController
{
    public $layout = 'menu';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionProfile_human_design()
    {
        return $this->render([
            'items' => HDtown::query()
                ->select([
                    'gs_hd.id',
                    'gs_hd.title',
                    'gs_hd.sub_type',
                    'gs_hd.name',
                    'gs_hd_town.id as town_id',
                    'gs_hd_town.name as town_name',
                    'gs_hd_town.title as town_title',
                ])
                ->innerJoin('gs_hd', 'gs_hd_town.country_id = gs_hd.id')
                ->all()
        ]);
    }

    public function actionObjects()
    {
        $items = \app\models\Union::query([
            'user_id' => \Yii::$app->user->getId(),
        ])
            ->andWhere(['in', 'moderation_status', [0, 1]])
            ->orderBy(['date_insert' => SORT_DESC])
            ->all();

        return $this->render([
            'items' => $items
        ]);
    }

    /**
     * делает рассылку о том что добавлено объединение
     *
     * @param int $id идентификатор объединения
     *
     * @return \yii\web\Response
     */
    public function actionObjects_subscribe($id)
    {
        return self::doAction($id, function (\app\models\Union $item) {
            Subscribe::add($item);
            SiteUpdate::add($item);
            $item->update(['is_added_site_update' => 1]);
        });
    }


    private function doAction($id, $callback)
    {
        $item = \app\models\Union::find($id);
        if (is_null($item)) {
            return self::jsonErrorId(101, 'Не найдено объединение');
        }
        $callback($item);

        return self::jsonSuccess();
    }

    /**
     * AJAX
     * @param $id
     *
     * @return \yii\web\Response
     */
    public function actionSend_moderation($id)
    {
        return self::doAction($id, function (\app\models\Union $item) {
            $item->update(['moderation_status' => null]);

            // высылаю письмо
            Application::mail(Yii::$app->params['moderator']['email'], 'Обновлено объединение', 'update_union', [
                'union' => $item,
            ]);
        });
    }

    public function actionPoseleniya()
    {
        $items =  \app\models\Poselenie::query(['user_id' => \Yii::$app->user->getId()])->all();

        return $this->render([
            'items' => $items
        ]);
    }

    public function actionObjects_add()
    {
        $model = new \app\models\Form\Union();
        if ($model->load(Yii::$app->request->post()) && $model->insert()) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render([
                'model' => $model,
            ]);
        }

    }

    public function actionProfile()
    {
        $model = \app\models\Form\Profile::find(Yii::$app->user->getId());
        if ($model->load(Yii::$app->request->post()) && ($fields = $model->update())) {
            Yii::$app->user->identity->cacheClear();
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render([
                'model' => $model,
            ]);
        }
    }

    public function actionProfile_subscribe()
    {
        $model = \app\models\Form\ProfileSubscribe::find(Yii::$app->user->getId());
        if ($model->load(Yii::$app->request->post()) && $model->update()) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render([
                'model' => $model,
            ]);
        }
    }

    /**
     * Удаляет объединение
     *
     * @param $id
     *
     * @return string
     */
    public function actionObjects_delete($id)
    {
        $model = \app\models\Form\Union::find($id);
        if (is_null($model)) {
            return self::jsonErrorId(101, 'Не найдено объединение');
        }
        $model->delete();

        return self::jsonSuccess();
    }

    /**
     * Редактирует объединение
     *
     * @param int $id идентификатор объединения
     *
     * @return string|\yii\web\Response
     * @throws \cs\web\Exception
     */
    public function actionObjects_edit($id)
    {
        $model = \app\models\Form\Union::find($id);
        if (is_null($model)) {
            throw new Exception('Не найдено объединение');
        }
        if ($model->load(Yii::$app->request->post()) && $model->update()) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render([
                'model' => $model,
            ]);
        }

    }

    public function actionPoseleniya_add()
    {
        $model = new \app\models\Form\Poselenie();
        if ($model->load(Yii::$app->request->post()) && $model->insert()) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render([
                'model' => $model,
            ]);
        }

    }

    /**
     * Редактирует объединение
     *
     * @param int $id идентификатор объединения
     *
     * @return string|\yii\web\Response
     * @throws \cs\web\Exception
     */
    public function actionPoseleniya_edit($id)
    {
        $model = \app\models\Form\Poselenie::find($id);
        if (is_null($model)) {
            throw new Exception('Не найдено послеление');
        }
        if ($model->load(Yii::$app->request->post()) && $model->update()) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render([
                'model' => $model,
            ]);
        }
    }

    /**
     * Удаляет поседение
     *
     * @param int $id идентификатор поселения
     *
     * @return string|\yii\web\Response
     *
     * @throws \cs\web\Exception
     */
    public function actionPoseleniya_delete($id)
    {
        $model = \app\models\Form\Poselenie::find($id);
        if (is_null($model)) {
            throw new Exception('Не найдено послеление');
        }
        $model->delete();

        return self::jsonSuccess();
    }

    public function actionPassword_change()
    {
        $model = new \app\models\Form\PasswordNew();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) && $model->action(\Yii::$app->user->identity)) {
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
     * Отсоединяет профиль соц сети
     * REQUEST:
     * - name - string - название соц сети \yii\authclient\clients\*::defaultName()
     */
    public function actionProfile_unlink_social_network()
    {
        $name = self::getParam('name', '');
        try {
            /** @var \app\services\authclient\authClientInterface $client */
            $client = Yii::$app->authClientCollection->getClient($name);
            $client->unLink(Yii::$app->user->identity);

            return self::jsonSuccess();
        } catch (\yii\base\InvalidParamException $e) {
            return self::jsonErrorId(101, 'Не найден клиент');
        }
    }

    public function actionMind_map()
    {
        return $this->render();
    }
}
