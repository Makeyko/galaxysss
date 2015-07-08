<?php


namespace app\models;


class SiteUpdate extends \cs\base\DbRecord
{
    const TABLE = 'gs_site_update';

    public static function insert($fields)
    {
        $fields['date_insert'] = time();

        return parent::insert($fields);
    }

    /**
     * Добавляет обновление в виде объекта SiteUpdateItem
     *
     * @param SiteContentInterface $item
     *
     * @return static
     */
    public static function add(SiteContentInterface $item)
    {
        $item = $item->getSiteUpdateItem();
        return self::insert([
            'name'  => $item->name,
            'image' => $item->image,
            'link'  => $item->link,
        ]);
    }
}