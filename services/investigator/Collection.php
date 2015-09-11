<?php

namespace app\services\investigator;


class Collection
{
    /**
     * @var  array
     * [[
     *   'name'  => 'tasachena',
     *   'title' => 'Тасачена.org',
     *   'class' => 'app\services\GetArticle\Tasachena',
     * ],...]
     */
    public $items;

    public function getItems()
    {
        if (is_null($this->items)) {
            $this->items = require('config.php');
        }

        return $this->items;
    }

    /**
     * Возвращает конфиг Экстрактора по идентификатору
     *
     * @param string $id
     *
     * @return null|array
     * like:
     * [
     *   'name'  => 'tasachena',
     *   'title' => 'Тасачена.org',
     *   'class' => 'app\services\GetArticle\Tasachena',
     * ]
     */
    public static function find($id)
    {
        $items = self::getList();
        foreach($items as $item) {
            if ($item['name'] == $id) {
                return $item;
            }
        }
        return null;
    }

    public static function getList()
    {
        $class = new static();

        return $class->getItems();
    }
}