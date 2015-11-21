<?php

namespace app\services;
use cs\services\VarDumper;

/**
 * В таблице gs_users есть поле last_action, которое сохраняет последнее действие пользователя. Чтобы не записывать
 * каждый раз, оно записывается раз в пять минут. По этому полю можно смотреть когда последний раз пользователь был в
 * сети и таким образом можно показывать какие материалы добавились за последнее время.
 */
class UserLastActive
{
    const SESSION_KEY = 'lastUserActionSave';

    /**
     * Вызывается на каждый запрос пользователя
     */
    public static function update()
    {
        $session = \Yii::$app->session;
        $lastSave = $session->get(self::SESSION_KEY);
        $isNeedUpdate = false;
        $now = time();
        if ($lastSave) {
            // Если более пяти минут не сохранял то сохраняю
            if (($now - $lastSave) > 60 * 5) {
                $isNeedUpdate = true;
            }
        } else {
            $isNeedUpdate = true;
        }

        if ($isNeedUpdate) {
            $session->set(self::SESSION_KEY, $now);
            self::updateNow();
        }
    }

    public static function updateNow()
    {
        $now = time();
        /** @var \app\models\User $user */
        $user = \Yii::$app->user->identity;
        $user->update(['last_action' => $now]);
    }
} 