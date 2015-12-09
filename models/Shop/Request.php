<?php

namespace app\models\Shop;

use app\models\Union;
use app\models\User;
use app\services\Subscribe;
use cs\services\BitMask;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class Request extends \cs\base\DbRecord
{
    const TABLE = 'gs_users_shop_requests';

    const STATUS_USER_NOT_CONFIRMED = 1; // Пользователь заказал с регистрацией пользователя, но не подтвердил своб почту еще
    const STATUS_SEND_TO_SHOP = 2;       // заказ отправлен в магазин
    const STATUS_ORDER_DOSTAVKA = 3;     // клиенту выставлен счет с учетом доставки
    const STATUS_PAID_CLIENT = 5;        // заказ оплачен со стороны клиента
    const STATUS_PAID_SHOP = 6;          // оплата подтверждена магазином
    const STATUS_SEND_TO_USER = 7;       // заказ отправлен клиенту
    const STATUS_FINISH_CLIENT = 10;     // заказ исполнен, как сообщил клиент
    const STATUS_FINISH_SHOP = 11;       // заказ исполнен, магазин сам указал этот статут по своим данным

    const DIRECTION_TO_CLIENT = 1;
    const DIRECTION_TO_SHOP = 2;


    public static $statusList = [
        self::STATUS_USER_NOT_CONFIRMED => [
            'client'  => '',
            'shop'  => 'Пользователь не подтвердил почту',
            'style' => 'default',
        ],
        self::STATUS_SEND_TO_SHOP       => [
            'client'   => 'Отпрален в магазин',
            'shop'     => 'Пользователь отправил заказ',
            'style'    => 'primary',
            'timeLine' => [
                'icon'  => 'glyphicon-chevron-right',
                'color' => 'default',
            ],
        ],
        self::STATUS_ORDER_DOSTAVKA       => [
            'client'   => 'Выставлен счет с учетом доставки',
            'shop'     => 'Клиенту выставлен счет с учетом доставки',
            'style'    => 'primary',
            'timeLine' => [
                'icon'  => 'glyphicon-credit-card',
                'color' => 'warning',
            ],
        ],
        self::STATUS_PAID_SHOP       => [
            'client'   => 'Оплата подтверждена',
            'shop'     => 'Оплата подтверждена',
            'style'    => 'primary',
            'timeLine' => [
                'icon'  => 'glyphicon-credit-card',
                'color' => 'success',
            ],
        ],
        self::STATUS_PAID_CLIENT       => [
            'client'   => 'Оплата подтверждена',
            'shop'     => 'Оплата подтверждена',
            'style'    => 'primary',
            'timeLine' => [
                'icon'  => 'glyphicon-credit-card',
                'color' => 'success',
            ],
        ],
        self::STATUS_FINISH_SHOP       => [
            'client'   => 'Заказ выполнен',
            'shop'     => 'Заказ выполнен',
            'style'    => 'success',
            'timeLine' => [
                'icon'  => 'glyphicon-thumbs-up',
                'color' => 'success',
            ],
        ],
        self::STATUS_FINISH_CLIENT       => [
            'client'   => 'Заказ выполнен',
            'shop'     => 'Заказ выполнен',
            'style'    => 'success',
            'timeLine' => [
                'icon'  => 'glyphicon-thumbs-up',
                'color' => 'success',
            ],
        ],
    ];

    /**
     * @param array $fields
     * @return \app\models\Shop\Request
     */
    public static function insert($fields = [])
    {
        if (!isset($fields['user_id'])) {
            $fields['user_id'] = \Yii::$app->user->id;
        }
        $fields['date_create'] = time();

        return parent::insert($fields);
    }

    /**
     * Добавить статус
     *
     * @param int | array $status статус self::STATUS_* или массив со статусом и сообщением
     * @param int $direction направление сообщения self::DIRECTION_*
     *
     * @return \app\models\Shop\RequestMessage
     */
    public function addStatus($status, $direction)
    {
        if (!is_array($status)) {
            $fields = [
                'status' => $status,
            ];
        } else {
            $fields = $status;
        }

        return $this->addMessageItem($fields, $direction);
    }

    /**
     * Добавить статус к клиенту
     *
     * @param int | array $status статус self::STATUS_* или массив со статусом и сообщением
     *
     * @return \app\models\Shop\RequestMessage
     */
    public function addStatusToClient($status)
    {
        if (!is_array($status)) {
            $fields = [
                'status' => $status,
            ];
        } else {
            $fields = $status;
        }

        return $this->addMessageItem($fields, self::DIRECTION_TO_CLIENT);
    }

    /**
     * Добавить статус в магазин
     *
     * @param int | array $status статус self::STATUS_* или массив со статусом и сообщением
     *
     * @return \app\models\Shop\RequestMessage
     */
    public function addStatusToShop($status)
    {
        if (!is_array($status)) {
            $fields = [
                'status' => $status,
            ];
        } else {
            $fields = $status;
        }

        return $this->addMessageItem($fields, self::DIRECTION_TO_SHOP);
    }

    /**
     * Добавить сообщение
     *
     * @param string $message сообщение
     * @param int $direction направление сообщения self::DIRECTION_*
     *
     * @return \app\models\Shop\RequestMessage
     */
    public function addMessage($message, $direction)
    {
        return $this->addMessageItem([
            'message' => $message,
        ], $direction);
    }

    /**
     * Добавить сообщение для клиента
     *
     * @param string $message сообщение
     *
     * @return \app\models\Shop\RequestMessage
     */
    public function addMessageToClient($message)
    {
        return $this->addMessage($message, self::DIRECTION_TO_CLIENT);
    }

    /**
     * Добавить сообщение для клиента
     *
     * @param string $message сообщение
     *
     * @return \app\models\Shop\RequestMessage
     */
    public function addMessageToShop($message)
    {
        return $this->addMessage($message, self::DIRECTION_TO_SHOP);
    }

    /**
     * Добавить сообщение или статус
     *
     * @param array $fields поля для сообщения
     * @param int   $direction направление сообщения self::DIRECTION_*
     *
     * @return \app\models\Shop\RequestMessage
     */
    public function addMessageItem($fields, $direction)
    {
        $fieldsRequest = [
            'is_answer_from_shop'   => ($direction == self::DIRECTION_TO_CLIENT)? 1 : 0,
            'is_answer_from_client' => ($direction == self::DIRECTION_TO_CLIENT)? 0 : 1,
        ];
        if (isset($fields['status'])) {
            $fieldsRequest['status'] = $fields['status'];
        }
        $this->update($fieldsRequest);

        return RequestMessage::insert(ArrayHelper::merge($fields, [
            'request_id' => $this->getId(),
            'direction'  => $direction,
            'datetime'   => time(),
        ]));
    }

    /**
     * Добавляет заказ
     *
     * @param $fields array поля заказа
     * @param $productList array список продуктов в заказе
     * [
     *    [
     * 'id'     => int,
     * 'count'  => int,
     *    ], ...
     * ]
     * @return self
     */
    public static function add($fields, $productList, $status = self::STATUS_SEND_TO_SHOP)
    {
        $request = self::insert($fields);
        foreach ($productList as $item) {
            RequestProduct::insert([
                'request_id' => $request->getId(),
                'product_id' => $item['id'],
                'count'      => $item['count'],
            ]);
        }
        $message = $request->addStatus($status, self::DIRECTION_TO_SHOP);

        return $request;
    }

    /**
     * Возвращает заготовку запроса для списка товаров для заказа
     * gs_unions_shop_product.*
     *
     * @return \yii\db\Query
     */
    public function getProductList()
    {
        return RequestProduct::query(['request_id' => $this->getId()])
            ->select([
                'gs_unions_shop_product.*',
                'gs_users_shop_requests_products.count',
            ])
            ->innerJoin('gs_unions_shop_product', 'gs_unions_shop_product.id = gs_users_shop_requests_products.product_id');
    }

    /**
     * Возвращает заготовку запроса для сообщений для заказа
     * gs_users_shop_requests_messages.*
     *
     * @return \yii\db\Query
     */
    public function getMessages()
    {
        return RequestMessage::query(['request_id' => $this->getId()]);
    }

    /**
     * Возвращает объединение на которое оформлен заказ
     *
     * @return \app\models\Union
     */
    public function getUnion()
    {
        return Union::find($this->getField('union_id'));
    }

    /**
     * Возвращает объект клиента
     *
     * @return \app\models\User | null
     */
    public function getUser()
    {
        return User::find($this->getField('user_id'));
    }

    /**
     * Возвращает объект клиента
     *
     * @return \app\models\User | null
     */
    public function getClient()
    {
        return $this->getUser();
    }
}