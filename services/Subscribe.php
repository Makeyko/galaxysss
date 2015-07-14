<?php
/**
 * Created by PhpStorm.
 * User: prog3
 * Date: 01.07.15
 * Time: 18:20
 */

namespace app\services;


use app\models\SiteContentInterface;
use app\models\SubscribeMailItem;
use app\models\User;
use yii\db\Query;
use yii\helpers\Url;

class Subscribe
{
    const TYPE_NEWS        = 1;
    const TYPE_SITE_UPDATE = 2;

    /**
     * Добавляет записи для рассылки в таблицу рассылки
     *
     * @param SiteContentInterface $subscribeItem тема письма
     */
    public static function add(SiteContentInterface $item)
    {
        $subscribeItem = $item->getMailContent();
        switch ($subscribeItem->type) {
            case self::TYPE_NEWS:
                $where = ['subscribe_is_news' => 1];
                break;
            case self::TYPE_SITE_UPDATE:
                $where = ['subscribe_is_site_update' => 1];
                break;
        }

        $emailList = User::query($where)
            ->select('email')
            ->andWhere(['not', ['email' => null]])
            ->andWhere([
                'is_active'  => 1,
                'is_confirm' => 1,
            ])
            ->column();

        $rows = [];
        foreach ($emailList as $email) {
            $urlUnSubscribe = Url::to(['subscribe/unsubscribe', 'mail' => $email, 'type' => $subscribeItem->type, 'hash' => self::hashGenerate($email, $subscribeItem->type)], true);
            $rows[] = [
                str_replace('{linkUnsubscribe}', $urlUnSubscribe, $subscribeItem->text),
                str_replace('{linkUnsubscribe}', $urlUnSubscribe, $subscribeItem->html),
                $subscribeItem->subject,
                $email,
                time(),
            ];
        }
        \Yii::info($rows, 'gs\\subscribe');
        if (count($rows) > 0) {
            SubscribeMailItem::batchInsert([
                'text',
                'html',
                'subject',
                'mail',
                'date_insert',
            ], $rows);
        }
    }

    /**
     * Генерирует hash для ссылки отписки
     *
     * @param string  $email почта клиента
     * @param integer $type  имп рассылки \app\services\Subscribe::TYPE_*
     *
     * @return string
     *
     */
    public static function hashGenerate($email, $type)
    {
        return md5($email . '_' . $type);
    }

    /**
     * Проверяет hash для ссылки отписки
     *
     * @param string  $email почта клиента
     * @param integer $type  имп рассылки \app\services\Subscribe::TYPE_*
     * @param integer $hash
     *
     * @return boolean
     * true - верный
     * false - не верный
     */
    public static function hashValidate($email, $type, $hash)
    {
        return md5($email . '_' . $type) == $hash;
    }
}