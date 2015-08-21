<?php
/**
 * Объект для элемента обновления сайта
 */

namespace app\models;


class SiteUpdateItem
{
    const TYPE_CHANNELING = 1;
    const TYPE_NEWS_ITEM  = 2;
    const TYPE_ARTICLE    = 3;
    const TYPE_CATEGORY   = 4;
    const TYPE_EVENT      = 5;
    const TYPE_PRAKTICE   = 6;
    const TYPE_SERVICE    = 7;

    public $name;
    public $image;
    public $link;
    public $type;

    public static $names = [
        self::TYPE_CHANNELING => 'Послание',
        self::TYPE_NEWS_ITEM  => 'Новость',
        self::TYPE_ARTICLE    => 'Статья',
        self::TYPE_CATEGORY   => 'Категория',
        self::TYPE_EVENT      => 'Событие',
        self::TYPE_PRAKTICE   => 'Практика',
    ];
}