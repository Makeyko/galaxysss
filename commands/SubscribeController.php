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
        $list = SubscribeMailItem::query()->limit(100)->orderBy(['date_insert' => SORT_DESC])->all();

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

        SubscribeMailItem::deleteByCondition([
            'in', 'id', ArrayHelper::getColumn($list, 'id')
        ]);

        \Yii::info('Рассылка писем ' . VarDumper::dumpAsString(ArrayHelper::getColumn($list, 'id')), 'gs\\subscribe');

        \Yii::$app->end();
    }
}
