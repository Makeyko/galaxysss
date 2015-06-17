<?php

namespace app\controllers;

use cs\services\VarDumper;
use cs\web\Exception;
use Yii;
use yii\base\UserException;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\NewsItem;
use app\models\Chenneling;
use cs\base\BaseController;
use yii\web\Response;
use yii\widgets\ActiveForm;

class AdminController extends AdminBaseController
{
    public function actionNews()
    {
        return $this->render([
            'items' => NewsItem::query()->orderBy(['date_insert' => SORT_DESC])->all(),
        ]);
    }

    public function actionNews_add()
    {
        $model = new \app\models\Form\NewsAdd();
        if ($model->load(Yii::$app->request->post()) && $model->insert()) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render([
                'model' => $model,
            ]);
        }
    }

    public function actionNews_edit($id)
    {
        $model = \app\models\Form\NewsAdd::find($id);
        if ($model->load(Yii::$app->request->post()) && $model->update()) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render([
                'model' => $model,
            ]);
        }
    }

    public function actionNews_delete($id)
    {
        \app\models\Form\NewsAdd::find($id)->delete();

        return self::jsonSuccess();
    }

    public function actionChenneling_list()
    {
        return $this->render([
            'items' => Chenneling::query()->orderBy(['date_insert' => SORT_DESC])->all(),
        ]);
    }

    public function actionChenneling_list_add()
    {
        $model = new \app\models\Form\Chenneling();
        if ($model->load(Yii::$app->request->post()) && $model->insert()) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render([
                'model' => $model,
            ]);
        }
    }

    public function actionChenneling_list_add_from_page()
    {
        $model = new \app\models\Form\ChennelingFromPage();
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

    public function actionChenneling_list_edit($id)
    {
        $model = \app\models\Form\Chenneling::find($id);
        if ($model->load(Yii::$app->request->post()) && $model->update()) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render([
                'model' => $model,
            ]);
        }
    }

    public function actionChenneling_list_delete($id)
    {
        \app\models\Form\Chenneling::find($id)->delete();

        return self::jsonSuccess();
    }
}
