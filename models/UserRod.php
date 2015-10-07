<?php

namespace app\models;

use app\services\Subscribe;
use cs\Application;
use cs\services\VarDumper;
use yii\helpers\Url;

class UserRod extends \cs\base\DbRecord
{
    const TABLE = 'gs_users_rod';

    public static $kolenoStart = [
        1 => 1, 3, 7, 15, 31, 63, 127, 255
    ];

    public static function insert($fields)
    {
        $rodId = $fields['rod_id'];

    }

    /**
     * Вычисляет в каком колене находится человек
     * 1,2 - 1 колено
     * 3,4,5,6 - 2 колено
     * ...
     *
     * @param $rodId
     *
     * @return int|null
     */
    public static function calcKolenoId($rodId)
    {
        for($i = 1; $i <=7; $i++) {
            if ($rodId < (pow(2, $i + 1) - 1) and $rodId >= (pow(2, $i) - 1)) {
                return $i;
            }
        }

        return null;
    }

    /**
     * Вычисляет пол челвека по $rodId
     * 0 - женщина, 1 - мужчина
     *
     * @param $rodId
     *
     * @return int
     */
    public static function calcGender($rodId)
    {
        return (($rodId % 2) == 1)? 0 : 1;
    }

    /**
     * Возвращает идентификатор рода
     */
    public function getRodId()
    {
        return $this->getField('rod_id', null);
    }

    /**
     * Вычисляет идентификатор ребенка
     * @param int $rodId
     * если $rodId < 3 то будет возвращено 0, что означает ребенком является представитель рода
     *
     * @return int
     */
    public static function calcChild($rodId)
    {
        if ($rodId < 3) return 0;
        // вычисляю в каком он колене
        
        $k = null;
        foreach (self::$kolenoStart as $key => $item) {
            if ($item > $rodId) {
                $k = $key;
                break;
            }
        }
        if (is_null($k)) {
            return null;
        }
        // вычисляю номер пары от 0
        $pareIndex = floor(($rodId - self::$kolenoStart[ $k ]) / 2);
        $childId = self::$kolenoStart[ $k - 1 ] + $pareIndex;

        return $childId;
    }


}