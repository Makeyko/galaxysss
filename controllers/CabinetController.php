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
use cs\base\BaseController;
use yii\web\Response;
use yii\widgets\ActiveForm;

class CabinetController extends BaseController
{
    public $layout = 'menu';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionObjects()
    {
        $items = \app\models\Union::query([
            'user_id'           => \Yii::$app->user->getId(),
            'moderation_status' => 1,
        ])
            ->orderBy(['date_insert' => SORT_DESC])
            ->all();

        return $this->render([
            'items' => $items
        ]);
    }

    public function actionPoseleniya()
    {
        $items =  \app\models\Poselenie::query(['user_id' => \Yii::$app->user->getId()])->all();

        return $this->render([
            'items' => $items
        ]);
    }

    public function actionObjects_add()
    {
        $model = new \app\models\Form\Union();
        if ($model->load(Yii::$app->request->post()) && $model->insert()) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render([
                'model' => $model,
            ]);
        }

    }

    public function actionProfile()
    {
        $model = \app\models\Form\Profile::find(Yii::$app->user->getId());
        if ($model->load(Yii::$app->request->post()) && $model->update()) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render([
                'model' => $model,
            ]);
        }
    }

    /**
     * Удаляет объединение
     *
     * @param $id
     *
     * @return string
     */
    public function actionObjects_delete($id)
    {
        $model = \app\models\Form\Union::find($id);
        $model->delete();

        return self::jsonSuccess();
    }

    /**
     * Редактирует объединение
     *
     * @param int $id идентификатор объединения
     *
     * @return string|\yii\web\Response
     * @throws \cs\web\Exception
     */
    public function actionObjects_edit($id)
    {
        $model = \app\models\Form\Union::find($id);
        if (is_null($model)) {
            throw new Exception('Не найдено объединение');
        }
        if ($model->load(Yii::$app->request->post()) && $model->update()) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render([
                'model' => $model,
            ]);
        }

    }

    public function actionPoseleniya_add()
    {
        $model = new \app\models\Form\Poselenie();
        if ($model->load(Yii::$app->request->post()) && $model->insert()) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render([
                'model' => $model,
            ]);
        }

    }

    /**
     * Редактирует объединение
     *
     * @param int $id идентификатор объединения
     *
     * @return string|\yii\web\Response
     * @throws \cs\web\Exception
     */
    public function actionPoseleniya_edit($id)
    {
        $model = \app\models\Form\Poselenie::find($id);
        if (is_null($model)) {
            throw new Exception('Не найдено послеление');
        }
        if ($model->load(Yii::$app->request->post()) && $model->update()) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render([
                'model' => $model,
            ]);
        }
    }

    /**
     * Удаляет поседение
     *
     * @param int $id идентификатор поселения
     *
     * @return string|\yii\web\Response
     *
     * @throws \cs\web\Exception
     */
    public function actionPoseleniya_delete($id)
    {
        $model = \app\models\Form\Poselenie::find($id);
        if (is_null($model)) {
            throw new Exception('Не найдено послеление');
        }
        $model->delete();

        return self::jsonSuccess();
    }

    public function actionPassword_change()
    {
        $model = new \app\models\Form\PasswordNew();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            return ActiveForm::validate($model);
        }

        if ($model->load(Yii::$app->request->post()) && $model->action(\Yii::$app->user->identity)) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        else {
            return $this->render([
                'model' => $model,
            ]);
        }
    }

    public function actionMind_map()
    {
        return $this->render();
    }
}
