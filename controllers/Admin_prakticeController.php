<?php

namespace app\controllers;

use app\models\Praktice;
use cs\services\VarDumper;
use cs\web\Exception;
use Yii;
use yii\base\UserException;

class Admin_prakticeController extends AdminBaseController
{

    public function actionIndex()
    {
        return $this->render([
            'items' => Praktice::query()->all(),
        ]);
    }

    public function actionAdd()
    {
        $model = new \app\models\Form\Praktice();
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
        $model = \app\models\Form\Praktice::find($id);
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
        \app\models\Form\Praktice::find($id)->delete();

        return self::jsonSuccess();
    }
}
