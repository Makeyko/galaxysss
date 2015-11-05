<?php

namespace app\controllers;

use app\models\Article;
use cs\services\VarDumper;
use cs\web\Exception;
use Yii;
use yii\base\UserException;

class Cabinet_shopController extends CabinetBaseController
{
    /**
     * Редактирование магазина
     * @param int $id идентификатор объединения gs_unions.id
     * @return string|\yii\web\Response
     */
    public function actionIndex($id)
    {
        $model = \app\models\Form\Shop::find(['union_id' => $id]);
        if (is_null($model)) $model = new \app\models\Form\Shop();
        if ($model->load(Yii::$app->request->post()) && $model->update2($id)) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render([
                'model' => $model,
            ]);
        }
    }
    /**
     * дообавление товара
     * @param int $id идентификатор объединения gs_unions.id
     * @return string|\yii\web\Response
     */
    public function actionProduct_list_add($id)
    {
        $model = new \app\models\Form\Shop\Product();
        if ($model->load(Yii::$app->request->post()) && $model->insert2($id)) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render([
                'model' => $model,
            ]);
        }
    }

    public function actionProduct_list($id)
    {
        return $this->render([
            'union_id' => $id
        ]);
    }
}
