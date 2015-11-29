<?php

namespace app\modules\Shop\services;

use app\models\Shop\Product;
use yii\base\Object;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

/**
 * Class Basket
 * @package app\modules\Shop\services
 *
 * [
 *    [
 *      'id'    => 1,
 *      'count' => 1,
 *    ]
 * ]
 */
class Basket extends Object
{
    const SESSION_KEY = 'basket';

    /**
     * Добавляет продукт в корзину
     * @param  int | array $item товар для добавления, идентификтор или товар
     * @return int количество типов товаров
     */
    public static function add($item)
    {
        if ($item instanceof Product) {
            $item = $item->getId();
        }
        $i = self::find($item);
        if (is_null($i)) {
            $arr = self::get();
            $arr[] = [
                'id'    => $item,
                'count' => 1,
            ];
            self::set($arr);
        } else {
            $arr = self::get();
            for ($j = 0; $j < count($arr); $j++) {
                if ($arr[ $j ]['id'] == $item) {
                    $arr[ $j ]['count']++;
                }
            }
            self::set($arr);
        }

        return count($arr);
    }

    /**
     * Ищет товар в корзине
     * @param int $id
     * @return array | null
     */
    public static function find($id)
    {
        foreach (self::get() as $item) {
            if ($item['id'] == $id) return $item;
        }

        return null;
    }

    public static function get()
    {
        $v = \Yii::$app->session->get(self::SESSION_KEY);
        return (is_null($v)) ? [] : $v;
    }

    public static function set($arr)
    {
        \Yii::$app->session->set(self::SESSION_KEY, $arr);
    }

    public static function getCount()
    {
        $c = ArrayHelper::getValue($_SESSION, self::SESSION_KEY, []);

        return count($c);
    }


}