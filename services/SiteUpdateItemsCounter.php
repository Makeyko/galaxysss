<?php

namespace app\services;

use app\models\SiteUpdate;
use cs\services\VarDumper;

/**
 * Вычисляет сколько документов было добавлено за время отсутствия пользователя на сайте и сохраняет в сессию
 */
class SiteUpdateItemsCounter
{
    const SESSION_KEY = 'siteUpdateItemsCounter';

    /**
     * Расчитывет значение счетчика
     * Если будет запущено второй раз за сессию то вычисление происходить не будут
     */
    public static function calc()
    {
        if (\Yii::$app->session->get(self::SESSION_KEY, false) === false) {
//            \Yii::$app->user->identity->update(['last_action'=>1437745335]);
            $lastAction = \Yii::$app->user->identity->getField('last_action');
            $count = 0;
            if ($lastAction) {
                $count = SiteUpdate::query(['>', 'date_insert', $lastAction])->count();
            } else {
                $count = 0;
            }
            \Yii::$app->session->set(self::SESSION_KEY, $count);
        }
    }

    /**
     * Получает значение счетчика
     * @return integer
     */
    public static function getValue()
    {
        return \Yii::$app->session->get(self::SESSION_KEY);
    }

    /**
     * Сбрасывает значение в ноль
     */
    public static function clear()
    {
        \Yii::$app->session->set(self::SESSION_KEY, 0);
    }
} 