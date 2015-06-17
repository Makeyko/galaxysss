<?php


namespace app\services;

use \yii\db\Query;

class RegistrationDispatcher extends \cs\services\dispatcher\Registration
{
    const TABLE = 'gs_users_registration';

    public static function cron($isEcho = true)
    {
        $ids = (new Query())->select('parent_id')->from(static::TABLE)->where(['<', 'date_finish', gmdate('YmdHis')])->column();
        \app\models\User::deleteByCondition(['in', 'id', $ids]);

        parent::cron($isEcho);
    }
}