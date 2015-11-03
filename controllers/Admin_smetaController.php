<?php

namespace app\controllers;

use app\models\Article;
use app\models\SiteUpdate;
use app\models\Smeta;
use app\services\Subscribe;
use cs\services\VarDumper;
use cs\web\Exception;
use Yii;
use yii\base\UserException;

class Admin_smetaController extends AdminBaseController
{

    public function actionIndex()
    {
        return $this->render([
            'items' => Smeta::query()->orderBy(['date_insert' => SORT_DESC])->all(),
        ]);
    }

    public function actionAdd()
    {
        $model = new \app\models\Form\Smeta();
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
        $model = \app\models\Form\Smeta::find($id);
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
        \app\models\Form\Smeta::find($id)->delete();

        return self::jsonSuccess();
    }

}
