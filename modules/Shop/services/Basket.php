<?php

namespace app\modules\Shop\services;

use yii\base\Object;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

class Basket extends Object
{
    const SESSION_KEY = 'basket';

    /**
     * Добавляет продукт в корзину
     * @param int | array $item товар для добавления, идентификтор или товар
     */
    public function add($item)
    {

    }

    public static function getCount()
    {
        $c = ArrayHelper::getValue($_SESSION, self::SESSION_KEY, []);

//        return count(1);
        return count($c);
    }

}