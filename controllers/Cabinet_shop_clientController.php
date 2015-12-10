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

class Cabinet_shop_clientController extends CabinetBaseController
{
    public function actionOrder_item($id)
    {
        return $this->render([
            'request'     => Request::find($id),
        ]);
    }

    public function actionOrders()
    {
        return $this->render([
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
    public function actionOrder_item_message($id)
    {
        $text = self::getParam('text');
        $request = Request::find($id);
        if ($request->getField('user_id') != Yii::$app->user->id) {
            return self::jsonErrorId(101, 'Это не ваш заказ');
        }
        $request->addMessageToShop($text);

        return self::jsonSuccess();
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
        $request->addStatusToShop([
            'message' => $text,
            'status'  => $status,
        ]);

        return self::jsonSuccess();
    }

    /**
     * AJAX
     * Отправляет сообщение для клиента: Заказ получен
     *
     * REQUEST:
     * - text - string - текст сообщения
     *
     * @param int $id  идентификатор заказа gs_users_shop_requests.id
     *
     * @return \yii\web\Response json
     */
    public function actionOrder_item_done($id)
    {
        return $this->sendStatus($id, Request::STATUS_FINISH_CLIENT);
    }

    /**
     * AJAX
     * Отправляет сообщение для клиента: Оплата сделана
     *
     * REQUEST:
     * - text - string - текст сообщения
     *
     * @param int $id  идентификатор заказа gs_users_shop_requests.id
     *
     * @return \yii\web\Response json
     */
    public function actionOrder_item_answer_pay($id)
    {
        return $this->sendStatus($id, Request::STATUS_PAID_CLIENT);
    }

}
