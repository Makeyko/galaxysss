<?php

namespace cs\services\dispatcher;

use cs\base\DbRecord;
use Yii;
use DateTime;
use yii\db\Query;
use cs\services\Security;

/**
 * Класс EmailChange
 *
 * @author Dmitrii Mukhortov <dram1008@yandex.ru>
 */
class EmailChange extends DbRecord implements DispatcherInterface
{

    /** Время жизни кода восстановления в днях */
    public static $liveTime = 7;

    /**
     * Добавляет заявку в диспечер для слежения
     *
     * @param int $id      идентификатор заявки
     * @param int $newMail код
     * @param int $code    код, не обязательное
     *
     * @return self
     */
    public static function add($id, $newMail, $code = null)
    {
        if (is_null($code)) {
            $code = Security::generateRandomString(60);
        }
        $fields = [
            'date_finish' => time() + 60 * 60 * 24 * self::$liveTime,
            'email'       => $newMail,
            'code'        => $code,
            'parent_id'   => $id,
        ];
        $class = parent::insert($fields);

        return $class;
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
        $count = (new Query())->createCommand()->delete(static::TABLE, ['<', 'date_finish', time()])->execute();
        if ($isEcho) echo 'Удалено строк: ' . $count;
    }
}
