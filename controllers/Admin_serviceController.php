<?php

namespace app\controllers;

use app\models\Article;
use app\models\Service;
use app\models\SiteUpdate;
use app\services\Subscribe;
use cs\services\VarDumper;
use cs\web\Exception;
use Yii;
use yii\base\UserException;

class Admin_serviceController extends AdminBaseController
{
    public function actionIndex()
    {
        return $this->render([
            'items' => \app\models\Service::query()->orderBy(['date_insert' => SORT_DESC])->all(),
        ]);
    }

    public function actionAdd()
    {
        $model = new \app\models\Form\Service();

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
        $model = \app\models\Form\Service::find($id);
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
        \app\models\Form\Service::find($id)->delete();

        return self::jsonSuccess();
    }

    /**
     * AJAX
     * Добавляет site_update
     * Делает рассылку
     *
     * @param integer $id - идентификатор услуги
     *
     * @return string
     */
    public function actionSubscribe($id)
    {
        $item = Service::find($id);
        if (is_null($item)) {
            return self::jsonError(101, 'Не найдено послание');
        }
        Subscribe::add($item);
        SiteUpdate::add($item);
        $item->update(['is_added_site_update' => 1]);

        return self::jsonSuccess();
    }
}
