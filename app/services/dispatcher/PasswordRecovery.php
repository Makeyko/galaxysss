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
class PasswordRecovery implements DispatcherInterface
{
    /** Время жизни кода восстановления в днях */
    public static $liveTime = 7;

    /**
     * Добавляет заявку в диспечер для слежения.
     * Если запись уже была добавлена то она обновляется
     *
     * @param int                 $id         идентификатор заявки
     * @param string              $code       код
     * @param string|int|DateTime $dateFinish времменой штам в зоне UTC,
     *                                        Если не указано то будет использован параметр $this->liveTime (оно прибавляется к настоящему моменту)
     *
     * @return array|false
     */
    public static function insert($id, $code = null, $dateFinish = null)
    {
        if (is_null($dateFinish)) {
            $dateFinish = time() + (60 * 60 * 24 * static::$liveTime);
        }
        else {
            if ($dateFinish instanceof DateTime) {
                $dateFinish = $dateFinish->format('U');
            }
            else if (is_string($dateFinish)) {
                $dateFinish = (new DateTime($dateFinish, new \DateTimeZone('UTC')))->format('U');
            }
        }
        if (is_null($code)) {
            $code = Security::generateRandomString(50);
        }
        $fields = [
            'date_finish' => gmdate('Y-m-d H:i:s', $dateFinish),
            'code'        => $code,
        ];
        if ((new Query())->select('*')->from(static::TABLE)->where(['parent_id' => $id])->exists()) {
            (new Query())->createCommand()->update(static::TABLE, $fields, ['parent_id' => $id])->execute();
            $fields['parent_id'] = $id;
        }
        else {
            $fields['parent_id'] = $id;
            (new Query())->createCommand()->insert(static::TABLE, $fields)->execute();
        }

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
        $count = (new Query())->createCommand()->delete(static::TABLE, 'date_finish < :now', [':now' => gmdate('YmdHis')])->execute();
        if ($isEcho) echo 'Удалено строк: ' . $count;
    }

    /**
     * Возвращает заготовку Query
     *
     * @param null|string|array $condition
     * @param array             $params
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
