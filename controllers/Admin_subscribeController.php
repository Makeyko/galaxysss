<?php

namespace app\controllers;

use app\models\SubscribeHistory;
use app\models\SubscribeItem;
use app\services\Subscribe;
use Yii;

class Admin_subscribeController extends AdminBaseController
{
    public function actionIndex()
    {
        return $this->render([
            'items' => SubscribeHistory::query()->orderBy(['date_insert' => SORT_DESC])->all(),
        ]);
    }

    public function actionAdd()
    {
        $model = new \app\models\Form\SubscribeHistory();
        if ($model->load(Yii::$app->request->post()) && $model->insert()) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render([
                'model' => $model,
            ]);
        }
    }

    public function actionAdd_simple()
    {
        $model = new \app\models\Form\SubscribeHistorySimple();
        if ($model->load(Yii::$app->request->post()) && $model->insert()) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render([
                'model' => $model,
            ]);
        }
    }

    public function actionView($id)
    {
        $item = \app\models\SubscribeHistory::find($id);

        return $this->render([
            'item' => $item->getFields(),
        ]);
    }

    public function actionEdit($id)
    {
        $model = \app\models\Form\SubscribeHistory::find($id);
        if ($model->load(Yii::$app->request->post()) && $model->update2($id)) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render([
                'model' => $model,
            ]);
        }
    }

    /**
     * AJAX
     * Делает рассылку
     *
     * REQUEST:
     * - id - int - идентификатор рассылки
     *
     * @return string json
     */
    public function actionSend()
    {
        $subscribe = SubscribeHistory::find(self::getParam('id'));
        if (is_null($subscribe)) {
            return self::jsonErrorId(101, 'Не найдена рассылка');
        }
        $subscribeItem = new SubscribeItem();
        $subscribeItem->subject = $subscribe->getField('subject');
        $subscribeItem->type = Subscribe::TYPE_MANUAL;

        /** @var \yii\swiftmailer\Mailer $mailer */
        $mailer = Yii::$app->mailer;
        $view = 'subscribe/manual';
        $options = [
            'subscribeHistory' => $subscribe
        ];
        $subscribeItem->html = $mailer->render('html/' . $view, $options, 'layouts/html');
        Subscribe::add($subscribeItem);
        $subscribe->update(['is_send' => 1]);

        return self::jsonSuccess();
    }

    /**
     * AJAX
     * Удаляет рассылку
     *
     * REQUEST:
     * - id - int - идентификатор рассылки
     *
     * @return string json
     */
    public function actionDelete()
    {
        $subscribe = \app\models\Form\SubscribeHistory::find(self::getParam('id'));
        if (is_null($subscribe)) {
            return self::jsonErrorId(101, 'Не найдена рассылка');
        }
        $subscribe->delete();

        return self::jsonSuccess();
    }
}
