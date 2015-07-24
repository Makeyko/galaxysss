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

    public $name;
    public $image;
    public $link;
    public $type;
}