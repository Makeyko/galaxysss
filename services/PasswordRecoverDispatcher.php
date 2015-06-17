<?php


namespace app\services;

use \yii\db\Query;

class PasswordRecoverDispatcher extends \cs\services\dispatcher\PasswordRecovery
{
    const TABLE = 'gs_users_recover';
}