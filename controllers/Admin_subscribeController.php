<?php

namespace app\controllers;

use app\models\SubscribeHistory;
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
}
