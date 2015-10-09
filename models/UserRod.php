<?php

namespace app\models;

use app\services\Subscribe;
use cs\Application;
use cs\services\VarDumper;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class UserRod extends \cs\base\DbRecord
{
    const TABLE = 'gs_users_rod';

    public static $kolenoStart = [
        1 => 1, 3, 7, 15, 31, 63, 127, 255
    ];

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
        for ($i = 1; $i <= 7; $i++) {
            if ($rodId < (pow(2, $i + 1) - 1) and $rodId >= (pow(2, $i) - 1)) {
                return $i + 1;
            }
        }

        return null;
    }

    public function getImage($isScheme = false)
    {
        $url = $this->getField('image', '');
        if ($url == '') {
            if ($this->getGender() == 1) {
                $url = '/images/passport/tree/mail.jpg';
            } else {
                $url = '/images/passport/tree/female.jpg';
            }
        }

        if ($isScheme){
            return Url::to($url, $isScheme);
        } else {
            return $url;
        }
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
        return (($rodId % 2) == 1) ? 0 : 1;
    }

    /**
     *
     */
    public function getGender()
    {
        return self::calcGender($this->getRodId());
    }

    /**
     *
     */
    public function getKoleno()
    {
        return self::calcKolenoId($this->getRodId());
    }

    /**
     * Выдает степень родства
     */
    public function getRodstvo()
    {
        $r = [
            1=>['я', 'я'],
            ['Мама', 'Папа'],
            ['Бабушка', 'Дедушка'],
            ['ПраБабушка', 'ПраДедушка'],
            ['ПраПраБабушка', 'ПраПраДедушка'],
            ['ПраПраПраБабушка', 'ПраПраПраДедушка'],
            ['ПраПраПраПраБабушка', 'ПраПраПраПраДедушка'],
        ];

        return $r[$this->getKoleno()][$this->getGender()];
    }

    /**
     * Возвращает идентификатор рода
     */
    public function getRodId()
    {
        return $this->getField('rod_id', null);
    }


    /**
     * Возвращает родословную от человека указанного в модели до Я (чей род)
     *
     * @return array первый идет прямой родитель Я, потом прародитель вплоть до того кто указан в модели
     * [
     *   [
     *      'name' => string, (если имя не указано или не заполнены данные о человеке, то здесь = null)
     *      'id'   => int, идентификатор рода
     *   ], ...
     * ]
     *
     */
    public function getRodPath()
    {
        $ret = [];
        $ret[] = [
            'id'   => $this->getRodId(),
            'name' => $this->getName(),
        ];
        $path = $this->getRodPathCircle($this->getRodId());

        return ArrayHelper::merge($path, $ret);
    }

    /**
     * Возвращает всех детей выше
     * Возвращает родословную от человека указанного в модели до Я (чей род)
     *
     * @param int $id
     *
     * @return array
     * [
     *   [
     *      'name' => string, (если имя не указано или не заполнены данные о человеке, то здесь = null)
     *      'id'   => int, идентификатор рода
     *   ], ...
     * ]
     */
    private function getRodPathCircle($id)
    {
        $ret = [];
        $childId = self::calcChild($id);
        if ($childId == 0) {
            return $ret;
        } else {
            $class = self::find([
                'user_id' => $this->getField('user_id'),
                'rod_id'  => $childId,
            ]);

            if (is_null($class)) {
                $ret[] = [
                    'id'   => $childId,
                    'name' => null,
                ];
                $class = new self([
                    'user_id' => $this->getField('user_id'),
                    'rod_id'  => $childId,
                ]);
            } else {
                $ret[] = [
                    'id'   => $childId,
                    'name' => $class->getName()
                ];
            }
            $path = $class->getRodPathCircle($childId);

            return ArrayHelper::merge($path, $ret);
        }
    }

    public function getName()
    {
        return $this->getField('name_first');
    }

    /**
     * Вычисляет идентификатор ребенка
     *
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