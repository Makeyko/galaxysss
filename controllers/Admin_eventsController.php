<?php

namespace app\controllers;

use app\models\Article;
use app\models\Event;
use cs\services\VarDumper;
use cs\web\Exception;
use Yii;
use yii\base\UserException;

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
}
