<?php


namespace app\services;

use \yii\db\Query;

class RegistrationDispatcher extends \cs\services\dispatcher\Registration
{
    const TABLE = 'gs_users_registration';

    public static function cron($isEcho = true)
    {
        $ids = (new Query())->select('parent_id')->from(static::TABLE)->where(['<', 'date_finish', gmdate('YmdHis')])->column();
        if (count($ids) > 0) {
            \Yii::info(\yii\helpers\VarDumper::dumpAsString($ids), 'gs\\app\\services\\RegistrationDispatcher::cron');
            \app\models\User::deleteByCondition(['in', 'id', $ids]);
        }

        parent::cron($isEcho);
    }
}