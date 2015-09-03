<?php

namespace cs\services\dispatcher;

use Yii;
use DateTime;
use yii\db\Query;
use cs\services\Security;

/**
 * Класс UserRecover
 *
 * @author Dmitrii Mukhortov <dram1008@yandex.ru>
 */
class Registration implements DispatcherInterface
{
    /** Время жизни кода восстановления в днях */
    public static $liveTime = 7;

    /**
     * Добавляет заявку в диспечер для слежения
     *
     * @param int                 $id         идентификатор заявки
     * @param int                 $code       код
     * @param string|int|DateTime $dateFinish времменой штам в зоне UTC,
     *                                        Если не указано то будет использован параметр $this->liveTime (оно
     *                                        прибавляется к настоящему моменту)
     *
     * @return array
     * [
     * 'date_finish' => str,
     * 'code'        => str,
     * 'parent_id'   => int,
     * ]
     */
    public static function insert($id, $code, $dateFinish = null)
    {
        if (is_null($dateFinish)) {
            $dateFinish = (int)gmdate('U') + (60 * 60 * 24 * static::$liveTime);
        } else {
            if ($dateFinish instanceof DateTime) {
                $dateFinish = $dateFinish->format('U');
            } else if (is_string($dateFinish)) {
                $dateFinish = (new DateTime($dateFinish, new \DateTimeZone('UTC')))->format('U');
            }
        }
        $fields = [
            'date_finish' => gmdate('Y-m-d H:i:s', $dateFinish),
            'code'        => $code,
            'parent_id'   => $id,
        ];
        (new Query())->createCommand()->insert(static::TABLE, $fields)->execute();

        return $fields;
    }

    /**
     * Добавляет запись генерируя код и возвращая его
     *
     * @param $id
     *
     * @return array
     * [
     * 'date_finish' => str,
     * 'code'        => str,
     * 'parent_id'   => int,
     * ]
     */
    public static function add($id)
    {
        $code = Security::generateRandomString(60);
        $fields = self::insert($id, $code);

        return $fields;
    }

    /**
     * Удаляет заявку из диспечера
     *
     * @param int $id идентификатор заяаки
     *
     * @return bool
     */
    public static function delete($id)
    {
        (new Query())->createCommand()->delete(static::TABLE, [
            'parent_id' => $id,
        ])->execute();
    }

    /**
     * Функция для крона
     * Удаляет просроченные восстановления пароля
     * Рекомендация к исполнению: каждые 24 часа
     *
     * @param bool $isEcho выводить в поток вывода информационные сообщения?
     */
    public static function cron($isEcho = true)
    {
        $count = (new Query())->createCommand()->delete(static::TABLE, ['<', 'date_finish', gmdate('YmdHis')])->execute();
        if ($isEcho) echo 'Удалено строк: ' . $count;
    }

    /**
     * @param null  $condition
     * @param array $params
     *
     * @return Query
     */
    public static function query($condition = null, $params = [])
    {
        $query = (new Query())->select('*')->from(static::TABLE);
        if (!is_null($condition)) $query->where($condition, $params);

        return $query;
    }

}
