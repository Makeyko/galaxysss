<?php

namespace cs\base;

use yii\db\Query;
use yii\helpers\VarDumper;

class Action extends \cs\models\DbRecord
{
    const STATUS_SEND_TO_ORG = 1;
    const STATUS_ACCEPT      = 2;
    const STATUS_REJECT      = 3;
    const STATUS_APPEALED    = 4;

    /**
     * Список статусов сообщения
     * @var array
     */
    public static $statusAll = [
        self::STATUS_SEND_TO_ORG => 'Заявка отправлена',
        self::STATUS_ACCEPT      => 'Одобрено',
        self::STATUS_REJECT      => 'Отказано',
        self::STATUS_APPEALED    => 'Обжаловано',
    ];

    /**
     * Возвращает название статуса в виде строки
     *
     * @return string
     * если статус не установлен то будет возвращена пустая строка ''
     */
    public function getStatus()
    {
        $status = $this->setStatusId();
        if (is_null($status)) return '';

        return self::$statusAll[ $status ];
    }

    /**
     * Возвращает статус сообщения
     * @return null | int
     */
    public function setStatusId()
    {
        return $this->getField('status');
    }
}
