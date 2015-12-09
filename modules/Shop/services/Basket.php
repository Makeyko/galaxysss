<?php

namespace app\modules\Shop\services;

use app\models\Shop\Product;
use cs\services\VarDumper;
use yii\base\Object;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

/**
 * Class Basket
 * @package app\modules\Shop\services
 *
 * $_SESSION[Basket::SESSION_KEY]
 * [
 *    [
 *      'id'       => 1,
 *      'count'    => 1,
 *      'union_id' => 1,
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
        if (!($item instanceof Product)) {
            $item = Product::find($item);
        }
        $i = self::find($item->getId());
        if (is_null($i)) {
            $arr = self::get();
            $arr[] = [
                'id'       => $item->getId(),
                'count'    => 1,
                'union_id' => $item->getField('union_id'),
            ];
            self::set($arr);
        } else {
            $arr = self::get();
            for ($j = 0; $j < count($arr); $j++) {
                if ($arr[ $j ]['id'] == $item->getId()) {
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

    /**
     * Выдает массив наименований товаров с их количеством
     *
     * @param int $id фильтр, идентификатор объединения
     *
     * @return array
     * [
     *    [
     *      'id'       => 1,
     *      'count'    => 1,
     *      'union_id' => 1,
     *    ], ...
     * ]
     */
    public static function get($id = null)
    {
        $v = \Yii::$app->session->get(self::SESSION_KEY);
        $v = (is_null($v)) ? [] : $v;
        if (is_null($id)) return $v;
        $arr = [];
        foreach($v as $i) {
            if ($i['union_id'] == $id) {
                $arr[] = $i;
            }
        }
        return $arr;
    }

    /**
     * Выдает массив идентификаторов товаров
     * @return array
     */
    public static function getIds()
    {
        $arr = self::get();
        $ret = [];
        foreach($arr as $i) {
            $ret[] = $i['id'];
        }

        return $ret;
    }

    /**
     * Выдает массив идентификаторов объединений
     * @return array
     * [
     *     union_id => <кол-во наименований товаров>
     * ]
     */
    public static function getUnionCount()
    {
        $arr = self::get();
        $ret = [];
        foreach($arr as $i) {
            $ret[] = $i['union_id'];
        }
        $arr2 = array_count_values($ret);

        return $arr2;
    }

    /**
     * Выдает массив идентификаторов объединений
     * @return array
     * [
     *     union_id, ...
     * ]
     */
    public static function getUnionIds()
    {
        $arr = self::getUnionCount();

        return array_keys($arr);
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

    public static  function clear()
    {
        \Yii::$app->session->set(self::SESSION_KEY, []);
    }

}