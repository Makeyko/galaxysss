<?php

namespace app\controllers;

use app\models\Article;
use cs\services\VarDumper;
use cs\web\Exception;
use Yii;
use yii\base\UserException;

class Cabinet_officeController extends AdminBaseController
{
    public function actionIndex($unionId)
    {
        return $this->render([
            'items' => \app\models\UnionOffice::query(['union_id' => $unionId])->all(),
            'union_id' => $unionId,
        ]);
    }

    public function init()
    {
        if (\yii\helpers\ArrayHelper::getValue(Yii::$app->params, 'isTransfere', false) == true) {
            throw new Exception(Yii::$app->params['isTransfere_string']);
        }
    }

    public function actionAdd($unionId)
    {
        $model = new \app\models\Form\UnionOffice();
        $model->union_id = $unionId;
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
        $model = \app\models\Form\UnionOffice::find($id);
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
        \app\models\Form\UnionOffice::find($id)->delete();

        return self::jsonSuccess();
    }
}
