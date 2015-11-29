<?php

namespace app\controllers;

use app\models\Article;
use app\models\Shop\Product;
use app\modules\Shop\services\Basket;
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
        $model = new \app\models\Form\Shop\Product([
            'union_id' => $id,
        ]);
        if ($model->load(Yii::$app->request->post()) && $model->insert2($id)) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        } else {
            return $this->render([
                'model' => $model,
            ]);
        }
    }

    /**
     * редактирование товара
     * @param int $id идентификатор товара gs_unions_shop_product.id
     * @return string|\yii\web\Response
     */
    public function actionProduct_list_edit($id)
    {
        $model = \app\models\Form\Shop\Product::find($id);
        if ($model->load(Yii::$app->request->post()) && $model->update($id)) {
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

    public function actionBasket()
    {
        return $this->render([
            'items' => Basket::get()
        ]);
    }

    /**
     * AJAX
     * Добавление товара в корзину
     * REQUEST
     * - id - int - идентификатор товара gs_unions_shop_product.id
     *
     * @return string
     */
    public function actionBasket_add()
    {
        $id = self::getParam('id');
        $product = Product::find($id);
        if (is_null($product)) {
            return self::jsonErrorId(101, 'Не найден товар');
        }
        $count = Basket::add($product);

        return self::jsonSuccess($count);
    }
}
