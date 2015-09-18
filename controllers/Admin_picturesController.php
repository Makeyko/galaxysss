<?php

namespace app\controllers;

use app\models\SubscribeHistory;
use Yii;

class Admin_picturesController extends AdminBaseController
{
    public function actionIndex()
    {
        return $this->render([
            'items' => \app\models\Pictures::query()->orderBy(['id' => SORT_DESC])->all(),
        ]);
    }

    public function actionAdd()
    {
        $model = new \app\models\Form\Picture();
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
}
