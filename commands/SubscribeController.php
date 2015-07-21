<?php

namespace app\commands;

use app\models\SubscribeMailItem;
use yii\console\Controller;
use yii\console\Response;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;

/**
 * Занимается рассылкой писем
 */
class SubscribeController extends Controller
{
    /**
     * Делает рассылку писем из списка рассылки
     */
    public function actionSend()
    {
        $key = 'app\\commands\\SubscribeController::actionSend';
        $isCache = \Yii::$app->cache->get($key);
        if ($key !== false) {
            \Yii::$app->cache->set($key, true, 60*60);
            $time = microtime(true);
            $list = SubscribeMailItem::query()
                ->limit(10)
                ->orderBy(['date_insert' => SORT_DESC])
                ->all();
            if (count($list) > 0) {
                \Yii::info('Всего писем для рассылки: ' . count($list), 'gs\\app\\commands\\SubscribeController::actionSend');
                \Yii::info('Список писем: ' . VarDumper::dumpAsString(ArrayHelper::getColumn($list, 'mail')), 'gs\\app\\commands\\SubscribeController::actionSend');

                foreach($list as $mailItem) {
                    \Yii::$app->mailer
                        ->compose()
                        ->setFrom(\Yii::$app->params['mailer']['from'])
                        ->setTo($mailItem['mail'])
                        ->setSubject($mailItem['subject'])
                        ->setTextBody($mailItem['text'])
                        ->setHtmlBody($mailItem['html'])
                        ->send();
                }

                \Yii::info('Список писем для удаления: ' . VarDumper::dumpAsString(ArrayHelper::getColumn($list, 'id')), 'gs\\app\\commands\\SubscribeController::actionSend');
                SubscribeMailItem::deleteByCondition([
                    'in', 'id', ArrayHelper::getColumn($list, 'id')
                ]);
                \Yii::info('Осталось после рассылки: ' . SubscribeMailItem::query()->count(), 'gs\\app\\commands\\SubscribeController::actionSend');
                $time = microtime(true) - $time;
                \Yii::info('Затраченное время на расылку: ' . $time, 'gs\\app\\commands\\SubscribeController::actionSend');
            }
        }

        \Yii::$app->end();
    }
}
