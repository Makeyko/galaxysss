<?php

namespace app\controllers;

use app\models\Article;
use cs\services\VarDumper;
use cs\web\Exception;
use Yii;
use yii\base\UserException;

class Admin_serviceController extends AdminBaseController
{
    public function actionIndex()
    {
        return $this->render([
            'items' => \app\models\Service::query()->all(),
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
}
