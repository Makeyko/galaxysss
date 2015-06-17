<?php


namespace app\models;


use yii\helpers\ArrayHelper;

class UnionCategory extends \cs\base\DbRecord
{
    const TABLE = 'gs_unions_tree';

    /**
     * @return array gs_unions.*
     */
    public function getUnions()
    {
        return Union::query([
            'tree_node_id'      => $this->getId(),
            'moderation_status' => 1,
        ])
            ->orderBy(['sort_index' => SORT_ASC])
            ->orderBy([
                'if(sort_index is NULL, 1, 0)' => SORT_ASC,
                'sort_index'                   => SORT_ASC,
            ])
            ->all();
    }

    /**
     * @return array
     * [
     *    'id' => 'string', ...
     * ]
     */
    public static function getRootList()
    {
        return ArrayHelper::map(self::query(['parent_id' => null])->select('id, header')->all(), 'id', 'header');
    }

    /**
     * Выдает список категорий определенной категории
     *
     * @param int|null     $id     идентификатор категории
     * @param string|array $select поля для выборки
     *
     * @return array
     */
    public static function getRows($id = null, $select = '*')
    {
        return self::query([
            'parent_id' => $id,
        ])
            ->select($select)
            ->orderBy([
                'if(sort_index is NULL, 1, 0)' => SORT_ASC,
                'sort_index'                   => SORT_ASC,
            ])
            ->all();
    }
}