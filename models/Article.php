<?php

namespace app\models;

use cs\services\BitMask;

class Article extends \cs\base\DbRecord
{
    const TABLE = 'gs_article_list';

    public function incViewCounter()
    {
        $this->update(['view_counter' => $this->getField('view_counter') + 1]);
    }

    /**
     * Выдает элементы которые соответствуют определенной категории
     *
     * @param int $id идентификатор категории
     *
     * @return array
     */
    public static function getByTreeNodeId($id)
    {
        return self::query(['&', 'tree_node_id_mask', (new BitMask([$id]))->getMask()])
            ->orderBy(['date_insert' => SORT_DESC])
            ->select('id,header,id_string,image,view_counter,description')
            ->all();
    }
}