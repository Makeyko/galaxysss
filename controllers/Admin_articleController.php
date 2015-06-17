<?php

namespace app\controllers;

use app\models\Article;
use cs\services\VarDumper;
use cs\web\Exception;
use Yii;
use yii\base\UserException;

class Admin_articleController extends AdminBaseController
{

    public function actionIndex()
    {
        return $this->render([
            'items' => Article::query()->all(),
        ]);
    }

    public function actionAdd()
    {
        $model = new \app\models\Form\Article();
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
        $model = \app\models\Form\Article::find($id);
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
        \app\models\Form\Article::find($id)->delete();

        return self::jsonSuccess();
    }


    public function actionAdd_from_page()
    {
        $model = new \app\models\Form\ArticleFromPage();
        if ($model->load(Yii::$app->request->post()) && $model->insert()) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            $model->provider = self::getParam('page');
            return $this->render([
                'model' => $model,
            ]);
        }
    }

}
