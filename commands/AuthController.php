<?php

namespace app\commands;

use app\models\SubscribeMailItem;
use yii\console\Controller;
use yii\console\Response;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;

/**
 * Занимается обслуживанием авторизации
 */
class AuthController extends Controller
{
    /**
     * Делает рассылку писем из списка рассылки
     */
    public function actionClear_registration()
    {
        \app\services\RegistrationDispatcher::cron();
    }
}
