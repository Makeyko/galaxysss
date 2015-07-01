<?php
/**
 * Created by PhpStorm.
 * User: prog3
 * Date: 01.07.15
 * Time: 18:20
 */

namespace app\services;


use app\models\SubscribeMailItem;
use app\models\User;
use yii\db\Query;

class Subscribe
{
    const TYPE_NEWS        = 1;
    const TYPE_SITE_UPDATE = 2;

    /**
     * Добавляет записи для рассылки в таблицу рассылки
     *
     * @param \app\models\SubscribeItem $subscribeItem тема письма
     */
    public static function add($subscribeItem)
    {
        switch ($subscribeItem->type) {
            case self::TYPE_NEWS:
                $where = ['subscribe_is_news' => 1];
                break;
            case self::TYPE_SITE_UPDATE:
                $where = ['subscribe_is_site_update' => 1];
                break;
        }

        $emailList = User::query($where)->select('email')->column();

        $rows = [];
        foreach ($emailList as $email) {
            $rows[] = [
                $subscribeItem->text,
                $subscribeItem->html,
                $subscribeItem->subject,
                $email,
                gmdate('YmdHis'),
            ];
        }
        SubscribeMailItem::batchInsert([
            'text',
            'html',
            'subject',
            'mail',
            'date_insert',
        ], $rows);
    }
} 