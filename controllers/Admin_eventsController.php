<?php

namespace app\controllers;

use app\models\Article;
use app\models\Event;
use cs\services\VarDumper;
use cs\web\Exception;
use Yii;
use yii\base\UserException;
use app\models\SiteUpdate;
use app\services\Subscribe;
class Admin_eventsController extends AdminBaseController
{

    public function actionIndex()
    {
        return $this->render([
            'items' => Event::query()->all(),
        ]);
    }

    public function actionAdd()
    {
        $model = new \app\models\Form\Event();

        $model->load(Yii::$app->request->post());


        if ($model->load(Yii::$app->request->post()) && $model->insert()) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render([
                'model' => $model,
            ]);
        }
    }

    public function actionEdit($id)
    {
        $model = \app\models\Form\Event::find($id);
        if ($model->load(Yii::$app->request->post()) && $model->update()) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render([
                'model' => $model,
            ]);
        }
    }

    public function actionDelete($id)
    {
        \app\models\Form\Event::find($id)->delete();

        return self::jsonSuccess();
    }

    /**
     * AJAX
     * Добавляет site_update
     * Делает рассылку
     *
     * @param integer $id - идентификатор события
     *
     * @return string
     */
    public function actionSubscribe($id)
    {
        $item = \app\models\Event::find($id);
        if (is_null($item)) {
            return self::jsonError(101, 'Не найдено событие');
        }
        $start = microtime(true);
        Subscribe::add($item);
        SiteUpdate::add($item);
        $item->update(['is_added_site_update' => 1]);
        \Yii::info(microtime(true) - $start, 'gs\\actionSubscribe');

        return self::jsonSuccess();
    }
}
