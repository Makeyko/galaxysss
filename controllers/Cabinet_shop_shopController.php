<?php

namespace app\controllers;

use app\models\Article;
use app\models\Form\Shop\Order;
use app\models\Shop\Product;
use app\models\Shop\Request;
use app\models\Shop\RequestMessage;
use app\models\Shop\RequestProduct;
use app\modules\Shop\services\Basket;
use cs\services\VarDumper;
use cs\web\Exception;
use Yii;
use yii\base\UserException;

class Cabinet_shop_shopController extends CabinetBaseController
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

    public function actionRequest_list($id)
    {
        return $this->render([
            'union_id' => $id,
        ]);
    }

    public function actionRequest_list_item($id)
    {
        return $this->render([
            'request' => Request::find($id),
        ]);
    }

    /**
     * AJAX
     * Отправляет сообщение к заказу для клиента
     *
     * REQUEST:
     * - text - string - текст сообщения
     *
     * @param int $id  идентификатор заказа gs_users_shop_requests.id
     *
     * @return \yii\web\Response json
     */
    public function actionRequest_list_item_message($id)
    {
        $text = self::getParam('text');
        $request = Request::find($id);
        if ($request->getField('user_id') != Yii::$app->user->id) {
            return self::jsonErrorId(101, 'Это не ваш заказ');
        }
        $request->addMessageToClient($text);

        return self::jsonSuccess();
    }

    /**
     * AJAX
     * Отправляет сообщение для клиента: Выставлен счет на оплату
     *
     * REQUEST:
     * - text - string - текст сообщения
     *
     * @param int $id  идентификатор заказа gs_users_shop_requests.id
     *
     * @return \yii\web\Response json
     */
    public function actionRequest_list_item_new_bill($id)
    {
        return $this->sendStatus($id, Request::STATUS_ORDER_DOSTAVKA);
    }

    /**
     * AJAX
     * Отправляет сообщение для клиента: Оплата подтверждена
     *
     * REQUEST:
     * - text - string - текст сообщения
     *
     * @param int $id  идентификатор заказа gs_users_shop_requests.id
     *
     * @return \yii\web\Response json
     */
    public function actionRequest_list_item_answer_pay($id)
    {
        return $this->sendStatus($id, Request::STATUS_PAID_SHOP);
    }

    /**
     * AJAX
     * Отправляет сообщение для клиента: Заказ выполнен
     *
     * REQUEST:
     * - text - string - текст сообщения
     *
     * @param int $id  идентификатор заказа gs_users_shop_requests.id
     *
     * @return \yii\web\Response json
     */
    public function actionRequest_list_item_send($id)
    {
        return $this->sendStatus($id, Request::STATUS_SEND_TO_USER);
    }

    /**
     * AJAX
     * Отправляет сообщение для клиента: Заказ выполнен
     *
     * REQUEST:
     * - text - string - текст сообщения
     *
     * @param int $id  идентификатор заказа gs_users_shop_requests.id
     *
     * @return \yii\web\Response json
     */
    public function actionRequest_list_item_done($id)
    {
        return $this->sendStatus($id, Request::STATUS_FINISH_SHOP);
    }

    /**
     * Заготовка для отправки статуса с сообщением
     *
     * REQUEST:
     * - text - string - текст сообщения
     *
     * @param int $id  идентификатор заказа gs_users_shop_requests.id
     * @param int $status  статус
     *
     * @return \yii\web\Response json
     */
    private function sendStatus($id, $status)
    {
        $text = self::getParam('text');
        $request = Request::find($id);
        if ($request->getField('user_id') != Yii::$app->user->id) {
            return self::jsonErrorId(101, 'Это не ваш заказ');
        }
        $request->addStatusToClient([
            'message' => $text,
            'status'  => $status,
        ]);

        return self::jsonSuccess();
    }
}
